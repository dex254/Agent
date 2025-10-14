<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Agent;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Mail\TemporaryPasswordMail;

class AgentController extends Controller
{
    //
      public function agentlogin()
    {
        return view('Agent.Login'); // Assuming 'Admin.login' is the name of your login page view
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
    // Start database transaction to ensure data consistency
    DB::beginTransaction();

    try {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:agent,email',
             'password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ],
        ], [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
             'password.min' => 'Password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Registration failed. Please correct the errors and try again.');
        }

        // Additional check with lock to prevent race condition
        $existingAgent = Agent::where('email', $request->email)->lockForUpdate()->first();
        
        if ($existingAgent) {
            DB::rollBack();
            return back()
                ->withErrors(['email' => 'This email is already registered.'])
                ->withInput()
                ->with('error', 'Registration failed. This email is already in use.');
        }

        $securityKey = strtoupper(Str::random(16));

        $agent = Agent::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'securitykey' => $securityKey,
            'status' => 'pending',
            'role' => 'user',
        ]);

        // Verify the agent was created successfully before sending email
        if (!$agent) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }

        // Send email with error handling
        try {
            Mail::to($agent->email)->send(new WelcomeMail($agent));
            
            // Commit transaction only after successful email sending
            DB::commit();
            
            return redirect()->route('agent')->with('success', 'You have successfully registered and you will receive an email with your security key.');
            
        } catch (\Exception $emailException) {
            // Rollback if email fails to send
            DB::rollBack();
            
            // Log the email error for debugging
            \Log::error('Email sending failed for agent registration: ' . $emailException->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Registration completed but we could not send the confirmation email. Please contact support.');
        }

    } catch (\Exception $e) {
        // Always rollback on any exception
        DB::rollBack();
        
        \Log::error('Agent registration error: ' . $e->getMessage());
        
        return back()
            ->withInput()
            ->with('error', 'Registration failed due to a system error. Please try again.');
    }
}
public function agentTempPassword(Request $request)
    {
        //  Validate email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find agent
        $agent = Agent::where('email', $request->email)->first();

        if (!$agent) {
            return redirect()->back()->withErrors([
                'email' => 'The email address is invalid. Kindly contact support for assistance.'
            ]);
        }

        // Generate temporary password (8 random characters)
        $tempPassword = Str::random(8);
        $expiryTime = Carbon::now()->addMinutes(30);

        // Create a unique reset token
        $resetToken = Str::random(60);

        // Update agent record
        $agent->update([
            'temp_password' => Hash::make($tempPassword),
            'temp_password_expiry' => $expiryTime,
            'password' => Hash::make($tempPassword),
            'reset_token' => $resetToken,
        ]);

        // Send email with the temporary password and token link
        Mail::to($agent->email)->send(new TemporaryPasswordMail($agent, $tempPassword, $resetToken));

        return redirect()->back()->with('success', 'A temporary password has been sent to your email.');
    }
    //new  rest  link
    public function showSetPasswordForm($token)
{
    $agent = Agent::where('reset_token', $token)
              ->where('temp_password_expiry', '>', Carbon::now())
              ->first();

    if (!$agent) {
        return redirect()->route('agent')->withErrors(['token' => 'This password reset link is invalid or expired.']);
    }

    // We will pass the hashed temp_password, but ideally you want to store/display the plain temp password in session/email only.
    // Since it's hashed, we can't show it here, so better to ask the user to check email for the temp password.

    return view('Agent.Set', compact('agent'));
}

// Handle password update
public function setNewPassword(Request $request)
{
    $request->validate([
        'reset_token' => 'required',
        'new_password' => 'required|string|min:8|confirmed',  // confirmed expects 'new_password_confirmation'
    ]);

    $agent = Agent::where('reset_token', $request->reset_token)
              ->where('temp_password_expiry', '>', Carbon::now())
              ->first();

    if (!$agent) {
        return redirect()->route('agent')->withErrors(['token' => 'This password reset token is invalid or expired.']);
    }

    // Update the password
    $agent->password = Hash::make($request->new_password);
   

    // Clear temporary password and token
    $agent->temp_password = null;
    $agent->temp_password_expiry = null;
    $agent->reset_token = null;

    $agent->save();

    return redirect()->route('agent')->with('success', 'Your password has been updated successfully. Please login.');
}
}
