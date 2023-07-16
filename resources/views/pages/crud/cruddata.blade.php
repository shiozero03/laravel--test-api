@extends('pages.crud.layout')
@section('title', 'Dashboard')
@section('content')

<script type="text/javascript">
	document.getElementsByClassName('side-menu')[0].classList.add('active')
</script>

<div class="container my-3">
	<legend><strong>Dashboard<span></span></strong></legend>
	<div class="w-100 bg-white borderradius-10 border border-secondary p-md-4 p-3">
    <h5><strong>Create Data User</strong></h5>
    <button class="btn btn-primary" onclick="openCreateData()"><i class="fas fa-square-plus me-2"></i> Tambah Data</button>
    <br>
		<h5 class="mt-3"><strong>Read Data User</strong></h5>
		<div class="table-responsive">
      <table class="table table-bordered table-hovered table-striped" id="datatable">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Status Aktivasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
</div>
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Tambah Data User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="storedatauser">
          <input type="email" id="email" placeholder="Email" required class="form-control">
          <small style="color: red; margin-left: 5px" id="errorEmail" class="errorMessage"></small>
          <br>
          <input type="text" id="fullname" placeholder="Nama Lengkap" required class="form-control">
          <small style="color: red; margin-left: 5px" id="errorName" class="errorMessage"></small>
          <br>
          <input type="text" id="username" placeholder="Username" required class="form-control">
          <small style="color: red; margin-left: 5px" id="errorUsername" class="errorMessage"></small>
          <br>
          <input type="password" id="password" placeholder="Password" required class="form-control">
          <small style="color: red; margin-left: 5px" id="errorPassword" class="errorMessage"></small>
          <br>
          <textarea id="address" placeholder="Alamat" required class="form-control"></textarea>
          <small style="color: red; margin-left: 5px" id="errorAlamat" class="errorMessage"></small>
          <br>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Data User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updatedatauser">
          <input type="hidden" id="idUpdate" placeholder="id" required class="form-control">
          <input type="email" id="emailUpdate" placeholder="Email" required class="form-control">
          <small style="color: red; margin-left: 5px" id="updateErrorEmail" class="errorMessage"></small>
          <br>
          <input type="text" id="fullnameUpdate" placeholder="Nama Lengkap" required class="form-control">
          <small style="color: red; margin-left: 5px" id="updateErrorName" class="errorMessage"></small>
          <br>
          <input type="text" id="usernameUpdate" placeholder="Username" required class="form-control">
          <small style="color: red; margin-left: 5px" id="updateErrorUsername" class="errorMessage"></small>
          <br>
          <textarea id="addressUpdate" placeholder="Alamat" required class="form-control"></textarea>
          <small style="color: red; margin-left: 5px" id="updateErrorAlamat" class="errorMessage"></small>
          <br>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  var table;
  table = $('#datatable').DataTable({
    ajax: {
      url: `http://localhost:8000/api/v1/users`,
      dataSrc: 'data'
    },
    columns: [
      {
        "data": null,
        "render": function(data, type, row, meta) {
          // Mengatur nomor berdasarkan nomor urut
          return meta.row + 1;
        }
      },
      { data: 'name' },
      { data: 'username' },
      { data: 'email' },
      { data: 'address' },
      { data: 'status_aktivasi' },
      {
        "data": null,
        "render": function(data, type, row) {
          // Membuat tombol Edit dan Hapus
          var editButton = '<button class="btn btn-warning mb-2" onclick="editUser(' + row.id + ')">Edit</button>';
          var deleteButton = '<button class="btn btn-danger mb-2" onclick="deleteUser(' + row.id + ')">Hapus</button>';
          var aktivasiButton = '';
          if(row.status_aktivasi != "Aktif"){
            aktivasiButton = '<button class="btn btn-primary mb-2" onclick="aktivasiUser(' + row.id + ')">Aktivasi</button>';
          }
          return editButton + '<br>' + deleteButton + '<br>' + aktivasiButton;
        }
      }
    ],
    createRow: function(row, data, dataIndex){
      $(row).prepend('<td>'+(dataIndex + 1)+'</td>')
      console.log(data)
    }
  });
  function aktivasiUser(id){
    var result = confirm("Apakah ingin mengaktifkan user ?"); 
    if(result){
      fetch("http://localhost:8000/api/v1/users/status-update/"+id, {
        method: "PATCH",
        headers: {
          "Content-Type": "application/json"
        }
      })
      .then((response) => response.json())
      .then((data) => {
        table.ajax.reload(null, false);
      })
      .catch(function(error) {
        console.log(error)
        alert("Terjadi kesalahan. Silakan coba lagi.");
      });
    }
  }
  function deleteUser(id){
    var result = confirm("Apakah ingin menghapus user ?"); 
    if(result){
      fetch("http://localhost:8000/api/v1/users/delete/"+id, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json"
        }
      })
      .then((response) => response.json())
      .then((data) => {
        table.ajax.reload(null, false);
      })
      .catch(function(error) {
        console.log(error)
        alert("Terjadi kesalahan. Silakan coba lagi.");
      });
    }
  }
  function openCreateData(){
    $('#createModal').modal('show')
  }
  document.getElementById("storedatauser").addEventListener("submit", function(event) {
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
    
    fetch("http://localhost:8000/api/v1/users/store", {
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
        table.ajax.reload(null, false);
        $('#createModal').modal('hide')
      }
    })
    .catch(function(error) {
      alert("Terjadi kesalahan. Silakan coba lagi.");
      console.log(error)
    });
  });
  function editUser(id){
    document.getElementById("idUpdate").value = '';
    document.getElementById("emailUpdate").value = '';
    document.getElementById("fullnameUpdate").value = '';
    document.getElementById("usernameUpdate").value = '';
    document.getElementById("addressUpdate").value = '';
    fetch("http://localhost:8000/api/v1/users/show/"+id, {
      method: "GET",
      headers: {
        "Content-Type": "application/json"
      }
    })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("idUpdate").value = data.data.id;
      document.getElementById("emailUpdate").value = data.data.email;
      document.getElementById("fullnameUpdate").value = data.data.name;
      document.getElementById("usernameUpdate").value = data.data.username;
      document.getElementById("addressUpdate").value = data.data.address;
      $('#updateModal').modal('show')
    })
    .catch(function(error) {
      console.log(error)
      alert("Terjadi kesalahan. Silakan coba lagi.");
    });
  }
  document.getElementById("updatedatauser").addEventListener("submit", function(event) {
    var errMessage = document.querySelectorAll('.errorMessage');
    for( var i = 0; i < errMessage.length; i++){
      errMessage[i].innerHTML = '';
    }
    event.preventDefault();
    var id = document.getElementById("idUpdate").value;
    var email = document.getElementById("emailUpdate").value;
    var name = document.getElementById("fullnameUpdate").value;
    var username = document.getElementById("usernameUpdate").value;
    var address = document.getElementById("addressUpdate").value;
    
    fetch("http://localhost:8000/api/v1/users/update/"+id, {
      method: "PUT",
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
        if(err.name){document.getElementById('updateErrorName').innerHTML = err.name}
        if(err.email){document.getElementById('updateErrorEmail').innerHTML = err.email}
        if(err.password){document.getElementById('updateErrorPassword').innerHTML = err.password}
        if(err.username){document.getElementById('updateErrorUsername').innerHTML = err.username}
        if(err.address){document.getElementById('updateErrorAddress').innerHTML = err.address}

        alert(data.data.message);
      } else {
        alert(data.message);
        table.ajax.reload(null, false);
        $('#updateModal').modal('hide')
      }
    })
    .catch(function(error) {
      alert("Terjadi kesalahan. Silakan coba lagi.");
      console.log(error)
    });
  });
</script>

@endsection