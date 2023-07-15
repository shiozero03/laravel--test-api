<?php

namespace App\Repositories\User;
use App\Models\User;

class AuthRepository
{
	public function __construct(){
		$this->user = new User;
	}
	public function loginUser($request){
		$user = $this->user->where('username', $request->username)->first();
		if($user){
			if (password_verify($request->password, $user->password)) {
				return $user;
			} else {
				$errors = ['error' => 'Password tidak sesuai'];
				return $errors;
			}
		} else {
			$errors = ['error' => 'Username tidak ditemukan'];
			return $errors;
		}
	}
	public function registerUser($request){
		$this->user->name = $request->name;
		$this->user->email = $request->email;
		$this->user->address = $request->address;
		$this->user->username = $request->username;
		$this->user->password = password_hash($request->password, PASSWORD_DEFAULT);
		$this->user->save();
		return $this->user;
	}
	public function forgotPassword($request){
		return $this->user->where('email', $request->email)->first();
	}
}