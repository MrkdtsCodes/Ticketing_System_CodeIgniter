<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
</head>

<body>
    <?php $tickets = isset($tickets) ? $tickets : []; ?>
    <nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200 shadow-sm">
        <div class="max-w-screen-2xl mx-auto flex flex-wrap items-center justify-between p-4">

            <div class="flex items-center gap-8">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
                    <span class="self-center text-xl font-bold whitespace-nowrap text-gray-800">Flowbite</span>

                    <div class="hidden w-full md:block md:w-auto" id="navbar-sticky">
                        <ul
                            class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                            <li>
                                <a href="#"
                                    class="block py-2 px-3 text-gray-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600 md:p-0 transition-colors" 
                                    >Home</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block py-2 px-3 text-gray-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600 md:p-0 transition-colors">Dashboard</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('tickets/dashboard')?>"
                                    class="block py-2 px-3 text-gray-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600 md:p-0 transition-colors">Tickets</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block py-2 px-3 text-gray-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600 md:p-0 transition-colors">Reports</a>
                            </li>
                        </ul>
                    </div>
            </div>

            <div class="flex items-center gap-4 md:gap-6">

                <a href="<?php echo base_url('tickets/create') ?>">
                    <button type="button"
                        class="hidden md:flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 focus:outline-none transition-colors">
                        <svg class="rotate-12 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                            <path d="M9 12h6" />
                            <path d="M12 9v6" />
                        </svg>
                        Create Ticket
                    </button>
                </a>

                <button class="relative text-gray-500 hover:text-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                        <path
                            d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
                    </svg>
                    <span
                        class="absolute top-0 right-0 inline-flex items-center justify-center w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <div id="profile_dropdown" class=" flex items-center gap-3 cursor-pointer">
                    <span class="hidden md:block text-sm font-medium text-gray-700"> <?php if ($this->session->userdata('user_id')) {
                                                                                            echo  "<div class=''>" . strtoupper($this->session->userdata('firstname')) . " " . strtoupper($this->session->userdata('lastname')) . "</div>";
                                                                                        } ?></span>
                    <div class=" w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 border
                        border-gray-300 relative">
                        <div class="" ">
                            <svg xmlns=" http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>

                        <div class=" hidden absolute top-12 right-3 rounded-lg bg-white z-1 border border-black w-3xs"
                            id="dropdown_menu">
                            <ul class="">
                                <a href="<?php echo base_url('Logout') ?>">
                                    <li class="py-2 px-14 hover:bg-blue-700 hover:text-white" ">
                                        log out
                                    </li>
                                </a>

                                <a href=" <?php echo base_url(' ') ?>">
                                    <li class="py-2 px-14 hover:bg-blue-700 hover:text-white" ">
                                        settings
                                    </li>
                                </a>



                            </ul>

                        </div>
                    </div>
                </div>

                <button data-collapse-toggle=" navbar-sticky" type="button"
                                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                                        aria-controls="navbar-sticky" aria-expanded="false">
                                        <span class="sr-only">Open main menu</span>
                                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                        </button>
                        </div>
                    </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script>
        const profile_dropdown = document.getElementById('profile_dropdown');
        const dropdown_menu = document.getElementById('dropdown_menu');

        profile_dropdown.addEventListener('click', () => {

            dropdown_menu.classList.toggle('hidden');


        });
    </script>
</body>


</html>