<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereBetween;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

class Order extends Model {
	use HasFactory, AsSource, Filterable, Attachable;

	protected array $allowedFilters = [
		'id'         => WhereBetween::class,
		'user_id'    => Where::class,
		'status'     => Like::class,
		'total'      => WhereBetween::class,
		'created_at' => WhereDateStartEnd::class,
	];

	protected $fillable = [
		'thumbnail',
		'order_statuses_id',
		'documents'
	];

	public function user(): BelongsTo {
		return $this->belongsTo( User::class );
	}

	public function products(): BelongsToMany {
		return $this->belongsToMany( Product::class );
	}

	public function status(): BelongsTo {
		return $this->belongsTo(OrderStatuses::class);
	}

	public function documents() {
		return json_decode($this->documents) ?? [];
	}
}
