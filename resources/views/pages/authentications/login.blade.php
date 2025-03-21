<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Login and Registration Form in HTML & CSS | CodingLab </title>
 
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="{{ asset('img/login.jpg') }}" alt="">
        <div class="text">
          <span class="text-1">Sistem Absensi dan Pembayaran</span>
          <span class="text-2">Putra Bali English Course</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="{{ asset('img/login.jpg') }}" alt="">
        <div class="text">
          <span class="text-1">Sistem Absensi dan Pembayaran</span>
          <span class="text-2">Putra Bali English Course</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login Admin</div>
          <form action="/login" method="POST">
            @csrf
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Enter your name" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
              </div>
         
              <div class="button input-box">
                <input type="submit" value="Submit">
              </div>
              <div class="text sign-up-text">Not an admin? <label for="flip">Login as teacher</label></div>
            </div>
        </form>
      </div>
        <div class="signup-form">
          <div class="title">Login Teacher</div>
        <form action="{{ route('login.teacher') }}" method="POST">
          @csrf
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Enter your username" required>
              </div>
             
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Submit">
              </div>
              <div class="text sign-up-text">Not a teacher? <label for="flip">Login as admin</label></div>
            </div>
      </form>
    </div>
    </div>
    </div>
  </div>

  <!-- Modal Structure -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h2 id="modal-title">Title</h2>
    <p id="modal-message">Your message goes here.</p>
    <button id="modal-action" class="modal-action-btn">OK</button>
  </div>
</div>

 <script>
        // JavaScript for modal
        const modal = document.getElementById("modal");
        const modalTitle = document.getElementById("modal-title");
        const modalMessage = document.getElementById("modal-message");
        const closeModalBtn = document.querySelector(".close-btn");
        const modalActionBtn = document.getElementById("modal-action");

        function showModal(title, message, actionCallback = null) {
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            modal.style.display = "block";

            modalActionBtn.onclick = () => {
                if (actionCallback) actionCallback();
                modal.style.display = "none";
            };
        }

        closeModalBtn.onclick = () => {
            modal.style.display = "none";
        };

        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Laravel flash message handling
        @if (session('error'))
            showModal("Error", "{{ session('error') }}");
        @elseif (session('success'))
            showModal("Success", "{{ session('success') }}");
        @endif
    </script>
</body>
</html>