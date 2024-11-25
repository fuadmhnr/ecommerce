<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Success - ECommerce')]
class SuccessPage extends Component
{
    #[Url()]
    public $session_id;

    public function render()
    {
        $latestOrder = Order::with('address')
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->first();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionInfo = Session::retrieve($this->session_id);

            if ($sessionInfo->payment_status != 'paid') {
                $latestOrder->payment_status = 'failed';
                $latestOrder->save();
            } else if ($sessionInfo->payment_status == 'paid') {
                $latestOrder->payment_status = 'paid';
                $latestOrder->save();
            }
        }

        return view('livewire.success-page', [
            'order' => $latestOrder
        ]);
    }
}
