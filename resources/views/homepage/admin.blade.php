<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Liberation+Mono&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/homepage/admin.css') }}" rel="stylesheet" />
    <title>Dashboard Admin - ASTRO Inventory</title>
</head>
<body>
    @php
        $htmlPath = base_path('../homepage/dashboardAdmin.html');
        if (!file_exists($htmlPath)) {
            $htmlPath = base_path('homepage/dashboardAdmin.html');
        }
        $htmlContent = file_get_contents($htmlPath);
        
        // Replace static paths with Laravel asset helper
        $htmlContent = preg_replace('/href="\.\/css\/Admin\.css"/', 'href="' . asset('css/homepage/admin.css') . '"', $htmlContent);
        $htmlContent = preg_replace('/src="\.\/images\//', 'src="' . asset('images/homepage/') . '', $htmlContent);
        
        // Replace static user info with dynamic data
        $htmlContent = preg_replace('/<span class="v65_9308">Budi Santoso<\/span>/', '<span class="v65_9308">' . e(auth()->user()->nama_lengkap) . '</span>', $htmlContent);
        $htmlContent = preg_replace('/<span class="v65_9310">Admin Utama \/ Super Admin<\/span>/', '<span class="v65_9310">' . e(auth()->user()->role->name) . '</span>', $htmlContent);
        
        // Extract body content only
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $htmlContent, $matches);
        echo $matches[1] ?? '';
    @endphp
</body>
</html>
