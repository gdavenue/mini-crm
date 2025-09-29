<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded p-4 text-center">
                    <p class="text-gray-500 text-sm">{{ __('Day') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['day'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded p-4 text-center">
                    <p class="text-gray-500 text-sm">{{ __('Week') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['week'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded p-4 text-center">
                    <p class="text-gray-500 text-sm">{{ __('Month') }}</p>
                    <p class="text-2xl font-bold">{{ $stats['month'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-1">
                    <form method="GET" class="space-y-4 bg-white shadow rounded p-4">
                        <div>
                            <x-input-label for="from" :value="__('From')" />
                            <x-text-input id="from" value="{{ request('from') }}" type="date" name="from" class="block mt-1 w-full" />
                        </div>
                        <div>
                            <x-input-label for="to" :value="__('To')" />
                            <x-text-input id="to" value="{{ request('to') }}" type="date" name="to" class="block mt-1 w-full" />
                        </div>
                        <div>
                            <x-input-label for="to" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full">
                                <option value="">{{ __('All') }}</option>
                                @foreach (\App\Enums\TicketStatus::cases() as $status)
                                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" value="{{ request('email') }}" type="email" name="email" class="block mt-1 w-full" />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" value="{{ request('phone') }}" type="text" name="phone" class="block mt-1 w-full"
                                data-mask="phone" />
                        </div>
                        <x-primary-button type="submit">{{ __('Find') }}</x-primary-button>
                    </form>
                </div>

                <div class="md:col-span-3 bg-white shadow rounded overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-xs font-medium text-left">{{ __('ID') }}</th>
                                <th class="px-4 py-2 text-xs font-medium text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-2 text-xs font-medium text-left">{{ __('Subject') }}</th>
                                <th class="px-4 py-2 text-xs font-medium text-left">{{ __('Status') }}</th>
                                <th class="px-4 py-2 text-xs font-medium text-left">{{ __('Created At') }}</th>
                                <th class="px-4 py-2 text-xs font-medium">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($tickets as $ticket)
                                <tr class="border-t">
                                    <td class="px-4 py-2 text-sm">{{ $ticket->id }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ $ticket->customer->name }}<br>
                                        <small class="text-gray-500 text-xs">{{ $ticket->customer->email }} •
                                            {{ $ticket->customer->phone }}</small>
                                    </td>
                                    <td class="px-4 py-2 text-sm">{{ $ticket->subject }}</td>
                                    <td class="px-4 py-2"><x-status-badge :status="$ticket->status" /></td>
                                    <td class="px-4 py-2 text-sm">{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('dashboard.tickets.show', $ticket) }}"><x-secondary-button
                                                type="submit">{{ __('Show') }}</x-secondary-button></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="p-4">
                        {{ $tickets->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
