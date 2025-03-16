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
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Attachment\File;

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
			      ->method('save'),

			Button::make('Remove')
			      ->icon('trash')
			      ->confirm( 'After deleting, the order will be gone forever.' )
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

			Layout::columns([
				Layout::rows([
					Upload::make( 'order.attachment.' )
					      ->title( 'Documents' )
					      ->acceptedFiles( 'application/pdf' )
					      ->maxFiles( 3 )
					      ->maxFileSize( 10 )
					      ->storage( 'public' )
					      ->parallelUploads(3)
					      ->groups('documents')
				])
			])
		];
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
	public function save(Order $order, Request $request): RedirectResponse {
		$order->fill($request->get('order'));
		$order->save();

		if ( $docs = $request->input('order.attachment') ) {
			$order->attachments()->sync( array_map( fn ( $doc ) => $doc[0], $docs ) );
		}

		return redirect()->route('platform.orders');
	}
}
