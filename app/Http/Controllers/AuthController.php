<?php

namespace App\Http\Controllers;

use App\Repositories\User\AuthRepository;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
	public function login(){
		return view('pages.auth.login');
	}
	public function register(){
		return view('pages.auth.register');	
	}
	public function lupaPassword(){
		return view('pages.auth.lupa-password');	
	}
}
