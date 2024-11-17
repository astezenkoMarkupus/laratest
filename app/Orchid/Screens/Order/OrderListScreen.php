<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Filters\StatusFilter;
use App\Orchid\Layouts\Order\OrderFiltersLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

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
	 */
	public function layout(): iterable {
		return [
			OrderFiltersLayout::class,

			Layout::table( 'orders', [
				TD::make( 'id', '#' )->style( 'background-color: #dbdbdb' ),
				TD::make( 'user_id', 'Customer' )->render( function ( Order $order ) {
					$user = $order->user;

					return Link::make( $user->name )->route( 'platform.systems.users.edit', $user );
				} ),
				TD::make( 'status' ),
				TD::make( 'total', 'Total ($)' ),
				TD::make( 'created_at', 'Date Created' )->render( function ( Order $order ) {
					return date( 'j F Y', strtotime( $order->created_at ) );
				} ),
				TD::make( 'Actions' )->render( fn( $order ) => Group::make( [
					Link::make( 'Edit' )
					    ->type( Color::LINK )
					    ->icon( 'pencil' )
					    ->route( 'platform.orders.edit', $order ),
					Button::make( 'Delete Order' )
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
