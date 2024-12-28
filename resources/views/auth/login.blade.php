<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token for security -->
</head>
<body class="h-full bg-gray-50">

<div class="flex flex-col items-center sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="max-w-none max-h-none mt-8" src="images/logo-for-website@300x-8.1-poly.png" alt="Your Company Logo" style="width: 150%; height: auto;">
    <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
</div>

<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <!-- Display Messages -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form class="space-y-6" action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" required
                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm
                              ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                              focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                <div class="text-sm">
{{--                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>--}}
                </div>
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm
                              ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                              focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm
                           hover:bg-indigo-500 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                Sign in
            </button>
        </div>
    </form>
</div>

</body>
</html>
