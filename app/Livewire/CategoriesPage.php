<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Categories - ECommerce')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::query()->get();
        return view('livewire.categories-page', compact('categories'));
    }
}
