<?php

namespace App\Livewire\Home;

use App\Models\Brand as ModelsBrand;
use Livewire\Component;

class Brand extends Component
{
    public function render()
    {
        $brands = ModelsBrand::query()->whereIsActive(1)->get();
        return view('livewire.home.brand', compact('brands'));
    }
}
