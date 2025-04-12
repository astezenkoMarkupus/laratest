<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Counter extends Component
{
	public int $count = 0;

    public function render(): View|Factory|Application {
        return view('livewire.counter');
    }

	public function increment(): void {
		$this->count++;
	}

	public function decrement(): void {
		$this->count--;
	}
}
