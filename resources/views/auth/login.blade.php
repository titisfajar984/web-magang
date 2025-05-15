<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
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
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Login Sistem <br>Magang Berdampak</h2>

        <!-- Display errors if any -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Login form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="relative mb-6">
                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value="{{ old('email') }}"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                />
            </div>

            <!-- Password Input -->
            <div class="relative mb-6">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                />
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
            >
                Login
            </button>
        </form>
        <div class="text-center mt-4">
        <p class="text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar di sini</a>
        </p>
    </div>
    </div>

    <!-- jQuery (optional, if needed) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
