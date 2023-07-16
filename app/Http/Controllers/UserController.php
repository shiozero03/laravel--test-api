<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepository;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function index(){
    	return view('pages.crud.cruddata');
    }
    public function profil(){
    	return view('pages.crud.profil');
    }
}
