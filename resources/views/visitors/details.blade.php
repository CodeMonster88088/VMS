<x-layout>
    <x-slot:heading>
        Visitor Details
    </x-slot:heading>

    <div class="mt-10 max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-indigo-600 mb-6 border-b pb-2">Visitor Details</h2>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-500 text-green-700 p-4 rounded mb-6">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-500 text-red-700 p-4 rounded mb-6">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        <!-- Visitor Information -->
        <div class="space-y-4">
            @if($visitor->photo)
                <div>
                    <strong class="block text-gray-700">Photo:</strong>
                    <img src="data:image/png;base64,{{ $visitor->photo }}" alt="Visitor Photo" >
                </div>
            @endif
            <div>
                <strong class="block text-gray-700">ID Number:</strong>
                <span class="text-gray-600">{{ $visitor->id_number }}</span>
            </div>
            <div>
                <strong class="block text-gray-700">Name:</strong>
                <span class="text-gray-600">{{ $visitor->arabic_full_name }}</span>
            </div>

            <div>
                <strong class="block text-gray-700">Address:</strong>
                <span class="text-gray-600">{{ $visitor->address_english }}</span>
            </div>
            <div>
                <strong class="block text-gray-700">Check-in Time:</strong>
                <span class="text-gray-600">{{ \Carbon\Carbon::parse($visitor->checkin_time)->format('Y-m-d H:i:s') }}</span>
            </div>
            <div>
                <strong class="block text-gray-700">Check-out Time:</strong>
                <span class="text-gray-600">
                    @if($visitor->checkout_time)
                        {{ \Carbon\Carbon::parse($visitor->checkout_time)->format('Y-m-d H:i:s') }}
                    @else
                        <span class="text-red-500">Still Checked-in</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Display Checkout Button if the visitor is checked-in (checkout_time is null) -->
        @if(!$visitor->checkout_time)
            <div class="mt-8">
                <form action="{{ route('visitor.checkout', $visitor->id) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    <!-- Add hidden field for id_number -->
                    <input type="hidden" name="id_number" value="{{ $visitor->id_number }}">

                    <button type="submit" class="py-2 px-6 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Checkout
                    </button>
                </form>
            </div>
        @else
            <div class="mt-8 text-center text-green-700 font-semibold">
                Visitor has already checked out at {{ \Carbon\Carbon::parse($visitor->checkout_time)->format('Y-m-d H:i:s') }}.
            </div>
        @endif
    </div>
</x-layout>
