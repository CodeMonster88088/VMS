<x-layout>
    <x-slot:heading>
        Visitor Details
    </x-slot:heading>

    <div class="mt-10">
        <h2 class="text-lg font-bold mb-4">Visitor Details</h2>
        <ul class="list-disc pl-5">
            @if($visitor->photo)
                <li>
                    <strong>Photo:</strong>
                    <img src="data:image/png;base64,{{ $visitor->photo }}" alt="Visitor Photo" class="mt-2">
                </li>
            @endif
            <li><strong>ID Number:</strong> {{ $visitor->id_number }}</li>
            <li><strong>Name:</strong> {{ $visitor->arabic_full_name }}</li>
            <li><strong>Address (Arabic):</strong> {{ $visitor->address_arabic }}</li>
            <li><strong>Address (English):</strong> {{ $visitor->address_english }}</li>
            <li><strong>Check-in Time:</strong> {{ \Carbon\Carbon::parse($visitor->checkin_time)->format('Y-m-d H:i:s') }}</li>
            <li><strong>Check-out Time:</strong> {{ $visitor->checkout_time ?? 'Still Checked-in' }}</li>
        </ul>
    </div>
</x-layout>
