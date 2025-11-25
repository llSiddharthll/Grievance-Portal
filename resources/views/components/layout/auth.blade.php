<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __("Grievance Portal") }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="absolute top-2 right-2 group inline-block text-white">
        <!-- Button -->
        <button
            class="flex items-center gap-2 px-3 py-2 bg-emerald-800 border rounded-md shadow-sm hover:bg-emerald-700 transition-colors">
            <span class="text-sm font-medium">
                {{ app()->getLocale() == 'hi' ? __('हिन्दी') : __('English') }}
            </span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown -->
        <div
            class="absolute right-0 mt-2 w-32 bg-emerald-800 border rounded-md shadow-lg opacity-0 invisible
               group-hover:opacity-100 group-hover:visible transition-all duration-200 overflow-hidden outline-none">

            <a href="{{ url('lang/en') }}"
                class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-emerald-700 transition-colors">
                🇬🇧 {{ __('English') }}
            </a>

            <a href="{{ url('lang/hi') }}"
                class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-emerald-700 transition-colors">
                🇮🇳 {{ __('हिन्दी') }}
            </a>
        </div>
    </div>
    {{ $slot }}
</body>

</html>
