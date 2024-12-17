<x-layout>
    <x-slot:heading>
        Users Management
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this user? This action cannot be undone.');
            }
        </script>
    </x-slot:heading>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Registration Form -->
    <div class="mt-10">
        <h2 class="text-lg font-bold mb-4">Register a New User</h2>
        <form action="{{ route('register.user') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('password_confirmation')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200">
                    Register
                </button>
            </div>
        </form>
    </div>

    <!-- User List -->
    <div class="mt-10">
        <h2 class="text-lg font-bold mb-4">User List</h2>

        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
            <tr>
                <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Name</th>
                <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Email</th>
                <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Role</th>
                <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $user->name }}</td>
                    <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $user->email }}</td>
                    <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $user->role }}</td>
                    <td class="px-4 py-2 border-b text-sm text-gray-700">
                        @if ($user->isAdmin()) {{--TODO--}}
                            <form action="{{ route('delete.user', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('edit.user', $user->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <h2 class="text-xl font-bold mb-4">Activity Logs</h2>
    <table class="min-w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2">User</th>
            <th class="px-4 py-2">Action</th>
            <th class="px-4 py-2">Module</th>
            <th class="px-4 py-2">Details</th>
            <th class="px-4 py-2">IP Address</th>
            <th class="px-4 py-2">Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td class="px-4 py-2">{{ $log->user->name ?? 'Guest' }}</td>
                <td class="px-4 py-2">{{ $log->action }}</td>
                <td class="px-4 py-2">{{ $log->module }}</td>
                <td class="px-4 py-2">{{ $log->details }}</td>
                <td class="px-4 py-2">{{ $log->ip_address }}</td>
                <td class="px-4 py-2">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $logs->links() }}
</x-layout>
