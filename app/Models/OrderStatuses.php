<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class OrderStatuses extends Model
{
    use HasFactory;

	public $timestamps = false;

	public function order(): BelongsTo {
		return $this->belongsTo(Order::class);
	}

	public static function statuses(): array {
		return DB::table('order_statuses')->pluck('name', 'id')->toArray();
	}
}
