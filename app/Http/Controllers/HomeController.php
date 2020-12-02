<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
class HomeController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $getUsers   = User::count();
        $allProduct   = Product::get();
        return view('dashboard',compact('getUsers','allProduct'));
    }
}
