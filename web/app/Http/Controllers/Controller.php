<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function showLogin() {
    return view('auth.login');
}
}
