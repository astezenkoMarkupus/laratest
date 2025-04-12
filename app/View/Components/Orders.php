<?php

namespace App\View\Components;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Orders extends Component
{
	public array $orders = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $orders = Order::with('status')->get();
		$this->prepareOrdersData($orders);
    }

	private function prepareOrdersData($orders): void {
		foreach ($orders as $order) {
			$this->orders[] = [
				'id'     => $order->id,
				'status' => $order->status->name
			];
		}
	}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.orders');
    }
}
