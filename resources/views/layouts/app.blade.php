<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="shell-type" content="web_standard"/>
    
    <title>@yield('title', 'Asro Inventory - Platform Manajemen Inventaris Pintar')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Styles -->
    <style>
        @layer base{
            html,body{margin:0;padding:0;}
            body{overscroll-behavior:none;}
            main>:first-child{margin-top:0!important;}
            main>:last-child{margin-bottom:0!important;}
        }
        ::-webkit-scrollbar{display:none;}
    </style>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config={darkMode:"class",theme:{extend:{"colors":{"primary-fixed-dim":"#8ccff6","primary-container":"#347c9f","primary":"#0c6385","surface-container-highest":"#d3e4fe","on-tertiary":"#ffffff","error":"#ba1a1a","surface-container-low":"#eff4ff","secondary-fixed-dim":"#adc8f5","on-error":"#ffffff","on-primary-container":"#fcfcff","tertiary-container":"#0f7ea3","on-secondary-container":"#3e5980","on-tertiary-container":"#fbfdff","on-surface-variant":"#40484d","secondary":"#455f87","on-surface":"#0b1c30","on-primary":"#ffffff","on-background":"#0b1c30","surface-variant":"#d3e4fe","inverse-primary":"#8ccff6","surface-container-high":"#dce9ff","surface-container":"#e5eeff","surface-dim":"#cbdbf5","secondary-container":"#b5d0fd","on-secondary":"#ffffff","tertiary-fixed":"#c0e8ff","on-tertiary-fixed":"#001e2b","error-container":"#ffdad6","tertiary-fixed-dim":"#7bd1fa","on-secondary-fixed":"#001c3b","surface":"#f8f9ff","secondary-fixed":"#d5e3ff","on-error-container":"#93000a","surface-bright":"#f8f9ff","on-tertiary-fixed-variant":"#004d66","tertiary":"#006483","background":"#f8f9ff","on-primary-fixed-variant":"#004c69","primary-fixed":"#c4e7ff","on-primary-fixed":"#001e2c","surface-container-lowest":"#ffffff","surface-tint":"#126588","inverse-on-surface":"#eaf1ff","outline":"#70787e","on-secondary-fixed-variant":"#2d486d","inverse-surface":"#213145","outline-variant":"#c0c7ce"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"space-md":"1rem","gutter":"1.5rem","gutter-sm":"1rem","space-lg":"1.5rem","space-xl":"2.5rem","space-sm":"0.5rem","space-xs":"0.25rem"},"fontSize":{"display-lg":["3.5rem",{"lineHeight":"1.1","letterSpacing":"-0.02em","fontWeight":"700"}],"headline-lg":["2.5rem",{"lineHeight":"1.2","letterSpacing":"-0.01em","fontWeight":"700"}],"headline-sm":["1.5rem",{"lineHeight":"1.3","letterSpacing":"-0.005em","fontWeight":"600"}],"title-md":["1rem",{"lineHeight":"1.5","letterSpacing":"0","fontWeight":"600"}],"body-lg":["1.125rem",{"lineHeight":"1.6","letterSpacing":"0","fontWeight":"400"}],"body-md":["1rem",{"lineHeight":"1.6","letterSpacing":"0","fontWeight":"400"}],"body-sm":["0.875rem",{"lineHeight":"1.5","letterSpacing":"0","fontWeight":"400"}],"label-sm":["0.75rem",{"lineHeight":"1.4","letterSpacing":"0.03em","fontWeight":"500"}],"label-md":["0.875rem",{"lineHeight":"1.4","letterSpacing":"0.02em","fontWeight":"500"}],"data-metric":["2.5rem",{"lineHeight":"1.2","letterSpacing":"-0.01em","fontWeight":"700"}]},"fontFamily":{"display":["Plus Jakarta Sans","Inter","sans-serif"],"body":["Inter","sans-serif"]}}}}
    </script>
    
    @stack('styles')
</head>
<body class="font-body antialiased bg-background text-on-surface">
    <main>
        @yield('content')
    </main>
    
    @stack('modals')
    
    @stack('scripts')
</body>
</html>
