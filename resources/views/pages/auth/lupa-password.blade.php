@extends('pages.auth.layout')
@section('title', 'Lupa Password')
@section('content')

<h2>Form Lupa Password</h2>
<form id="lupa-password-form">
  <div style="text-align: left;">
    <input type="email" id="email" placeholder="Cari berdasarkan email disini" required>
    <small style="color: red; margin-left: 5px" id="errorEmail" class="errorMessage"></small>
    <br>
  </div>
  <input type="submit" value="Cari">
  <br><br>
</form>

<script>
  document.getElementById("lupa-password-form").addEventListener("submit", function(event) {
    var errMessage = document.querySelectorAll('.errorMessage');
    for( var i = 0; i < errMessage.length; i++){
      errMessage[i].innerHTML = '';
    }

    event.preventDefault();

    var email = document.getElementById("email").value;

    fetch("http://localhost:8000/api/v1/users/forgot-password", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        email: email
      })
    })
    .then((response) => response.json())
    .then((data) => {
      if(data.data.code == 422){
        var err = data.data.error;
        if(err.email){document.getElementById('errorEmail').innerHTML = err.email}
        if(err.error){ alert(err.error) }
      } else {
        alert(data.message)
        window.location.href = `{{ route('auth.login') }}`;
      }
    })
    .catch(function(error) {
      alert("Terjadi kesalahan. Silakan coba lagi.");
    });
  });
</script>

@endsection