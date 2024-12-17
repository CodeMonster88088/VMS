<!DOCTYPE html>
<html>
<head>
    <title>MFA Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-6 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-4 text-center">Enter OTP</h1>

    @if (session('success'))
        <div class="text-green-500 mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('mfa.verify') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="otp" class="block text-gray-700">One-Time Password (OTP):</label>
            <input type="text" name="otp" id="otp" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Verify OTP
        </button>
    </form>
</div>
</body>
</html>
