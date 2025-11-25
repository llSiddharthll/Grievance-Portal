<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Grievance Portal') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen flex flex-col overflow-x-hidden">
    <!-- Header -->
    @include('components.layout.header', ['menuItems' => $headerMenuItems ?? []])

    <div class="flex flex-1 overflow-x-hidden">
        <!-- Sidebar -->
        @include('components.layout.sidebar', ['menuItems' => $sidebarMenuItems ?? []])

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:ml-70 transition-all duration-300 overflow-x-hidden">
            <div>
                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            const clickedInsideSidebar = sidebar.contains(event.target);
            const clickedToggle = toggleBtn?.contains(event.target);

            if (!clickedInsideSidebar && !clickedToggle && !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Ensure sidebar visible on desktop
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
            }
        });
    </script>
</body>
</html>
