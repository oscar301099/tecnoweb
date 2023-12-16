<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function perfil(){
     
    }

    public function editarperfil(){
        
    }
}
