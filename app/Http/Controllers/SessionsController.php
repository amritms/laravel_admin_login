<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if(Auth::attempt($this->getCredentials($request)))
        {
            flash('You are now confirmed. Please login.');
            return redirect()->intended('/admin');
        }

        flash('Could not sign you in. Please check your credentials.');

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        flash('You have now been signed out.');
        redirect('login');
    }

    protected function getCredentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'verified' => true
        ];
    }
}
