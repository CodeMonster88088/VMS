<x-layout>
    <x-slot:heading>
        Home Page
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this user?');
            }
        </script>
    </x-slot:heading>


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
                    @if(auth()->user() && auth()->user()->isAdmin)
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($visitors as $visitor)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->id_number }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->arabic_full_name }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->checkin_time ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->checkout_time ?? 'Still Checked-in' }}</td>
                        @if(auth()->user() && auth()->user()->isAdmin)
                            <td class="px-4 py-2 border-b text-sm text-gray-700 flex space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('visitors.edit', $visitor->id) }}"
                                   class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this visitor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">No visitors found.</p>
        @endif
    </div>

    <!-- Report Generation Section -->
    <div class="mt-10">
        <h2 class="text-lg font-bold mb-4">Generate Visitor Reports</h2>
        <div class="flex space-x-4">
            <a href="{{ route('visitors.report.excel') }}"
               class="py-2 px-4 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none">
                Export to Excel
            </a>
            <a href="{{ route('visitors.report.pdf') }}"
               class="py-2 px-4 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none">
                Export to PDF
            </a>
        </div>
    </div>




</x-layout>
