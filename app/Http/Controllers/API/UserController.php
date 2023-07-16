<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function  __construct(){
    	$this->userRep = new UserRepository;
    }
    public function allUser(){
    	$result = $this->userRep->getAllUser();
    	return new BaseResource('success', 200, 'Data user ditemukan', $result);
    }
    public function findUserId(Request $request){
    	$result = $this->userRep->getUserById($request->id);
    	return new BaseResource('success', 200, 'Data user ditemukan', $result);
    }
    public function storeUserNoPicture(Request $request){
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
	    	$result = $this->userRep->storeUserNoPicture($request);
	    	return new BaseResource('success', 200, 'Data user berhasil ditambahkan', $result);
	    }
	}
	public function storeUserWithPicture(Request $request){
    	$rules = array(
	        'username' => 'required|unique:users',
	        'email' => 'required|email|unique:users',
	        'password' => 'required',
	        'name' => 'required',
	        'address' => 'required',
	        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    	);
    	$validated = Validator::make($request->all(), $rules);

	    if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors);
	    } else {
	    	$result = $this->userRep->storeUserWithPicture($request);
	    	return new BaseResource('success', 200, 'Data user berhasil ditambahkan', $result);
	    }
	}
	public function updateUserNoPicture(Request $request){
		$rules = array(
	        'username' => 'required',
	        'email' => 'required|email',
	        'name' => 'required',
	        'address' => 'required'
    	);
    	$validated = Validator::make($request->all(), $rules);

	    if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors);
	    } else {
			$data = $this->userRep->getUserById($request->id);
			if($data->username != $request->username){
				$rules2 = array( 'username' => 'required|unique:users' );
		    	$validated2 = Validator::make($request->all(), $rules2);
		    	if ($validated2->fails()) {
			    	$errors2 = $validated2->errors();
			    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors2);
			    }
			}
			if($data->email != $request->email){
				$rules2 = array( 'email' => 'required|unique:users' );
		    	$validated2 = Validator::make($request->all(), $rules2);
		    	if ($validated2->fails()) {
			    	$errors2 = $validated2->errors();
			    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors2);
			    }
			}
	    }

	    $result = $this->userRep->updateUserNoPicture($request);
	    return new BaseResource('success', 200, 'Data user berhasil diperbarui', $result);
	}
	public function updatePictureProfile(Request $request){
		$rules = array(
	        'profile_picture' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
    	);
    	$validated = Validator::make($request->all(), $rules);
    	if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi gagal', null, $errors);
	    } else {
			$result = $this->userRep->updatePictureProfile($request);
			return response()->json(["status" => true, "code" => 200, "message" => "Foto  berhasil diperbarui", "data" => $result]);
		}
	}
	public function updatePasswordUser(Request $request){
		$rules = array(
	        'last_password' => 'required',
	        'new_password' => 'required',
	        'confirm_password' => 'required|same:new_password'
    	);
    	$validated = Validator::make($request->all(), $rules);
    	if ($validated->fails()) {
	    	$errors = $validated->errors();
	    	return new BaseResource('error', 422, 'Validasi user gagal', null, $errors);
	    } else {
	    	$result = $this->userRep->updatePasswordUser($request);
	    	if($result == null){
	    		return new BaseResource('error', 422, 'Password lama tidak sesuai', null, 'Password lama tidak sesuai');	
	    	}
	    	return new BaseResource('success', 200, 'Password user berhasil diperbarui', $result);
	    }
	}
	public function updateStatusUser(Request $request){
		$result = $this->userRep->updateStatuUser($request->id);
		return new BaseResource('error', 200, 'Status berhasil diperbarui', $result);
	}
	public function deleteUserById(Request $request){
		$result = $this->userRep->deleteUserById($request->id);
		return new BaseResource('error', 200, 'Data berhasil dihapus');
	}
}
