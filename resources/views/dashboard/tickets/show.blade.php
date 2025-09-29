<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $ticket->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-4 sm:rounded-lg">
                <x-copyable-item label="{{ __('Name:') }}" :value="$ticket->customer->name" />
                <x-copyable-item label="{{ __('Email:') }}" :value="$ticket->customer->email" />
                <x-copyable-item label="{{ __('Phone:') }}" :value="$ticket->customer->phone" />
                <div class="mb-1">
                    <strong>{{ __('Answered At:') }}</strong>
                    {{ optional($ticket->answered_at)->toDayDateTimeString() ?? __('—') }}
                </div>
                <div class="mb-4"><strong>{{ __('Created At:') }}</strong>
                    {{ $ticket->created_at->toDayDateTimeString() }}
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold">{{ __('Body') }}</h3>
                    <p class="mt-2 whitespace-pre-line">{{ $ticket->body }}</p>
                </div>

                @if (!$ticket->getMedia('attachments')->isEmpty())
                    <div class="mb-4">
                        <h3 class="font-semibold">{{ __('Files') }}</h3>
                        <ul class="mt-2">
                            @foreach ($ticket->getMedia('attachments') as $media)
                                <li class="mb-1">
                                    <a href="{{ $media->getUrl() }}" target="_blank" class="text-blue-600">
                                        {{ $media->name ?: $media->file_name }}.{{ $media->extension }}
                                    </a>
                                    <span class="text-gray-500 text-sm">({{ $media->human_readable_size }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <form action="{{ route('dashboard.tickets.updateStatus', $ticket) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        <div>
                            <h3 class="font-semibold">{{ __('Status') }}</h3>
                            <select id="status" name="status" class="block mt-2">
                                @foreach (\App\Enums\TicketStatus::cases() as $status)
                                    <option value="{{ $status->value }}" @selected($ticket->status === $status)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button type="submit">{{ __('Update') }}</x-primary-button>
                    </form>
                </div>

                @if (session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
