<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E293B',
                        accent: '#10B981'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-secondary to-slate-800 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center h-16 bg-slate-900 border-b border-slate-700">
                <h1 class="text-xl font-bold text-white">
                    <i class="fas fa-crown text-accent mr-2"></i>
                    Admin Panel
                </h1>
            </div>

            <nav class="mt-8 px-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-lg' : '' }}">
                            <i
                                class="fas fa-tachometer-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.akun') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.akun') ? 'bg-primary text-white shadow-lg' : '' }}">
                            <i class="fas fa-user w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Akun</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stock') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.stock') ? 'bg-primary text-white shadow-lg' : '' }}">
                            <i class="fas fa-boxes w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Stock</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.laporan') ? 'bg-primary text-white shadow-lg' : '' }}">
                            <i class="fas fa-chart-bar w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Profile at Bottom -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">Admin User</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Enhanced Top Header -->
            <header class="bg-white shadow-lg border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <!-- Main Header Row -->
                    <div class="flex items-center justify-between h-16">
                        <!-- Left Section -->
                        <div class="flex items-center space-x-4">
                            <button id="sidebar-toggle"
                                class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary transition-colors">
                                <i class="fas fa-bars h-5 w-5"></i>
                            </button>

                            <!-- Page Title & Breadcrumb -->
                            <div class="hidden md:block">
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    <i class="fas fa-home"></i>
                                    <span>/</span>
                                    <span class="text-gray-900 font-medium">@yield('page-title', 'Dashboard')</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section -->
                        <div class="flex items-center space-x-4">
                          

                            <!-- Notifications -->
                            <div class="relative">
                                <button id="notifications-btn"
                                    class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-lg transition-colors relative"
                                    title="Notifications">
                                </button>

                                <!-- Notifications Dropdown -->
                                <div id="notifications-dropdown"
                                    class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="p-4 border-b border-gray-200">
                                        <h3 class="text-lg font-medium text-gray-900">Notifications</h3>
                                    </div>
                                    <div class="max-h-64 overflow-y-auto">
                                        <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                            <div class="flex items-start space-x-3">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm text-gray-900">New stock item added</p>
                                                    <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                            <div class="flex items-start space-x-3">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm text-gray-900">Stock level updated</p>
                                                    <p class="text-xs text-gray-500 mt-1">15 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 hover:bg-gray-50">
                                            <div class="flex items-start space-x-3">
                                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm text-gray-900">Low stock alert</p>
                                                    <p class="text-xs text-gray-500 mt-1">1 hour ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 border-t border-gray-200">
                                        <a href="#"
                                            class="text-sm text-primary hover:text-primary-dark font-medium">View all
                                            notifications</a>
                                    </div>
                                </div>
                            </div>

                            <!-- User Profile Dropdown -->
                            <div class="relative">
                                <button id="user-menu-btn"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <div class="hidden lg:block text-left">
                                        <p class="text-sm font-medium text-gray-900">Admin User</p>
                                        <p class="text-xs text-gray-500">Administrator</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs hidden lg:block"></i>
                                </button>

                                <!-- User Dropdown Menu -->
                                <div id="user-dropdown"
                                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="p-4 border-b border-gray-200">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Admin User</p>
                                                <p class="text-xs text-gray-500">admin@example.com</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-2">
                                        <a href="#"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user-circle w-4 h-4 mr-3"></i>
                                            My Profile
                                        </a>
                                        <a href="#"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cog w-4 h-4 mr-3"></i>
                                            Settings
                                        </a>
                                        <a href="#"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-question-circle w-4 h-4 mr-3"></i>
                                            Help & Support
                                        </a>
                                        <hr class="my-1">
                                        <a href="#"
                                            class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                                            Sign Out
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Header Row (Status Bar) -->
                <div class="bg-gray-50 border-t border-gray-200 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-12">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <i class="fas fa-clock text-gray-400"></i>
                                <span id="current-time"></span>
                            </div>

                            <div class="flex items-center space-x-2 text-sm">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-gray-600">System Online</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <div class="hidden md:flex items-center space-x-4">
                                <span>Total Items: <strong class="text-gray-900">1,234</strong></span>
                                <span>•</span>
                                <span>Low Stock: <strong class="text-red-600">5</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden"></div>

    <script>
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                }
            });
        });
        const notificationsBtn = document.getElementById('notifications-btn');
        const notificationsDropdown = document.getElementById('notifications-dropdown');

        notificationsBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationsDropdown.classList.toggle('hidden');
            document.getElementById('user-dropdown').classList.add('hidden');
        });

        const userMenuBtn = document.getElementById('user-menu-btn');
        const userDropdown = document.getElementById('user-dropdown');

        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
            notificationsDropdown.classList.add('hidden');
        });

        document.addEventListener('click', function() {
            notificationsDropdown.classList.add('hidden');
            userDropdown.classList.add('hidden');
        });

        notificationsDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit'
            });
            const dateString = now.toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric'
            });
            document.getElementById('current-time').textContent = `${dateString}, ${timeString}`;
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>

</html>
