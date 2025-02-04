<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Order;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use ReflectionException;

class OrderListLayout extends Table {
	/**
	 * @var string
	 */
	public $target = 'orders';

	/**
	 * @return TD[]
	 * @throws ReflectionException
	 */
	public function columns(): array
	{
		return [
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

			TD::make(__('Actions'))
			  ->align(TD::ALIGN_CENTER)
			  ->width('100px')
			  ->render(fn (Order $order) => DropDown::make()
              ->icon('bs.three-dots-vertical')
              ->list([
                  Link::make(__('Edit'))
	                  ->icon( 'bs.pencil' )
	                  ->route( 'platform.orders.edit', $order ),

                  Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm( 'After deleting, the order will be gone forever.' )
                        ->method( 'delete', [ 'order' => $order->id ] ),
              ])),
		];
	}
}