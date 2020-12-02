<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NoMiddlewareController extends Controller
{
    public function screenlock($currtime,$id,$randnum)
  	{
    	Auth::logout();
    	return View('screen-lock', compact('id'));
  	}

  	public function needhelp()
  	{
    	return View('need-help');
  	}
}
