<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    {{-- @vite('resources/css/app.css') --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/css/tailwind.output.css') }}" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('/assets/js/init-alpine.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="{{ asset('/assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('/assets/js/charts-pie.js') }}" defer></script>
    <style>
        /* Tambahan CSS khusus */
        .notification {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    {{-- @if (session('success'))
        <div id="notification" class="bg-white border-l-4 border-green-500 text-green-700 p-4 notification" role="alert">
            <div class="flex items-center">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M0 10a10 10 0 1 1 20 0 10 10 0 0 1-20 0zm18.32-2.32a8 8 0 1 0-11.32 0 6 6 0 1 1 11.32 0zM10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            <div>
                <button onclick="" id="closeButton" class="p-1 focus:outline-none hover:text-green-500" aria-label="close">
                    <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M10 9.707l4.146-4.147a1 1 0 0 1 1.415 1.414L11.414 11l4.147 4.146a1 1 0 1 1-1.415 1.415L10 12.414l-4.147 4.147a1 1 0 1 1-1.415-1.415L8.586 11 4.439 6.854a1 1 0 0 1 1.415-1.415L10 9.707z" />
                    </svg>
                </button>
            </div>

        </div>
    @endif --}}
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
