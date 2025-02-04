<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Filters\StatusFilter;
use App\Orchid\Layouts\Order\OrderFiltersLayout;
use App\Orchid\Layouts\Order\OrderListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class OrderListScreen extends Screen {
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable {
		return [
			'orders' => Order::with( 'user' )
				->filters([StatusFilter::class])
				->paginate( 20 ),
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string {
		return 'Orders';
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
		return [
			OrderFiltersLayout::class,
			OrderListLayout::class
		];
	}

	/**
	 * @param  Order  $order
	 *
	 * @return void
	 */
	public function delete( Order $order ): void {
		$order->delete();
	}
}
