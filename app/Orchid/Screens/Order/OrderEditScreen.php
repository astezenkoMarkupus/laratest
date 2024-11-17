<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class OrderEditScreen extends Screen {
	public $order;

	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query( $order ): iterable {
		return [
			'order' => Order::find( $order ),
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string {
		return "Edit Order #{$this->order->id}";
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return Action[]
	 */
	public function commandBar(): iterable {
		return [];
	}

	/**
	 * The screen's layout elements.
	 *
	 * @return Layout[]|string[]
	 */
	public function layout(): iterable {
		return [];
	}
}
