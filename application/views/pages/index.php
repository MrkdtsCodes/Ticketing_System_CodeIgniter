<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.css" rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- 1. Left: Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <!-- Icon -->
                    <div class="bg-blue-600 p-1.5 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <!-- Text -->
                    <span class="text-xl font-bold text-gray-900 tracking-tight">Support<span class="text-blue-600">Desk</span></span>
                </div>

                <!-- 2. Center: Menu Lists -->
                <!-- Hidden on mobile (md:flex) to keep the navbar clean on small screens -->
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-blue-600 font-semibold text-sm">Dashboard</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium text-sm transition-colors">All Tickets</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium text-sm transition-colors">Departments</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium text-sm transition-colors">Reports</a>
                </div>

                <!-- 3 & 4. Right: Action Button & Profile -->
                <div class="flex items-center gap-4 sm:gap-6">
                    
                    <!-- Create Ticket Button -->
                    <a href="<?= base_url('ticket/create') ?>" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors shadow-sm focus:ring-4 focus:ring-blue-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="hidden sm:inline">Create Ticket</span>
                        <span class="sm:hidden">New</span> <!-- Shorter text for mobile -->
                    </a>

                    <!-- Vertical Divider (hidden on mobile) -->
                    <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>

                    <!-- Profile Area -->
                    <button type="button" class="flex items-center gap-2.5 rounded-full hover:bg-gray-50 p-1 pr-2 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <!-- Avatar -->
                        <img class="w-8 h-8 rounded-full object-cover border border-gray-200" 
                            src="https://ui-avatars.com/api/?name=John+Doe&background=eff6ff&color=1d4ed8" 
                            alt="User profile">
                        
                        <!-- Name & Role (Hidden on small screens) -->
                        <div class="hidden lg:block text-left">
                            <span class="block text-sm font-semibold text-gray-700 leading-none">John Doe</span>
                            <span class="block text-xs text-gray-500 mt-1">IT Admin</span>
                        </div>
                        
                        <!-- Dropdown Arrow -->
                        <svg class="w-4 h-4 text-gray-400 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                </div>
            </div>
        </div>
    </nav>

    <div>
        <!-- this is where your index goes -->
    </div>
</body>
</html>