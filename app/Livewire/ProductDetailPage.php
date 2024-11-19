<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Doctrine\DBAL\Query;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail - ECommerce')]
class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $slug;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(int $productId)
    {
        $totalCount = CartManagement::addItemToCart($productId);
        $this->dispatch('update-cart-count', totalCount: $totalCount)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $product = Product::where('slug', $this->slug)->firstOrFail();
        return view('livewire.product-detail-page', compact('product'));
    }
}
