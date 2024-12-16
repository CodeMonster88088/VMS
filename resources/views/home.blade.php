<x-layout>
    <x-slot:heading>
        Home Page
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this user?');
            }
        </script>
    </x-slot:heading>

    @if(session('success'))
        <div class="bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success:</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(Auth::check())
        <p>Logged in as: {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
    @else
        <p>No user is logged in.</p>
    @endif

    <!-- Visitor Log -->
    <div class="mt-10">
        <h2 class="text-lg font-bold mb-4">Visitor Log</h2>

        <!-- Search and Sort Bar -->
        <div class="flex items-center justify-between mb-6">
            <form method="GET" action="{{ route('visitors.index') }}" class="flex items-center space-x-4 w-full">
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
                    <tr
                        class="hover:bg-gray-100 cursor-pointer"
                        onclick="window.location='{{ route('visitors.details', $visitor->id) }}'">
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
                                        class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none"
                                        onclick="event.stopPropagation();">
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
    @if(auth()->user() && auth()->user()->isAdmin)
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
    @endif

</x-layout>
