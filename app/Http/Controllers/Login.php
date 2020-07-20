<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function viewLogin(){
        return view('login');
    }
    public function loginPost(Request $request){
      $bool=  Auth::attempt(['email'=>$request->get('email'),'password'=>$request->get('password')]);
      if ($bool){
          return redirect('/dashboard');
      }else{
          return redirect()->back();
      }
    }

}
