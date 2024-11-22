<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot Password - ECommerce')]
class ForgotPassword extends Component
{
    public $email;

    public function handleSubmit()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email|max:255'
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link has been sent to your email address');
            $this->email = '';
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
