<?php

namespace App\Orchid\Layouts\Order;

use App\Orchid\Filters\StatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class OrderFiltersLayout extends Selection
{
    /**
     * @return string[]|Filter[]
     */
    public function filters(): array
    {
        return [
	        StatusFilter::class,
        ];
    }
}
