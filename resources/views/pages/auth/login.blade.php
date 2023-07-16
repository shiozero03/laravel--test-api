@extends('pages.auth.layout')
@section('title', 'Login')
@section('content')

<h2>Form Login</h2>
<form id="login-form">
  <div style="text-align: left;">
    <input type="text" id="username" placeholder="Username" required>
    <small style="color: red; margin-left: 5px" id="errorUsername" class="errorMessage"></small>
    <br>
    <input type="password" id="password" placeholder="Password" required>
    <small style="color: red; margin-left: 5px" id="errorPassword" class="errorMessage"></small>
    <br>
  </div>
  <input type="submit" value="Log In">
  <br><br>
  <div style="width: 100%; text-align: right">
    <a href="{{ route('auth.lupaPassword') }}">Lupa Password ?</a>
  </div>
  <br><br>
    <a href="{{ route('auth.register') }}" class="changeAuth">Go to Register</a>
  <br><br>
</form>

<script>
  document.getElementById("login-form").addEventListener("submit", function(event) {
    var errMessage = document.querySelectorAll('.errorMessage');
    for( var i = 0; i < errMessage.length; i++){
      errMessage[i].innerHTML = '';
    }

    event.preventDefault();

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    fetch("http://localhost:8000/api/v1/users/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        username: username,
        password: password
      })
    })
    .then((response) => response.json())
    .then((data) => {
      if(data.data.code == 422){
        var err = data.data.error;
        if(err.username){document.getElementById('errorUsername').innerHTML = err.username}
        if(err.password){document.getElementById('errorPassword').innerHTML = err.password}
        if(err.error){ alert(err.error) }
      } else {
        alert(data.message)
        document.cookie = "id="+data.data.id+"; path=/";
        window.location.href = `{{ route('crud.dashboard') }}`;

      }
    })
    .catch(function(error) {
      alert("Terjadi kesalahan. Silakan coba lagi.");
    });
  });
</script>

@endsection