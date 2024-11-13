<?php

namespace App\Livewire\Home;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public function render()
    {
        $categories = Category::query()->whereIsActive(1)->get();
        return view('livewire.home.categories', compact('categories'));
    }
}
