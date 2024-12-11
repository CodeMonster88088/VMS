<x-layout>
    <x-slot:heading>
        Home Page
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this user?');
            }
        </script>
    </x-slot:heading>

    <!-- Greeting Section -->
    <h1>{{ $greeting ?? 'Hello' }}. From the home page, my name is {{ $name ?? 'Guest' }}.</h1>

    @if(Auth::check())
        <p>Logged in as: {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
    @else
        <p>No user is logged in.</p>
    @endif



    <!-- Visitor Log -->
    <div class="mt-10">
        <h2 class="text-lg font-bold mb-4">Visitor Log</h2>

        <!-- Search Bar -->
        <div class="mb-6">
            <form method="GET" action="{{ route('visitors.index') }}" class="flex items-center space-x-4">
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
        </div>

        @if(isset($visitors) && $visitors->isNotEmpty())
            <!-- Display Visitor Log Table -->
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
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->checkout_time ?? 'Still Checked-in' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">No visitors found.</p>
        @endif
    </div>


</x-layout>
