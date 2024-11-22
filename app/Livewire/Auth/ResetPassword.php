<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Str;

#[Title('Reset Password - ECommerce')]
class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email');
    }

    public function handleSubmit()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Perform password reset
        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ], function ($user) {
            // Reset the user's password and save
            $user->forceFill([
                'password' => Hash::make($this->password),
            ])->setRememberToken(Str::random(60));
            $user->save();

            // Fire password reset event (optional)
            event(new PasswordReset($user));
        });

        // Check if the password was reset successfully
        if ($status === Password::PASSWORD_RESET) {
            // Redirect to login
            return redirect()->route('login')->with('status', 'Your password has been reset!');
        } else {
            // Handle failure
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
