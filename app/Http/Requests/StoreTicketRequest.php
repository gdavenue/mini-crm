<?php

namespace App\Http\Requests;

use App\Rules\TicketDailyLimit;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{1,14}$/'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,pdf,doc,docx,txt', 'max:2048'],
            'email' => [
                'required',
                'email',
                new TicketDailyLimit($this->email, $this->phone),
            ],
        ];
    }
}
