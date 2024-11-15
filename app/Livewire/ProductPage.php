<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - ECommerce')]
class ProductPage extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Product::query()->whereIsActive(1)->paginate(6);
        $brands = Brand::query()
            ->select('id', 'name', 'slug')
            ->whereIsActive(1)
            ->get();
        $categories = Category::query()
            ->select('id', 'name', 'slug')
            ->whereIsActive(1)
            ->get();

        return view('livewire.product-page', compact('products', 'brands', 'categories'));
    }
}
