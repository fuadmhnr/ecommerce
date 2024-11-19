<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Products - ECommerce")]
class ProductPage extends Component
{
    use WithPagination, LivewireAlert;

    #[Url]
    public array $selectedCategory = [];

    #[Url]
    public array $selectedBrand = [];

    #[Url]
    public $featured;

    #[Url]
    public $onSale;

    #[Url]
    public $priceRange = 25000000;

    #[Url]
    public $sort = 'latest';

    public function addToCart(int $productId)
    {
        $totalCount = CartManagement::addItemToCart($productId);
        $this->dispatch('update-cart-count', totalCount: $totalCount)->to(Navbar::class);

        // Show alerts
        $this->alert('success', 'Product Added to the cart succesfully', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);
    }

    public function render(): View
    {
        $productQuery = Product::query()->where("is_active", 1);

        if (!empty($this->selectedCategory)) {
            $productQuery->whereIn("category_id", $this->selectedCategory);
        }

        if (!empty($this->selectedBrand)) {
            $productQuery->whereIn("brand_id", $this->selectedBrand);
        }

        if ($this->featured) {
            $productQuery->where("is_featured", $this->featured);
        }

        if ($this->onSale) {
            $productQuery->where("on_sale", $this->onSale);
        }

        if ($this->priceRange) {
            $productQuery->whereBetween("price", [0, $this->priceRange]);
        }

        if ($this->sort == 'latest') {
            $productQuery->latest();
        }

        if ($this->sort == 'price') {
            $productQuery->orderBy('price', 'desc');
        }

        $products = $productQuery->paginate(9);

        $brands = Brand::query()
            ->select("id", "name", "slug")
            ->whereIsActive(1)
            ->get();
        $categories = Category::query()
            ->select("id", "name", "slug")
            ->whereIsActive(1)
            ->get();

        return view(
            "livewire.product-page",
            compact("products", "brands", "categories")
        );
    }
}
