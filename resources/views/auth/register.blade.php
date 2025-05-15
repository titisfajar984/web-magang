<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('images.png') }}') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Daftar Peserta</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Name Input -->
            <div class="relative mb-6">
                <i class="fas fa-user-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input
                    type="text"
                    name="name"
                    placeholder="Nama Lengkap"
                    value="{{ old('name') }}"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    required
                />
            </div>

            <!-- Email Input -->
            <div class="relative mb-6">
                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value="{{ old('email') }}"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    required
                />
            </div>

            <!-- Password -->
            <div class="relative mb-6">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    required
                />
            </div>

            <!-- Password Confirmation -->
            <div class="relative mb-6">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Konfirmasi Password"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    required
                />
            </div>

            <!-- Register Button -->
            <button
                type="submit"
                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition"
            >
                Daftar
            </button>
        </form>

        <!-- Link ke Login -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Login di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
