<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Profile BPTD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-primary { background-color: #001d3d; }
        .text-primary { color: #001d3d; }
        .border-primary { border-color: #001d3d; }
        .hover\:bg-primary:hover { background-color: #001d3d; }
        .focus\:ring-primary:focus { --tw-ring-color: #001d3d; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary">LALIN</h1>
            <p class="text-gray-600 mt-2">Silahkan Login</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition duration-200">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">

            <p class="text-sm text-gray-600 mt-2">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary hover:text-opacity-80 font-medium">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
