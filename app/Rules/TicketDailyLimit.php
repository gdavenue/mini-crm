<?php

namespace App\Rules;

use App\Models\Ticket;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TicketDailyLimit implements ValidationRule
{
    protected string $email;
    protected string $phone;

    public function __construct(?string $email, ?string $phone)
    {
        $this->email = $email;
        $this->phone = $phone;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Ticket::query()->where(function ($query) {
            $query->whereHas('customer', function ($q) {
                $q->where('email', $this->email)->orWhere('phone', $this->phone);
            });
        })
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->exists();

        if ($exists) {
            $fail(__('You have already submitted an application today.'));
        }
    }
}
