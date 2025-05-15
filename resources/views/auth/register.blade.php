<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Magang Berdampak</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-container {
            background: linear-gradient(15deg, rgba(41,128,185,0.9) 0%, rgba(109,213,250,0.9) 100%),
                        url('{{ asset('images.png') }}') center/cover;
        }

        .input-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Get Started</h1>
                <p class="text-gray-600 mt-2">Create your account in 30 seconds</p>
            </div>

            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="text"
                            name="name"
                            required
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300/80 input-transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            placeholder="John Doe">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="email"
                            name="email"
                            required
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300/80 input-transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300/80 input-transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            placeholder="••••••••">
                        <button type="button"
                                @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500">
                            <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300/80 input-transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg
                              font-medium text-white bg-blue-600 hover:bg-green-700 shadow-sm hover:shadow-md
                              transform transition-all duration-200 hover:-translate-y-0.5">
                    Create Account
                </button>

                <p class="mt-6 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Sign in here
                    </a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
