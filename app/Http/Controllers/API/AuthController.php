<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\User\AuthRepository;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
	public function  __construct(){
    	$this->authRep = new AuthRepository;
    }
    public function loginUser(Request $request){
    	$rules = array(
	        'username' => 'required',
	        'password' => 'required'
    	);
    	$validated = Validator::make($request->all(), $rules);

	    if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors);
	    } else {
	    	$result = $this->authRep->loginUser($request);
	    	if($result['error']){
	    		return new BaseResource('error', 422, 'Login gagal', null, $result);
	    	}
	    	if($result['error']) {
	    		return new BaseResource('error', 422, 'Login gagal', null, $result);
	    	}
	    	return new BaseResource('success', 200, 'Login berhasil', $result);
	    }
    }
    public function registerUser(Request $request){
    	$rules = array(
	        'username' => 'required|unique:users',
	        'email' => 'required|email|unique:users',
	        'password' => 'required',
	        'name' => 'required',
	        'address' => 'required'
    	);
    	$validated = Validator::make($request->all(), $rules);

	    if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors);
	    } else {
	    	$result = $this->authRep->registerUser($request);
	    	return new BaseResource('success', 200, 'Data user berhasil ditambahkan', $result);
	    }
    }
    public function forgotPassword(Request $request){
    	$rules = array(
	        'email' => 'required|email'
    	);
    	$validated = Validator::make($request->all(), $rules);

	    if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors);
	    } else {
	    	$result = $this->authRep->forgotPassword($request);
	    	if($result){
	    		return new BaseResource('success', 200, 'Silahkan cek email anda untuk melakukan reset password', $result);
	    	} else {
	    		return new BaseResource('error', 422, 'Email tidak terdaftar', null, ["error" => "Email yang anda cari tidak dapat ditemukan"]);
	    	}
	    }
    }
}
