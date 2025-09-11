{{-- Sidebar --}}
<aside id="sidebar"
  class="fixed top-0 left-0 z-20 hidden w-64 h-dvh pt-20 lg:pt-16 font-normal transition-[width,transform] duration-200
         bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700
         flex flex-col"> {{-- NOTE: tetap flex; sembunyikan/lihat pakai class hidden --}}
  <div class="relative flex flex-col flex-1 pt-0">
    <div class="flex flex-col flex-1 overflow-y-auto overscroll-contain"
         style="-webkit-overflow-scrolling: touch;">
      <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
        <div class="flex items-center p-2 pl-3 text-base font-normal text-gray-900 rounded-lg dark:text-white">
          <img src="{{ asset('img/admin.png') }}" class="mr-3 w-10 h-10 rounded-full" alt="Avatar" />
          <div class="flex flex-col justify-center gap-1">
            <h3 class="font-bold text-lg">{{ session('user')['name'] ?? 'Teacher' }}</h3>
          </div>
        </div>

        <ul class="py-2 space-y-2">

          @if (!Session::has('user_logged_in'))
            {{-- MENU UNTUK GURU / NON-LOGIN ADMIN --}}
            <li>
              <a href="/absences"
                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'absences' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Absen</span>
              </a>
            </li>

            <li>
              <a href="/recap-teacher-absences?id={{ session('user')['id'] ?? '' }}"
                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'recap-teacher-absences' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Zm1-13a1 1 0 1 0-2 0v4.414l-2.293 2.293a1 1 0 0 0 1.414 1.414L12 11.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13 9.414V7Z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Riwayat Mengajar</span>
              </a>
            </li>

            <li>
              <a href="/payments"
                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'payments' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm2-2a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm-6 4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-6Zm8 1v1h-2v-1h2Zm0 3h-2v1h2v-1Zm-4-3v1H9v-1h2Zm0 3H9v1h2v-1Z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Pembayaran</span>
              </a>
            </li>

          @else
            {{-- MENU UNTUK ADMIN / USER LOGGED IN --}}
            <li>
              <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                aria-controls="dropdown-rekapitulasi" data-collapse-toggle="dropdown-rekapitulasi">
                <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                  <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Rekapitulasi</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <ul id="dropdown-rekapitulasi" class="space-y-2 py-2">
                <li>
                  <a href="/dashboard"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'dashboard' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Rekapitulasi Bulanan</a>
                </li>
                <li>
                  <a href="/daily-recap"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'daily-recap' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Upah Guru</a>
                </li>
                <li>
                  <a href="/daily-recap-payment"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'daily-recap-payment' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Pembayaran Murid</a>
                </li>
                <li>
                  <a href="/finance-entries"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'finance-entries' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Buku Kas</a>
                </li>
              </ul>
            </li>

            <li>
              <a href="/payments"
                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'payments' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm2-2a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm-6 4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-6Zm8 1v1h-2v-1h2Zm0 3h-2v1h2v-1Zm-4-3v1H9v-1h2Zm0 3H9v1h2v-1Z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Pembayaran</span>
              </a>
            </li>

            <li>
              <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                aria-controls="dropdown-students" data-collapse-toggle="dropdown-students">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Siswa</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <ul id="dropdown-students" class="space-y-2 py-2">
                <li>
                  <a href="/students"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'students' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Data Siswa</a>
                </li>
              </ul>
            </li>

            <li>
              <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                aria-controls="dropdown-teacher" data-collapse-toggle="dropdown-teacher">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Guru</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <ul id="dropdown-teacher" class="space-y-2 py-2">
                <li>
                  <a href="/teachers"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'teachers' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Data Guru</a>
                </li>
              </ul>
            </li>

            <li>
              <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                aria-controls="dropdown-courses" data-collapse-toggle="dropdown-courses">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Kelas</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <ul id="dropdown-courses" class="space-y-2 py-2">
                <li>
                  <a href="/courses"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'courses' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Data Kelas</a>
                </li>
              </ul>
            </li>

            <li>
              <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                aria-controls="dropdown-admin" data-collapse-toggle="dropdown-admin">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Administrasi</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <ul id="dropdown-admin" class="space-y-2 py-2">
                <li>
                  <a href="/finance-categories"
                    class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700 {{ $activeRoute == 'finance-categories' ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Input Pengeluaran</a>
                </li>
              </ul>
            </li>
          @endif

        </ul>
      </div>
    </div>
  </div>
</aside>

{{-- Sidebar Overlay --}}
<div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

{{-- OPTIONAL: contoh JS toggle super sederhana --}}
<script>
  // Contoh: panggil openSidebar() saat klik tombol burger
  function openSidebar() {
    document.getElementById('sidebar').classList.remove('hidden');
    document.getElementById('sidebarBackdrop').classList.remove('hidden');
    // lock body scroll saat sidebar terbuka (opsional)
    document.documentElement.style.overflow = 'hidden';
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.add('hidden');
    document.getElementById('sidebarBackdrop').classList.add('hidden');
    document.documentElement.style.overflow = '';
  }
  // Tutup saat klik backdrop
  document.getElementById('sidebarBackdrop')?.addEventListener('click', closeSidebar);
</script>
