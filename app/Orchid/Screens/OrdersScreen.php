<?php

namespace App\Orchid\Screens;

use App\Models\Order;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Group;

class OrdersScreen extends Screen {
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable {
		return [
			'orders' => Order::orderBy( 'id', 'DESC' )->paginate( 20 ),
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
	 * @return \Orchid\Screen\Action[]
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
			Layout::table( 'orders', [
				TD::make( 'id', '#' )->style( 'background-color: #dbdbdb' ),
				TD::make( 'user_id', 'Customer' )->render( function ( Order $order ) {
					$user = User::find( $order->user_id );

					return Link::make( $user->name )->route( 'platform.systems.users.edit', $user );
				} ),
				TD::make( 'status' )->filter( TD::FILTER_SELECT, [
					'pending'   => 'Pending',
					'cancelled' => 'Cancelled',
					'failed'    => 'Failed',
					'completed' => 'Completed',
				] ),
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
