// Idle detection and session keep-alive
// Listens to user activity and pings the server to refresh session last_activity_ts

function createHiddenLogoutForm(logoutUrl) {
  const form = document.createElement('form');
  form.style.display = 'none';
  form.method = 'POST';
  form.action = logoutUrl;

  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value;
  if (token) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = '_token';
    input.value = token;
    form.appendChild(input);
  }

  document.body.appendChild(form);
  return form;
}

function startIdleWatcher(options = {}) {
  const idleSeconds = window.SESSION_IDLE_TIMEOUT || 900;
  const warningSeconds = window.IDLE_WARNING_SECONDS || 30;
  const pingUrl = window.PING_URL || '/ping';
  const logoutUrl = window.LOGOUT_URL || '/logout';

  let lastActivity = Date.now();
  let warningTimeout = null;
  let logoutTimeout = null;
  let warningOpen = false;
  let logoutForm = null;

  function resetTimers() {
    lastActivity = Date.now();
    // clear existing timers
    if (warningTimeout) clearTimeout(warningTimeout);
    if (logoutTimeout) clearTimeout(logoutTimeout);

    const msUntilLogout = idleSeconds * 1000;
    const msUntilWarning = Math.max(0, (idleSeconds - warningSeconds)) * 1000;

    warningTimeout = setTimeout(onWarn, msUntilWarning);
    logoutTimeout = setTimeout(onLogout, msUntilLogout);
  }

  async function pingServer() {
    try {
      await fetch(pingUrl, {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
      });
    } catch (e) {
      // ignore ping errors
      console.debug('Ping failed', e);
    }
  }

  function onWarn() {
    warningOpen = true;
    const secondsLeft = warningSeconds;

    // Show a SweetAlert2 modal with countdown and two options
    if (window.Swal) {
      let timerInterval;
      Swal.fire({
        title: 'Sesi akan berakhir',
        html: `Tidak ada aktivitas terdeteksi. Anda akan logout dalam <b>${secondsLeft}</b> detik.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan sesi',
        cancelButtonText: 'Logout sekarang',
        allowOutsideClick: false,
        didOpen: () => {
          const content = Swal.getHtmlContainer();
          const b = content.querySelector('b');
          let timeLeft = secondsLeft;
          timerInterval = setInterval(() => {
            timeLeft -= 1;
            if (b) b.textContent = timeLeft;
            if (timeLeft <= 0) {
              clearInterval(timerInterval);
            }
          }, 1000);
        },
        preConfirm: async () => {
          // user chose to continue session
          await pingServer();
          resetTimers();
        },
      }).then((result) => {
        warningOpen = false;
        if (result.isDismissed || result.isDenied || result.isDismissed) {
          // if user clicked cancel (logout now), perform logout
          if (result.dismiss === Swal.DismissReason.cancel) {
            performLogout();
          }
        }
      });

      // auto-close modal when logout fires
    } else {
      // fallback: if Swal not available, just reset timers when user confirms via prompt
      const keep = confirm('Tidak ada aktivitas. Lanjutkan sesi?');
      if (keep) {
        pingServer();
        resetTimers();
      } else {
        performLogout();
      }
    }
  }

  function performLogout() {
    // submit a POST logout form if token present, otherwise navigate to logout URL
    if (!logoutForm) {
      logoutForm = createHiddenLogoutForm(logoutUrl);
    }

    if (logoutForm) {
      logoutForm.submit();
    } else {
      window.location.href = logoutUrl;
    }
  }

  function onLogout() {
    // If the warning modal is open, close it and then logout
    if (warningOpen && window.Swal) {
      Swal.close();
    }
    performLogout();
  }

  // Activity events
  const events = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll'];
  const activityHandler = () => {
    // If warning modal is open, don't reset timers here; let modal handle 'extend session'
    if (warningOpen) return;
    resetTimers();
    // Also ping server occasionally to keep session alive when active
    // but avoid pinging too often. We'll ping every minute of activity.
    const now = Date.now();
    if (!startIdleWatcher._lastPingAt || now - startIdleWatcher._lastPingAt > 60000) {
      startIdleWatcher._lastPingAt = now;
      pingServer();
    }
  };

  events.forEach((ev) => window.addEventListener(ev, activityHandler, { passive: true }));

  // Initialize timers
  resetTimers();

  // Expose a way to stop watcher
  return {
    stop() {
      events.forEach((ev) => window.removeEventListener(ev, activityHandler));
      if (warningTimeout) clearTimeout(warningTimeout);
      if (logoutTimeout) clearTimeout(logoutTimeout);
    },
  };
}

export default startIdleWatcher;
