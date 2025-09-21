<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Website Profile BPTD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-primary { background-color: #001d3d; }
        .text-primary { color: #001d3d; }
        .border-primary { border-color: #001d3d; }
        .hover\:bg-primary:hover { background-color: #001d3d; }
        .focus\:ring-primary:focus { --tw-ring-color: #001d3d; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary">LALIN</h1>
            <p class="text-gray-600 mt-2">Daftar Sekarang</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- NIP -->
            <div class="mb-4">
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP <span class="text-red-500">*</span></label>
                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="contoh@email.com">
            </div>

            <!-- Position (in users table) -->
            <div class="mb-4">
                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan <span class="text-red-500">*</span></label>
                <select id="position" name="position" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="" disabled {{ old('position') ? '' : 'selected' }}>Pilih Jabatan</option>
                    @php
                        $positions = [
                            'Kepala Balai',
                            'Kepala Sub Bagian',
                            'Kepala Seksi',
                            'Staf',
                            'Pegawai'
                        ];
                    @endphp
                    @foreach($positions as $position)
                        <option value="{{ $position }}" {{ old('position') == $position ? 'selected' : '' }}>
                            {{ $position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Department (in profiles table) -->
            <div class="mb-4">
                <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Departemen/Bagian <span class="text-red-500">*</span></label>
                <input type="text" id="department" name="department" value="{{ old('department') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Join Date (in profiles table) -->
            <div class="mb-4">
                <label for="join_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung <span class="text-red-500">*</span></label>
                <input type="date" id="join_date" name="join_date" value="{{ old('join_date') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                <textarea id="address" name="address" rows="3" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('address') }}</textarea>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Photo Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                <div class="mt-1 flex items-center">
                    <input type="file" name="photo" id="photo" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, atau GIF (Maks. 2MB)</p>
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition duration-200">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary hover:text-opacity-80 font-medium">Login di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
