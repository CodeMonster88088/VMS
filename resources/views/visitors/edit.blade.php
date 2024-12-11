<x-layout>
    <x-slot:heading>
        Edit Visitor
    </x-slot:heading>

    <div class="mt-10 max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-indigo-600 mb-6 border-b pb-2">Edit Visitor</h2>

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

        <!-- Edit Visitor Form -->
        <form method="POST" action="{{ route('visitors.update', $visitor->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if($visitor->photo)
                <div>
                    <label class="block text-gray-700 font-medium">Photo:</label>
                    <img src="data:image/png;base64,{{ $visitor->photo }}" alt="Visitor Photo" class="rounded mt-2 mb-4">
                </div>
            @endif

            <div>
                <label for="id_number" class="block text-gray-700 font-medium">ID Number:</label>
                <input
                    type="text"
                    id="id_number"
                    name="id_number"
                    value="{{ old('id_number', $visitor->id_number) }}"
                    class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                    required
                >
            </div>

            <div>
                <label for="arabic_full_name" class="block text-gray-700 font-medium">Name:</label>
                <input
                    type="text"
                    id="arabic_full_name"
                    name="arabic_full_name"
                    value="{{ old('arabic_full_name', $visitor->arabic_full_name) }}"
                    class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                    required
                >
            </div>

            <div>
                <label for="address_english" class="block text-gray-700 font-medium">Address:</label>
                <input
                    type="text"
                    id="address_english"
                    name="address_english"
                    value="{{ old('address_english', $visitor->address_english) }}"
                    class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="checkin_time" class="block text-gray-700 font-medium">Check-in Time:</label>
                <input
                    type="datetime-local"
                    id="checkin_time"
                    name="checkin_time"
                    value="{{ old('checkin_time', \Carbon\Carbon::parse($visitor->checkin_time)->format('Y-m-d\TH:i')) }}"
                    class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="checkout_time" class="block text-gray-700 font-medium">Check-out Time:</label>
                <input
                    type="datetime-local"
                    id="checkout_time"
                    name="checkout_time"
                    value="{{ old('checkout_time', $visitor->checkout_time ? \Carbon\Carbon::parse($visitor->checkout_time)->format('Y-m-d\TH:i') : null) }}"
                    class="w-full mt-1 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                >
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layout>
