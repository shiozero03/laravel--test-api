@extends('pages.auth.layout')
@section('title', 'Register')
@section('content')

<h2>Form Register</h2>
<form id="register-form">
  <div style="text-align: left">
    <input type="email" id="email" placeholder="Email" required>
    <small style="color: red; margin-left: 5px" id="errorEmail" class="errorMessage"></small>
    <br>
    <input type="text" id="fullname" placeholder="Nama Lengkap" required>
    <small style="color: red; margin-left: 5px" id="errorName" class="errorMessage"></small>
    <br>
    <input type="text" id="username" placeholder="Username" required>
    <small style="color: red; margin-left: 5px" id="errorUsername" class="errorMessage"></small>
    <br>
    <input type="password" id="password" placeholder="Password" required>
    <small style="color: red; margin-left: 5px" id="errorPassword" class="errorMessage"></small>
    <br>
    <textarea id="address" placeholder="Alamat" required></textarea>
    <small style="color: red; margin-left: 5px" id="errorAlamat" class="errorMessage"></small>
    <br>
  </div>
  <input type="submit" value="Register">
  <br><br>
    <a href="{{ route('auth.login') }}" class="changeAuth">Go to Login</a>
  <br><br>
</form>

<script>
  document.getElementById("register-form").addEventListener("submit", function(event) {
    var errMessage = document.querySelectorAll('.errorMessage');
    for( var i = 0; i < errMessage.length; i++){
      errMessage[i].innerHTML = '';
    }
    event.preventDefault();
    var email = document.getElementById("email").value;
    var name = document.getElementById("fullname").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var address = document.getElementById("address").value;
    
    fetch("http://localhost:8000/api/v1/users/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        email: email,
        name: name,
        username: username,
        password: password,
        address: address
      })
    })
    .then((response) => response.json())
    .then((data) => {
      if(data.data.code == 422){
        var err = data.data.error;
        if(err.name){document.getElementById('errorName').innerHTML = err.name}
        if(err.email){document.getElementById('errorEmail').innerHTML = err.email}
        if(err.password){document.getElementById('errorPassword').innerHTML = err.password}
        if(err.username){document.getElementById('errorUsername').innerHTML = err.username}
        if(err.address){document.getElementById('errorAddress').innerHTML = err.address}

        alert(data.data.message);
      } else {
        alert(data.message);
        window.location.href = `{{ route('auth.login') }}`;
      }
    })
    .catch(function(error) {
      alert("Terjadi kesalahan. Silakan coba lagi.");
      console.log(error)
    });
  });
</script>

@endsection