<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Liberation+Mono&display=swap" rel="stylesheet" />
    @php
        // Determine role-based dashboard configuration
        $userRole = strtolower(auth()->user()->role->name ?? 'pegawai');
        
        // Map role to dashboard file and CSS
        $dashboardConfig = [
            'super admin' => [
                'file' => 'dashboardAdmin.html',
                'css' => 'Admin.css',
                'folder' => '',
                'user_name_class' => 'v65_9308',
                'user_role_class' => 'v65_9310'
            ],
            'audit' => [
                'file' => 'dashboardAudit.html',
                'css' => 'audit.css',
                'folder' => 'dashboard2/',
                'user_name_class' => 'user-name',
                'user_role_class' => 'user-role'
            ],
            'kepala gudang' => [
                'file' => 'dashboardkepalagudang.html',
                'css' => 'kepala-gudang.css',
                'folder' => 'dashboard/',
                'user_name_class' => 'v65_9308',
                'user_role_class' => 'v65_9310'
            ],
            'pegawai' => [
                'file' => 'dashboardPegawai.html',
                'css' => 'pegawai.css',
                'folder' => 'dashboard3/',
                'user_name_class' => 'v65_9308',
                'user_role_class' => 'v65_9310'
            ],
            'hr' => [
                'file' => 'dashboardHR.html',
                'css' => 'hr.css',
                'folder' => 'dashboard4/',
                'user_name_class' => 'v65_9308',
                'user_role_class' => 'v65_9310'
            ]
        ];
        
        // Get config for current role (default to pegawai if not found)
        $config = $dashboardConfig[$userRole] ?? $dashboardConfig['pegawai'];
        $cssFile = $config['css'];
    @endphp
    <link href="{{ asset('css/homepage/' . $cssFile) }}" rel="stylesheet" />
    <title>Dashboard {{ ucwords(auth()->user()->role->name) }} - ASTRO Inventory</title>
</head>
<body>
    @php
        // Build file path
        $htmlPath = base_path('../homepage/' . $config['folder'] . $config['file']);
        if (!file_exists($htmlPath)) {
            $htmlPath = base_path('homepage/' . $config['folder'] . $config['file']);
        }
        
        if (!file_exists($htmlPath)) {
            echo '<div style="padding: 20px; color: red;">Dashboard file not found: ' . $config['file'] . '</div>';
            return;
        }
        
        $htmlContent = file_get_contents($htmlPath);
        
        // Replace static CSS paths with Laravel asset helper
        $htmlContent = preg_replace('/href=\"\.\/css\/[^"]+\"/', 'href="' . asset('css/homepage/' . $cssFile) . '"', $htmlContent);
        
        // Replace static image paths with Laravel asset helper
        $htmlContent = preg_replace('/src=\"\.\/images\//', 'src="' . asset('images/homepage/') . '', $htmlContent);
        
        // Replace static user info with dynamic data
        $userName = e(auth()->user()->nama_lengkap);
        $userRoleName = e(auth()->user()->role->name);
        
        // Replace user name
        $htmlContent = preg_replace('/<span class="' . $config['user_name_class'] . '">.*?<\/span>/', '<span class="' . $config['user_name_class'] . '">' . $userName . '</span>', $htmlContent);
        
        // Replace user role
        $htmlContent = preg_replace('/<span class="' . $config['user_role_class'] . '">.*?<\/span>/', '<span class="' . $config['user_role_class'] . '">' . $userRoleName . '</span>', $htmlContent);
        
        // Extract body content only
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $htmlContent, $matches);
        echo $matches[1] ?? '';
    @endphp
</body>
</html>
