<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Filters\StatusFilter;
use App\Orchid\Layouts\Order\OrderFiltersLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use ReflectionException;

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
	 * @return \Orchid\Screen\Layout[]|string[]
	 * @throws ReflectionException
	 */
	public function layout(): iterable {
		return [
			OrderFiltersLayout::class,

			Layout::table( 'orders', [
				TD::make( 'id', '#' )
					->filter( TD::FILTER_NUMBER_RANGE )
					->style( 'background-color: #dbdbdb' ),

				TD::make( 'user_id', 'Customer' )
					->render( function ( Order $order ) {
						$user = $order->user;

						return Link::make( $user->name . " (ID: $user->id)" )
							->route( 'platform.systems.users.edit', $user );
					} )
					->filter( TD::FILTER_NUMERIC ),

				TD::make( 'status' )->filter(),

				TD::make( 'total', 'Total ($)' )->filter( TD::FILTER_NUMBER_RANGE ),

				TD::make( 'created_at', 'Date Created' )
					->usingComponent( DateTimeSplit::class )
					->filter( TD::FILTER_DATE_RANGE ),

				TD::make( 'Actions' )->render( fn( $order ) => Group::make( [
					Link::make()
					    ->type( Color::LINK )
					    ->icon( 'pencil' )
					    ->route( 'platform.orders.edit', $order ),
					Button::make()
					      ->type( Color::DANGER )
					      ->icon( 'trash' )
					      ->confirm( 'After deleting, the order will be gone forever.' )
					      ->method( 'delete', [ 'order' => $order->id ] ),
				] ) ),
			] ),
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
