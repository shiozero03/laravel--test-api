<?php

namespace App\Repositories\User;
use App\Models\User;

class UserRepository
{
	public function __construct(){
		$this->user = new User;
	}
	public function getAllUser(){
		return $this->user->all();
	}
	public function getUserById($id){
		return $this->user->where('id', $id)->first();
	}
	public function storeUserNoPicture($request){
		$this->user->name = $request->name;
		$this->user->email = $request->email;
		$this->user->address = $request->address;
		$this->user->username = $request->username;
		$this->user->password = password_hash($request->password, PASSWORD_DEFAULT);
		$this->user->save();
		return $this->user;
	}
	public function storeUserWithPicture($request){
		$tujuan_upload = 'assets/images/users/';
    	$file = $request->file('profile_picture');
    	$namafile = time().'_'.$file->getClientOriginalName();
    	if($file->move($tujuan_upload,$namafile)){
			$this->user->name = $request->name;
			$this->user->email = $request->email;
			$this->user->address = $request->address;
			$this->user->username = $request->username;
			$this->user->password = password_hash($request->password, PASSWORD_DEFAULT);
			$this->user->profile_picture = $namafile;
			$this->user->save();

			return $this->user;
		}
	}
	public function updateUserNoPicture($request){
		$data = [
			'name' => $request->name,
			'email' => $request->email,
			'address' => $request->address,
			'username' => $request->username
		];
		$this->user->where('id', $request->id)->update($data);
		return $data;
	}
	public function updatePictureProfile($request){
		$user = $this->user->where('id', $request->id)->first();
		$delete = \File::delete('assets/images/users/'.$user->profile_picture);

		$tujuan_upload = 'assets/images/users/';
    	$file = $request->file('profile_picture');
    	$namafile = time().'_'.$file->getClientOriginalName();
    	if($file->move($tujuan_upload,$namafile)){
    		$data = ['profile_picture' => $namafile];
			$user->update($data);
    		return $data;
		}
	}
	public function updatePasswordUser($request){
		$user = $this->user->where('id', $request->id)->first();
		if( password_verify($request->last_password, $user->password) ){
			return $this->user->where('id', $request->id)->update(["password" => password_hash($request->last_password, PASSWORD_DEFAULT)]);
		} else {
			return $data = null;
		}
	}
	public function updateStatuUser($id){
		$user = $this->user->where('id', $id)->first();
		$user->changeStatus('Aktif');
		return $user;
	}
	public function deleteUserById($id){
		return $this->user->where('id', $id)->delete();	
	}
}