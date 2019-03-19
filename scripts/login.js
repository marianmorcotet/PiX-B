function displayLogin(){
  registerForm = document.getElementById("register-form");
  registerForm.classList.add("inactive");

  loginForm = document.getElementById("login-form");
  loginForm.classList.remove("inactive");
}

function displayRegister(){
  registerForm = document.getElementById("register-form");
  registerForm.classList.remove("inactive");

  loginForm = document.getElementById("login-form");
  loginForm.classList.add("inactive");
}
