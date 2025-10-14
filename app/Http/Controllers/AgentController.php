<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    //
      public function agentlogin()
    {
        return view('Agent.login'); // Assuming 'Admin.login' is the name of your login page view
    }
      public function signup()
    {
        return view('Agent.Register'); // Assuming 'Admin.login' is the name of your login page view
    }
     public function password()
    {
        return view('Agent.Password'); // Assuming 'Admin.login' is the name of your login page view
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:agent,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        if ($validator->fails()) {
            // ✅ Send all validation errors back
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Registration failed. Please correct the errors and try again.');
        }

        Agent::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'role' => 'user',
        ]);

        // ✅ Success message
        return redirect()->back()->with('success', 'You have successfully registered and you will receive an email with your security key.');
    }
}
