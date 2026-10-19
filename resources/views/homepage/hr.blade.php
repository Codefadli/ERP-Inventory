<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/homepage/hr.css') }}" rel="stylesheet" />
    <title>Dashboard HR - ASTRO Inventory</title>
</head>
<body>
    @php
        $htmlPath = base_path('../homepage/dashboard4/dashboardHR.html');
        if (!file_exists($htmlPath)) {
            $htmlPath = base_path('homepage/dashboard4/dashboardHR.html');
        }
        $htmlContent = file_get_contents($htmlPath);
        
        // Replace static paths with Laravel asset helper
        $htmlContent = preg_replace('/href="\.\/css\/main\.css"/', 'href="' . asset('css/homepage/hr.css') . '"', $htmlContent);
        $htmlContent = preg_replace('/src="\.\/images\//', 'src="' . asset('images/homepage/') . '', $htmlContent);
        
        // Replace static user info with dynamic data
        $htmlContent = preg_replace('/<span class="v66_3983">Siti Rahmawati<\/span>/', '<span class="v66_3983">' . e(auth()->user()->nama_lengkap) . '</span>', $htmlContent);
        $htmlContent = preg_replace('/<span class="v66_3985">HR Management \/ Approver<\/span>/', '<span class="v66_3985">' . e(auth()->user()->role->name) . '</span>', $htmlContent);
        
        // Extract body content only
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $htmlContent, $matches);
        echo $matches[1] ?? '';
    @endphp
</body>
</html>
