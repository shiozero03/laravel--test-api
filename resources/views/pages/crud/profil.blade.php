@extends('pages.crud.layout')
@section('title', 'Profile')
@section('content')

<script type="text/javascript">
	document.getElementsByClassName('side-menu')[1].classList.add('active')
</script>

<div class="container my-3">
	<div class="w-100 bg-white borderradius-10 border border-secondary p-md-4 p-3">
    <legend><strong class="nama"></strong></legend>
    <br>
    <div class="row">
      <div class="col-md-3">
        <img src="{{ asset('assets/images/admin/vector.jpg') }}" width="100%" id="foto-profil">
        <br>
        <form class="mt-2" id="picture-change" enctype="multipart/form-data">
          <input type="file" name="profile_picture" id="profile_picture" class="form-control">
          <small style="color: red; margin-left: 5px" id="errorProfile" class="error"></small>
          <br>
          <button class="btn btn-primary">Ganti Foto</button>
        </form>
      </div>
      <div class="col-md-9">
        <form id="updateForm">
          <div class="form-group mb-2">
            <label>Nama</label>
            <input class="form-control" type="text" name="name" id="name">
            <small style="color: red; margin-left: 5px" id="errorName" class="errorMessage"></small>  
          </div>
          <div class="form-group mb-2">
            <label>Username</label>
            <input class="form-control" type="text" name="username" id="username">
            <small style="color: red; margin-left: 5px" id="errorUsername" class="errorMessage"></small>  
          </div>
          <div class="form-group mb-2">
            <label>Email</label>
            <input class="form-control" type="text" name="email" id="email">
            <small style="color: red; margin-left: 5px" id="errorEmail" class="errorMessage"></small>  
          </div>
          <div class="form-group mb-2">
            <label>Alamat</label>
            <textarea class="form-control" id="address" class="form-control" name="address"></textarea>
            <small style="color: red; margin-left: 5px" id="errorAddress" class="errorMessage"></small>  
          </div>
          <button type="submit" class="btn btn-success">Ubah Data</button>
          <button type="button" class="btn btn-warning text-dark" id="change-password">Ubah Password</button>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updatedatauser">
          <label>Password Lama</label>
          <input type="password" id="last_password" placeholder="Password Lama" required class="form-control">
          <small style="color: red; margin-left: 5px" id="updateErrorLastPassword" class="errorMessage"></small>
          <br>
          <input type="password" id="new_password" placeholder="Password Baru" required class="form-control">
          <small style="color: red; margin-left: 5px" id="updateErrorNewPassword" class="errorMessage"></small>
          <br>
          <input type="password" id="confirm_password" placeholder="Konfirmasi Password" required class="form-control">
          <small style="color: red; margin-left: 5px" id="updateErrorConfirmPassword" class="errorMessage"></small>
          <br>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var id = document.cookie.split(';')[0].split('=')[1];
  $(document).ready(function(){
    $.ajax({
      url: "http://localhost:8000/api/v1/users/show/"+id,
      type: 'GET',
      processData: false,
      contentType: false,
      success: function(response) {
        if(response.data.profile_picture != null){
          $("#foto-profil").attr('src', `http://localhost:8000/assets/images/users/${response.data.profile_picture}`)
        }
        $('#updateForm').find('input[name=name]').val(response.data.name)
        $('#updateForm').find('input[name=username]').val(response.data.username)
        $('#updateForm').find('input[name=email]').val(response.data.email)
        $('#updateForm').find('textarea[name=address]').html(response.data.address)
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  })

  $('#updateForm').on('submit', function(){
    var errMessage = document.querySelectorAll('.errorMessage');
    for( var i = 0; i < errMessage.length; i++){
      errMessage[i].innerHTML = '';
    }
    event.preventDefault();
    var email = document.getElementById("email").value;
    var name = document.getElementById("name").value;
    var username = document.getElementById("username").value;
    var address = document.getElementById("address").value;

    var formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('email', email);
    formData.append('name', name);
    formData.append('username', username);
    formData.append('address', address);

    $.ajax({
      url: "http://localhost:8000/api/v1/users/update/"+id,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if(response.data.code == 422){
          var err = response.data.error;
          if(err.name){document.getElementById('errorName').innerHTML = err.name}
          if(err.email){document.getElementById('errorEmail').innerHTML = err.email}
          if(err.username){document.getElementById('errorUsername').innerHTML = err.username}
          if(err.address){document.getElementById('errorAddress').innerHTML = err.address}

          alert(response.data.message);
        } else {
          location.reload(true)
          alert(response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
  $('#change-password').on('click', function(){
    $('#updateModal').modal('show')
  });
  $('#updatedatauser').on('submit', function(){
    var errMessage = document.querySelectorAll('.errorMessage');
    for( var i = 0; i < errMessage.length; i++){
      errMessage[i].innerHTML = '';
    }
    event.preventDefault();
    var last_password = document.getElementById("last_password").value;
    var new_password = document.getElementById("new_password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    
    var formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('last_password', last_password);
    formData.append('new_password', new_password);
    formData.append('confirm_password', confirm_password);

    $.ajax({
      url: "http://localhost:8000/api/v1/users/password-update/"+id,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if(response.data.code == 422){
          var err = response.data.error;
          if(err.last_password){document.getElementById('updateErrorLastPassword').innerHTML = err.last_password}
          if(err.new_password){document.getElementById('updateErrorNewPassword').innerHTML = err.new_password}
          if(err.confirm_password){document.getElementById('updateErrorConfirmPassword').innerHTML = err.confirm_password}

          alert(response.data.message);
        } else {
          location.reload(true)
          alert(response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });


  let icon = document.getElementById('profile_picture');
  let imagefet = document.getElementById('foto-profil');
  icon.addEventListener('change', function () {
    gambar(this);
  })
  function gambar(a) {
    if (a.files && a.files[0]) {     
      var reader = new FileReader();    
      reader.onload = function (e) {
        imagefet.src=e.target.result;
      }    
      reader.readAsDataURL(a.files[0]);
    }
  }

  $('#picture-change').on('submit', function(event) {
    event.preventDefault();
    var profile_picture = $('#profile_picture');

    var formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('profile_picture', profile_picture[0].files[0]); 

    $.ajax({
      url: 'http://localhost:8000/api/v1/users/picture-update/'+id,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if(response.code == 422){
          var err = response.data.error;
          if(err.profile_picture){document.getElementById('errorProfile').innerHTML = err.profile_picture}
          alert(response.data.message);
        } else {
          location.reload(true)
          alert(response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
</script>

@endsection