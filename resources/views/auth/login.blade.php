<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - ASTRO Inventory</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-white">

    <div class="flex min-h-screen">

        <!-- Panel Kiri: Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden"
             style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center;">
            <!-- Overlay lembut agar teks tetap terbaca -->
            <div class="absolute inset-0" style="background: linear-gradient(160deg, rgba(228,237,250,0.25) 0%, rgba(201,218,242,0.15) 100%);"></div>

            <!-- Logo -->
            <div class="relative z-10 w-full p-12">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/astro.png') }}" width="200px" alt="">
                </div>
            </div>

            <!-- Ilustrasi panel -->
            {{-- <div class="relative z-10 flex-1 flex items-center justify-center px-12 pb-20">
                <div class="relative">
                    <div class="absolute inset-0 -m-6 rounded-3xl bg-white/50 backdrop-blur-sm"></div>
                    <div class="relative p-8">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white mb-6"
                             style="background: linear-gradient(135deg, #5c8bf0, #3d63c9);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <div class="h-3 rounded-full w-64" style="background: #2c4a9e;"></div>
                            <div class="h-3 rounded-full w-48 opacity-60" style="background: #2c4a9e;"></div>
                        </div>
                        <div class="mt-8 grid grid-cols-3 gap-3">
                            <div class="rounded-xl p-3 text-center text-white" style="background: #3d63c9;">
                                <p class="text-lg font-bold leading-none">128</p>
                                <p class="text-[10px] mt-1 opacity-80">Gudang</p>
                            </div>
                            <div class="rounded-xl p-3 text-center text-white" style="background: #4f83e5;">
                                <p class="text-lg font-bold leading-none">52</p>
                                <p class="text-[10px] mt-1 opacity-80">Kota</p>
                            </div>
                            <div class="rounded-xl p-3 text-center text-white" style="background: #3659b8;">
                                <p class="text-lg font-bold leading-none">99%</p>
                                <p class="text-[10px] mt-1 opacity-80">Akurat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Panel Kanan: Form Login -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">

                <!-- Logo mobile -->
                <div class="lg:hidden flex items-center gap-3 mb-10 justify-center">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white"
                         style="background: linear-gradient(135deg, #4f83e5, #3659b8);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-wide" style="color: #2c4a9e;">ASTRO</span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900">Welcome to Astro!</h1>
                <p class="mt-2 text-gray-500">Sign in to continue your journey</p>

                <!-- Alert Success -->
                @if(session('success'))
                <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                @endif

                <!-- Alert Error -->
                @if($errors->any())
                <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.post') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Email or Username -->
                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700 mb-2">
                            Email or Username
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="login"
                                id="login"
                                value="{{ old('login') }}"
                                class="block w-full pl-4 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('login') border-red-500 @enderror"
                                placeholder="Masukkan email atau username"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="block w-full pl-4 pr-12 py-3.5 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('password') border-red-500 @enderror"
                                placeholder="Masukkan password"
                                required
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center"
                                tabindex="-1"
                            >
                                <svg id="eye-icon" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-600">
                                Remember me
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot password?
                            </a>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl text-sm font-semibold text-white shadow-sm hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                            style="background: linear-gradient(135deg, #4f83e5, #3659b8);"
                        >
                            Login
                        </button>
                    </div>
                </form>

                <p class="mt-10 text-center text-xs text-gray-400">
                    &copy; 2026 ASTRO. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</body>
</html>
