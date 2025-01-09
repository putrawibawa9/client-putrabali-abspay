<!DOCTYPE html>
<html>
<head>
<title>Login/Register</title>
<style>
body {
  font-family: sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f0f0;
}

.container {
  background-color: #fff;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.links {
  text-align: center;
  margin-top: 20px;
}

.links a {
  color: #333;
  text-decoration: none;
}
</style>
</head>
<body>
<form action="/login" method="POST">
@csrf
<div class="container">
  <h2>Login</h2>
  <div class="form-group">
    <label for="username">Name:</label>
    <input type="text" name="name" id="username" placeholder="Enter username">
  </div>
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" placeholder="Enter password">
  </div>
  <button type="submit">Login</button>

  <div class="links">
    <a href="#" onclick="showRegister()">Register</a>
  </div>
</div>
</form>

  <h2>Register</h2>
<form action="/register" method="POST">
      @csrf
    <div class="form-group">
      <label for="username">Name:</label>
      <input type="text" id="username" name="name" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="username">Email:</label>
      <input type="email" id="username" name="email" placeholder="Enter Email">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" placeholder="Enter password">
    </div>
    <button type="submit">Register</button>
  </form>

<script>
function login() {
  // Here you would typically make an AJAX request to your server
  // to authenticate the user. For this example, we'll just display 
  // a simple alert.
  alert("Logging in...");
}


function showRegister() {
  // Hide the login form
  document.querySelector('.container').innerHTML = `
    <h2>Register</h2>
<form action="/register" method="POST">
    
    <div class="form-group">
      <label for="username">Name:</label>
      <input type="text" id="username" name="name" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="username">Email:</label>
      <input type="email" id="username" name="email" placeholder="Enter Email">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" placeholder="Enter password">
    </div>
    <button type="submit">Register</button>
  </form>


    <div class="links">
      <a href="#" onclick="showLogin()">Login</a>
    </div>
  `;
}

function register() {
  // Here you would typically make an AJAX request to your server
  // to create a new user account. For this example, we'll just 
  // display a simple alert.
  alert("Registering...");
}


</script>

</body>
</html>