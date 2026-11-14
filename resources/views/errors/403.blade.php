<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-300">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mt-4">Peran tidak sah</h2>
        <p class="text-gray-600 mt-2">Maaf, Anda tidak memiliki akses pada tampilan ini.</p>
        <a href="{{ route('homepage') }}" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Kembali ke tampilan dashboard
        </a>
    </div>
</body>
</html>
