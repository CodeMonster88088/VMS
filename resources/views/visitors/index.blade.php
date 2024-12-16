<x-layout>
    <x-slot:heading>
        Visitor Log
    </x-slot:heading>

    <div class="mt-10 max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-indigo-600 mb-6">Visitor Log</h2>

        <!-- Search and Sort Bar -->
        <div class="flex items-center justify-between mb-6">
            <form method="GET" action="{{ route('visitors.index') }}" class="flex items-center space-x-4 w-full">
                <!-- Search Bar -->
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search visitors by ID or Name..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                <button
                    type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Search
                </button>
            </form>

            <!-- Sort Dropdown -->
            <form method="GET" action="{{ route('visitors.index') }}" class="ml-4">
                <select
                    name="sort"
                    onchange="this.form.submit()"
                    class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Check-in Time: Oldest</option>
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Check-in Time: Newest</option>
                </select>
            </form>
        </div>

        <!-- Visitor Log Table -->
        @if(isset($visitors) && $visitors->isNotEmpty())
            <table class="min-w-full bg-white shadow-md rounded overflow-hidden">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">ID Number</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Check-in Time</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Check-out Time</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($visitors as $visitor)
                    <tr
                        class="cursor-pointer hover:bg-gray-100"
                        onclick="window.location='{{ route('visitors.details', $visitor->id) }}'">
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->id_number }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->arabic_full_name }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->checkin_time ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">
                            {{ $visitor->checkout_time ?? 'Still Checked-in' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600 text-center">No visitors found.</p>
        @endif
    </div>
</x-layout>
