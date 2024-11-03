<?php

namespace App\Orchid\Screens;

use App\Models\Task;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;

class TaskScreen extends Screen {
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable {
		return [
			'tasks' => Task::latest()->get(),
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string {
		return 'Simple ToDo List';
	}

	/**
	 * Displays a description on the user's screen
	 * directly under the heading.
	 */
	public function description(): ?string {
		return "ToDo List description";
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return Action[]
	 */
	public function commandBar(): iterable {
		return [
			ModalToggle::make( 'Add Task' )->modal( 'taskModal' )->method( 'create' )->icon( 'plus' ),
		];
	}

	/**
	 * The screen's layout elements.
	 *
	 * @return Layout[]|string[]
	 */
	public function layout(): iterable {
		return [
			Layout::table( 'tasks', [
				TD::make( 'name' ),

				TD::make( 'Actions' )->alignRight()->render( function ( Task $task ) {
					return Button::make( 'Delete Task' )
					             ->type( Color::DANGER )
					             ->icon( 'trash' )
					             ->confirm( 'After deleting, the task will be gone forever.' )
					             ->method( 'delete', [ 'task' => $task->id ] );
				} ),
			] ),

			Layout::modal( 'taskModal', Layout::rows( [
				Input::make( 'task.name' )
				     ->title( 'Name' )
				     ->placeholder( 'Enter task name' )
				     ->help( 'The name of the task to be created.' ),
			] ) )->title( 'Create Task' )->applyButton( 'Add Task' ),
		];
	}

	/**
	 * @param  Request  $request
	 *
	 * @return void
	 */
	public function create( Request $request ): void {
		$request->validate( [
			'task.name' => 'required|max:255',
		] );

		$task       = new Task();
		$task->name = $request->input( 'task.name' );
		$task->save();
	}

	/**
	 * @param  Task  $task
	 *
	 * @return void
	 */
	public function delete( Task $task ): void {
		$task->delete();
	}

}
