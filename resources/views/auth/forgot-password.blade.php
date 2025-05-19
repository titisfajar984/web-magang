<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Magang Berdampak</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-container {
            background: linear-gradient(15deg, rgba(41,128,185,0.9) 0%, rgba(109,213,250,0.9) 100%),
                        url('{{ asset('images.png') }}') center/cover;
        }
        .input-transition {
            transition: all 0.3s ease-in-out;
        }
        .animate-in {
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full flex items-center justify-center auth-container">
        <div class="bg-white/90 backdrop-blur-lg rounded-xl shadow-2xl p-8 w-full max-w-md animate-in">
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/Logo 2.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Forgot Your Password?</h1>
                <p class="text-gray-600 mt-2 text-sm">Enter your email and we’ll send you a link to reset it.</p>
            </div>

            @if (session('status'))
            <div class="text-green-600 text-sm text-center mb-4">{{ session('status') }}</div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        @foreach($errors->all() as $error)
                        <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" required
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 input-transition
                               focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                               placeholder="you@example.com">
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg
                               font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                    Send Reset Link
                </button>

                <p class="mt-4 text-center text-sm">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Back to login</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
