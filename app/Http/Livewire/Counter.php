<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {

        return <<<'blade'
             <div class="counter">
                <span>{{ $count }}</span>

                <button wire:click="increment">+</button>
            </div>
        blade;
    }
}
