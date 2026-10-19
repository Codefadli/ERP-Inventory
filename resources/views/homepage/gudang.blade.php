<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Liberation+Mono&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/homepage/kepala-gudang.css') }}" rel="stylesheet" />
    <title>Dashboard Kepala Gudang - ASTRO Inventory</title>
</head>
<body>
    @php
        $htmlPath = base_path('../homepage/dashboard/dashboardkepalagudang.html');
        if (!file_exists($htmlPath)) {
            $htmlPath = base_path('homepage/dashboard/dashboardkepalagudang.html');
        }
        $htmlContent = file_get_contents($htmlPath);
        
        // Replace static paths with Laravel asset helper
        $htmlContent = preg_replace('/href="\.\/css\/main\.css"/', 'href="' . asset('css/homepage/kepala-gudang.css') . '"', $htmlContent);
        $htmlContent = preg_replace('/src="\.\/images\//', 'src="' . asset('images/homepage/') . '', $htmlContent);
        
        // Replace static user info with dynamic data
        $htmlContent = preg_replace('/<span class="v79_11849">Budi Santoso<\/span>/', '<span class="v79_11849">' . e(auth()->user()->nama_lengkap) . '</span>', $htmlContent);
        $htmlContent = preg_replace('/<span class="v79_11851">Admin Utama \/ Super Admin<\/span>/', '<span class="v79_11851">' . e(auth()->user()->role->name) . '</span>', $htmlContent);
        
        // Extract body content only
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $htmlContent, $matches);
        echo $matches[1] ?? '';
    @endphp
</body>
</html>
