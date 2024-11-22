<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Checkout - ECommerce')]
class CheckoutPage extends Component
{
    public $firstName, $lastName, $phone, $streetAddress, $city, $state, $zipCode, $paymentMethod;

    public function mount()
    {
        $cartItems = CartManagement::getCartItemsFromCookie();
        if (count($cartItems) == 0) {
            return redirect('/products');
        }
    }

    public function handleSubmit()
    {
        $this->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'streetAddress' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipCode' => 'required',
            'paymentMethod' => 'required'
        ]);

        $cartItems = CartManagement::getCartItemsFromCookie();
        $lineItems = [];

        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'idr',
                    'unit_amount' => (int) $item['unit_amount'],
                    'product_data' => [
                        'name' => $item['name']
                    ],
                ],
                'quantity' => $item['quantity']
            ];
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->grand_total = CartManagement::calculateGrandTotal($cartItems);
        $order->payment_method = $this->paymentMethod;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'idr';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order placed by ' . Auth::user()->name;

        $address = new Address();
        $address->first_name = $this->firstName;
        $address->last_name = $this->lastName;
        $address->phone = $this->phone;
        $address->street_address = $this->streetAddress;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zipCode;

        $redirectUrl = '';

        if ($this->paymentMethod == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => Auth::user()->email,
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel')
            ]);

            $redirectUrl = $sessionCheckout->url;
        } else {
            $redirectUrl = route('success');
        }

        $order->save();
        $address->order_id = $order->id;
        $address->save();

        $order->orderItems()->createMany($cartItems);
        CartManagement::clearCartItems();

        return redirect($redirectUrl);
    }

    public function render()
    {
        $cartItems = CartManagement::getCartItemsFromCookie();
        $grandTotal = CartManagement::calculateGrandTotal($cartItems);
        return view('livewire.checkout-page', [
            'cartItems' => $cartItems,
            'grandTotal' => $grandTotal
        ]);
    }
}
