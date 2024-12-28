<x-layout>
    <x-slot:heading>
        Visitor Log
    </x-slot:heading>

    <div class="mt-10 max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-indigo-600 mb-6">Visitor Log</h2>

        <!-- Success or Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search and Sort Bar -->
        <div class="flex items-center justify-between mb-6">
            <!-- Search Bar -->
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

            <!-- Sort Dropdown -->
            <form method="GET" action="{{ route('visitors.index') }}" class="ml-4">
                <select
                    name="sort"
                    onchange="this.form.submit()"
                    class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="checkin_desc" {{ request('sort') === 'checkin_desc' ? 'selected' : '' }}>Check-in Time: Newest</option>
                    <option value="checkin_asc" {{ request('sort') === 'checkin_asc' ? 'selected' : '' }}>Check-in Time: Oldest</option>
                    <option value="checkout_asc" {{ request('sort') === 'checkout_asc' ? 'selected' : '' }}>Check-out Time: Oldest</option>
                    <option value="checkout_desc" {{ request('sort') === 'checkout_desc' ? 'selected' : '' }}>Check-out Time: Newest</option>
                    <option value="still_checked_in" {{ request('sort') === 'still_checked_in' ? 'selected' : '' }}>Still Checked-In</option>
                </select>
            </form>
        </div>

        <!-- Visitor Log Table -->
        @if(isset($visitors) && $visitors->isNotEmpty())
            <table class="min-w-full bg-white shadow-md rounded overflow-hidden">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">CPR Number</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Check-in Time</th>
                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Check-out Time</th>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($visitors as $visitor)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->id }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->id_number }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->arabic_full_name }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $visitor->checkin_time ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-700">
                            {{ $visitor->checkout_time ?? 'Still Checked-in' }}
                        </td>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <td class="px-4 py-2 border-b text-sm text-gray-700 flex space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('visitors.edit', $visitor->id) }}"
                                   class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                                    Edit
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this visitor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $visitors->links() }}
            </div>
        @else
            <p class="text-gray-600 text-center">No visitors found.</p>
        @endif
    </div>
</x-layout>
