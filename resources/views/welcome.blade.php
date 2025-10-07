<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NormsMedia | Connect with the World</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="flex justify-between items-center px-8 py-4 bg-white shadow">
        <h1 class="text-2xl font-bold text-blue-600">Norms<span class="text-gray-800">Media</span></h1>
        <nav class="flex gap-4">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 text-sm font-semibold text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition">
                   Log in
                </a>
                <a href="{{ route('register') }}" 
                   class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                   Register
                </a>
            @endif
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center h-[80vh] px-6">
        <h2 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Connect, Share, and Grow Together 🌐
        </h2>
        <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-2xl">
            Welcome to <span class="font-semibold text-blue-600">NormsMedia</span> — the place where conversations start, friendships grow, and communities thrive.
        </p>

        <div class="flex gap-4">
            <a href="{{ route('register') }}" 
               class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
               Get Started
            </a>
            <a href="{{ route('login') }}" 
               class="px-8 py-3 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
               Log In
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 border-t text-gray-500 text-sm">
        © {{ date('Y') }} NormsMedia. All rights reserved.
    </footer>

</body>
</html>
