<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Models\OrderStatuses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

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
		return [
			Button::make('Update')
			      ->icon('note')
			      ->method('createOrUpdate'),

			Button::make('Remove')
			      ->icon('trash')
			      ->method('remove')
		];
	}

	/**
	 * The screen's layout elements.
	 *
	 * @return Layout[]|string[]
	 */
	public function layout(): iterable {
		return [
			Layout::columns([
				Layout::rows([
					Picture::make('order.thumbnail')
					       ->targetId()
					       ->title('Thumbnail')
				]),
				Layout::rows([
					Select::make('order.order_statuses_id')
					       ->options(array_map(fn($status) => ucfirst($status), OrderStatuses::statuses()))
					       ->title('Status')

				])
			]),
		];
	}

	public function createOrUpdate(Order $order, Request $request): RedirectResponse {
		$order->fill($request->get('order'));
		$order->save();

		return redirect()->route('platform.orders');
	}

	public function remove(Order $order): RedirectResponse {
		$order->delete()
			? Alert::info('You have successfully deleted the hero item.')
			: Alert::warning('An error has occurred')
		;

		return redirect()->route('platform.orders');
	}

	/**
	 * @param  Request  $request
	 *
	 * @return RedirectResponse
	 */
	public function save(Request $request): RedirectResponse {
		/*$request->validate([
			'order.thumbnail' => [
				'required',
			],
		]);*/

		/*$order->fill($request->get('order'));
		$order->save();*/

		return redirect()->route('platform.systems.orders');
	}
}
