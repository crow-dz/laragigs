<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Show Register/create 
    public  function create()
    {
        return view('users.register');
    }
    // Show Register/create 
    public  function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => ['required', 'confirmed', 'min:6']

            ]
        );
        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        // create user
        $user = User::create($formFields);
        // Login
        auth()->login($user);
        return redirect('/')->with('message', 'User created and logged in');
    }
    // logout
    public  function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out');
    }
    // login
    public  function login()
    {
        return view('users.login');
    }
    // Authenticate User
    public  function authenticate(Request $request)
    {
        $formFields = $request->validate(
            [
                
                'email' => ['required', 'email'],
                'password' => ['required']

            ]
        );
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged in');
        }else{
            return back()->withErrors(['email'=>'Invalid Credentails'])->onlyInput('email');
        }
    }
}
