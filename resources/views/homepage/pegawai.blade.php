<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/homepage/pegawai.css') }}" rel="stylesheet" />
    <title>Dashboard Pegawai - ASTRO Inventory</title>
</head>
<body>
    @php
        $htmlPath = base_path('../homepage/dashboard3/dashboardPegawai.html');
        if (!file_exists($htmlPath)) {
            $htmlPath = base_path('homepage/dashboard3/dashboardPegawai.html');
        }
        $htmlContent = file_get_contents($htmlPath);
        
        // Replace static paths with Laravel asset helper
        $htmlContent = preg_replace('/href="\.\/css\/main\.css"/', 'href="' . asset('css/homepage/pegawai.css') . '"', $htmlContent);
        $htmlContent = preg_replace('/src="\.\/images\//', 'src="' . asset('images/homepage/') . '', $htmlContent);
        
        // Replace static user info with dynamic data
        $htmlContent = preg_replace('/<span class="v90_7364">Agus Prasetyo<\/span>/', '<span class="v90_7364">' . e(auth()->user()->nama_lengkap) . '</span>', $htmlContent);
        $htmlContent = preg_replace('/<span class="v90_7366">Staf Operasional<\/span>/', '<span class="v90_7366">' . e(auth()->user()->role->name) . '</span>', $htmlContent);
        
        // Extract body content only
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $htmlContent, $matches);
        echo $matches[1] ?? '';
    @endphp
</body>
</html>
