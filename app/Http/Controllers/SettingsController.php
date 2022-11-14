<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function logout_user(){
        Auth::logout();
        return Redirect()->route('login')->with('success', 'Logout Successful');
    }
}
