<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['customer_id', 'subject', 'body', 'status', 'answered_at'];

    protected $casts = [
        'status' => TicketStatus::class,
        'answered_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeCreatedBetween(Builder $query, ?Carbon $from, ?Carbon $to): Builder
    {
        if ($from) $query->where('created_at', '>=', $from);
        if ($to)   $query->where('created_at', '<=', $to);

        return $query;
    }

    public function scopeLastDays(Builder $query, int $days): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    public function scopeCustomerEmail(Builder $query, ?string $email): Builder
    {

        return $email ? $query->whereHas('customer', fn($q) => $q->where('email', 'like', "%{$email}%")) : $query;
    }

    public function scopeCustomerPhone(Builder $query, ?string $phone): Builder
    {
        return $phone ? $query->whereHas('customer', fn($q) => $q->where('phone', 'like', "%{$phone}%")) : $query;
    }
}
