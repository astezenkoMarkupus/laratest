<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Select;

class StatusFilter extends Filter
{
	private array $options = [ 'Pending', 'Failed', 'Completed', 'Cancelled' ];

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Statuses');
    }

    /**
     * The array of matched parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return ['status'];
    }

    /**
     * Apply to a given Eloquent query builder.
     */
    public function run( Builder $builder ): Builder
    {
		$res = array_map( fn ( $v ) => strtolower( $this->options[ $v ] ), $this->request->get( 'status' ) );

	    return $builder->whereIn( 'status', $res );
    }

    /**
     * Get the display fields.
     */
    public function display(): array
    {
        return [
            Select::make('status')
	            ->options( $this->options )
	            ->title( __( 'Statuses' ) )
	            ->multiple(),
        ];
    }

	/**
	 * Value to be displayed
	 */
	public function value(): string
	{
		return $this->name() . ': ' . implode(
			', ',
			array_map( fn ( $v ) => $this->options[ $v ], $this->request->get( 'status' ) )
		);
	}
}
