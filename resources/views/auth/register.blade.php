<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Request::is('register') ? 'Register' : 'Login' }} - Magang Berdampak</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .auth-container {
            background: linear-gradient(15deg, rgba(41,128,185,0.9), rgba(109,213,250,0.9)),
                        url('{{ asset('images.png') }}') center/cover no-repeat;
        }

        .input-transition {
            transition: all 0.3s ease;
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
                <h1 class="text-3xl font-bold text-gray-800">
                    {{ Request::is('register') ? 'Get Started' : 'Welcome Back' }}
                </h1>
                <p class="text-gray-600 mt-2">
                    {{ Request::is('register') ? 'Create your account in 30 seconds' : 'Sign in to continue your journey' }}
                </p>
            </div>

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

            @if(Request::is('register'))
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 input-transition
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                               placeholder="John Doe">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 input-transition
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                               placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 input-transition
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400 password-input"
                               placeholder="••••••••">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 border border-transparent rounded-lg
                               font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm hover:shadow-md
                               transform transition-all duration-200 hover:-translate-y-0.5">
                    Register
                </button>

                <p class="text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Sign In</a>
                </p>
            </form>

            @else
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 input-transition
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                               placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 input-transition
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400 password-input"
                               placeholder="••••••••">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-700">
                        <input type="checkbox" name="remember" class="mr-2 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">Forgot password?</a>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 border border-transparent rounded-lg
                               font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm hover:shadow-md
                               transform transition-all duration-200 hover:-translate-y-0.5">
                    Sign In
                </button>

                <p class="text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Get Started</a>
                </p>
            </form>
            @endif
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    button.querySelector('i').classList.remove('fa-eye');
                    button.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    button.querySelector('i').classList.remove('fa-eye-slash');
                    button.querySelector('i').classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
