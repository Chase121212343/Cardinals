<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Pterodactyl') }}</title>

        @section('meta')
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="robots" content="noindex">
            <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
            <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
            <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
            <link rel="manifest" href="/favicons/manifest.json">
            <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
            <link rel="shortcut icon" href="/favicons/favicon.ico">
            <meta name="msapplication-config" content="/favicons/browserconfig.xml">
            <meta name="theme-color" content="#0e4688">
        @show

        @section('user-data')
            @if(!is_null(Auth::user()))
                <script>
                    window.PterodactylUser = {!! json_encode(Auth::user()->toVueObject()) !!};
                </script>
            @endif
            @if(!empty($siteConfiguration))
                <script>
                    window.SiteConfiguration = {!! json_encode($siteConfiguration) !!};
                </script>
            @endif
        @show

        @yield('assets')

        @include('layouts.scripts')

        <style>
            /* ── Cardinals Panel Theme — Cardinal Red & Black ── */
            :root {
                --c-red:    #CC0000;
                --c-dark:   #8B0000;
                --c-black:  #0d0d0d;
                --c-grey:   #1a1a1a;
                --c-mid:    #2a0a0a;
                --c-white:  #f5f5f5;
            }

            /* Page background */
            html, body, #app { background-color: var(--c-black) !important; }

            /* ── Navbar: black with red bottom border ── */
            .bg-neutral-900,
            .w-full.bg-neutral-900 {
                background-color: var(--c-grey) !important;
                border-bottom: 3px solid var(--c-red) !important;
            }

            /* Nav hover/active: red underline */
            .w-full.bg-neutral-900 a:hover,
            .w-full.bg-neutral-900 button:hover,
            .w-full.bg-neutral-900 a.active {
                box-shadow: inset 0 -3px var(--c-red) !important;
                color: var(--c-white) !important;
            }

            /* Nav text colour */
            .w-full.bg-neutral-900 a,
            .w-full.bg-neutral-900 button { color: #ccc !important; }

            /* ── Cards / panels ── */
            .bg-neutral-700 { background-color: #1f0505 !important; }
            .bg-neutral-800 { background-color: #140303 !important; }
            .bg-neutral-600 { background-color: #2b0808 !important; }

            /* ── Buttons: red ── */
            .bg-blue-500, .bg-blue-600,
            button.bg-blue-500, button.bg-blue-600 {
                background-color: var(--c-red) !important;
            }
            .hover\:bg-blue-600:hover { background-color: var(--c-dark) !important; }

            /* ── Accent text: red ── */
            .text-blue-500, .text-cyan-400, .text-cyan-600 {
                color: var(--c-red) !important;
            }

            /* ── Login page ── */
            .bg-white {
                background-color: #1a1a1a !important;
                border: 1px solid #333 !important;
            }
            /* Logo panel left side */
            .bg-white > div:first-child {
                background-color: var(--c-black) !important;
                border-radius: 0.5rem 0 0 0.5rem;
                border-right: 2px solid var(--c-red) !important;
            }
            /* Login input fields */
            input[type="text"], input[type="email"], input[type="password"] {
                background-color: #111 !important;
                color: var(--c-white) !important;
                border-color: #333 !important;
            }
            /* Login card text */
            .bg-white label, .bg-white p, .bg-white h2 {
                color: var(--c-white) !important;
            }

            /* ── Scrollbar ── */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: var(--c-black); }
            ::-webkit-scrollbar-thumb { background: var(--c-red); border-radius: 4px; }

            /* ── Console ── */
            .xterm-viewport { background-color: #050000 !important; }

            /* ── Red top border on rounded cards ── */
            .rounded-lg { border-top: 2px solid var(--c-red) !important; }

            /* ── Copyright footer ── */
            .text-neutral-500 { color: #666 !important; }
        </style>
    </head>
    <body class="{{ $css['body'] ?? 'bg-neutral-50' }}">
        @section('content')
            @yield('above-container')
            @yield('container')
            @yield('below-container')
        @show
        @section('scripts')
            {!! $asset->js('main.js') !!}
        @show
    </body>
</html>
