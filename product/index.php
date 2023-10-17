<?php
include_once("C:\\xampp\htdocs\portfolio\product.php");

$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';

$counter = 1;
$records_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$products = readProducts($page, $records_per_page, $search_query);
$productCount = countProducts($search_query);
$total_pages = ceil(countProducts() / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Favicon  -->
    <link rel="icon" href="/portfolio/images/favicon.png" />
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <nav class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50" aria-label="side-bar">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-start items-center">
                    <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation" class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>
                    <a href="/product/" class="flex items-center justify-between mr-4">
                        <img src="/portfolio/images/favicon-.png" class="logo logo-light hidden mr-3 h-8" alt="Logo" />
                        <img src="/portfolio/images/favicon.png" class="logo logo-dark hidden mr-3 h-8" alt="Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center lg:order-2">
                    <!-- Dark Mode Button -->
                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- User Menu -->
                    <button type="button" class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="/portfolio/images/default-profile.webp" alt="user photo" />
                    </button>
                    <!-- Dropdown menu -->
                    <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl" id="dropdown">
                        <div class="py-3 px-4 grid justify-center">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Admin</span>
                            <span class="block text-sm text-gray-900 truncate dark:text-white">admin@admin.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->

        <aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav" id="drawer-navigation">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span class="ml-3">Overview</span>
                        </a>
                    </li>
                    <li>
                        <button type="button" class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">Dashboard</span>
                            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                            <li>
                                <a href="/product/" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-current="page">Product</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                    <li>
                        <a href="/" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3">About Me</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="p-4 md:ml-64 h-auto pt-20">
            <section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
                <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
                    <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                        <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                            <div class="flex items-center flex-1 space-x-4">
                                <h5>
                                    <span class="text-gray-500">All Products:</span>
                                    <span class="dark:text-white"><?= $productCount; ?></span>
                                </h5>
                                <form action="" method="GET" class="flex items-center">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" id="simple-search" name="query" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required="" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                                    </div>
                                    <button type="submit" class="ml-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-white px-4 py-2 rounded-lg">Search</button>
                                </form>
                            </div>
                            <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                                <!-- Modal toggle -->
                                <div class="flex justify-center m-5">
                                    <button id="defaultModalButton" data-modal-toggle="defaultModal" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button">
                                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg>
                                        Add new product
                                    </button>
                                </div>
                                <!-- Main modal -->
                                <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                            <!-- Modal header -->
                                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Add Product
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <form action="/portfolio/add_product.php" method="POST" enctype="multipart/form-data">
                                                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                    <div>
                                                        <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                        <input type="text" name="product_name" id="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type product name" required="">
                                                    </div>
                                                    <div>
                                                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                                                        <input type="number" name="stock" id="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter stock" required="">
                                                    </div>
                                                    <div>
                                                        <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase Price</label>
                                                        <input type="number" name="purchase_price" id="purchase_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter purchase price" required="">
                                                    </div>
                                                    <div>
                                                        <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling Price</label>
                                                        <input type="number" name="selling_price" id="selling_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter selling price" required="">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="product_image">Product Image</label>
                                                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="product_image" name="product_image" type="file" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Add new product
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="product-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400" aria-describedby="Product Table">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">No</th>
                                        <th scope="col" class="px-4 py-3">Product</th>
                                        <th scope="col" class="px-4 py-3">Stock</th>
                                        <th scope="col" class="px-4 py-3">Purchase Price</th>
                                        <th scope="col" class="px-4 py-3">Selling Price</th>
                                        <th scope="col" class="px-4 py-3">Last Update</th>
                                        <th scope="col" class="py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <tr class="border-b dark:border-gray-600">
                                            <td class="w-4 px-4 py-3">
                                                <div class="flex items-center">
                                                    <?= $counter++ ?>
                                                </div>
                                            </td>
                                            <th scope="row" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <img src="<?= $product['product_image']; ?>" alt="<?= $product['product_name']; ?> Image" class="w-auto h-8 mr-3">
                                                <?= $product['product_name']; ?>
                                            </th>
                                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center">
                                                    <div class="<?= ($product['stock'] == 0) ? 'bg-red-700' : 'bg-green-700'; ?> inline-block w-4 h-4 mr-2 rounded-full"></div>
                                                    <?= $product['stock']; ?>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $product['purchase_price']; ?></td>
                                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $product['selling_price']; ?></td>
                                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $product['updated_at']; ?></td>
                                            <td class="px-4 py-3 flex items-center justify-center">
                                                <!-- Modal toggle -->
                                                <div class="flex justify-center m-5">
                                                    <button id="readProductButton" data-modal-toggle="readProductModal<?= $product['id']; ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Main modal -->
                                                <div id="readProductModal<?= $product['id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                                    <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
                                                        <!-- Modal content -->
                                                        <div class="relative p-4 bg-gray-100 rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                            <!-- Modal header -->
                                                            <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                                                                <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                                                                    <h3 class="font-semibold ">
                                                                        <?= $product['product_name']; ?>
                                                                    </h3>
                                                                    <h4 class="font-medium">
                                                                        Stock : <?= $product['stock']; ?>
                                                                    </h4>
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readProductModal<?= $product['id']; ?>">
                                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                        </svg>
                                                                        <span class="sr-only">Close modal</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-center">
                                                                <img class="h-auto max-w-xs" src="<?= $product['product_image']; ?>" alt="<?= $product['product_name']; ?>">
                                                            </div>
                                                            <div class="flex justify-between text-lg text-gray-900 md:text-xl dark:text-white">
                                                                <h4 class="font-medium my-2">
                                                                    Purchase Price : <?= $product['purchase_price']; ?>
                                                                </h4>
                                                                <h4 class="font-medium my-2">
                                                                    Selling Price : <?= $product['selling_price']; ?>
                                                                </h4>
                                                            </div>
                                                            <div class="flex justify-between items-center">
                                                                <div class="flex items-center space-x-3 sm:space-x-4">
                                                                    <!-- Modal toggle -->
                                                                    <div class="flex justify-center m-5">
                                                                        <button id="updateProductButton" data-modal-toggle="updateProductModal<?= $product['id']; ?>" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                                            <svg aria-hidden="true" class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            Update Product
                                                                        </button>
                                                                    </div>

                                                                    <!-- Main modal -->
                                                                    <div id="updateProductModal<?= $product['id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                                                            <!-- Modal content -->
                                                                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700 sm:p-5">
                                                                                <!-- Modal header -->
                                                                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                        Update Product
                                                                                    </h3>
                                                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal<?= $product['id']; ?>">
                                                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                                        </svg>
                                                                                        <span class="sr-only">Close modal</span>
                                                                                    </button>
                                                                                </div>
                                                                                <!-- Modal body -->
                                                                                <form action="/portfolio/update_product.php" method="POST" enctype="multipart/form-data">
                                                                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                                                        <div>
                                                                                            <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                                                            <input type="text" name="product_name" id="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type product name" required="" value="<?= $product['product_name']; ?>">
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                                                                                            <input type="number" name="stock" id="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter stock" required="" value="<?= $product['stock']; ?>">
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase Price</label>
                                                                                            <input type="number" name="purchase_price" id="purchase_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter purchase price" required="" value="<?= $product['purchase_price']; ?>">
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling Price</label>
                                                                                            <input type="number" name="selling_price" id="selling_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter selling price" required="" value="<?= $product['selling_price']; ?>">
                                                                                        </div>
                                                                                        <div>
                                                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="product_image">Product Image</label>
                                                                                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="product_image" name="product_image" type="file" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex items-center space-x-4">
                                                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                                            Update
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal toggle -->
                                                                <div class="flex justify-center m-5">
                                                                    <button id="deleteButton" data-modal-toggle="deleteModal<?= $product['id']; ?>" class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900" type="button">
                                                                        <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                                        </svg>
                                                                        Delete
                                                                    </button>
                                                                </div>

                                                                <!-- Main modal -->
                                                                <div id="deleteModal<?= $product['id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                                                        <!-- Modal content -->
                                                                        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-700 sm:p-5">
                                                                            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal<?= $product['id']; ?>">
                                                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                                </svg>
                                                                                <span class="sr-only">Close modal</span>
                                                                            </button>
                                                                            <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                                                                            <div class="flex justify-center items-center space-x-4">
                                                                                <button data-modal-toggle="deleteModal<?= $product['id']; ?>" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                                                    No, cancel
                                                                                </button>
                                                                                <form action="/portfolio/delete_product.php" method="GET">
                                                                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                                                    <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                                                        Yes, I'm sure
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0" aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                Showing
                                <span class="font-semibold text-gray-900 dark:text-white"><?= ($page - 1) * $records_per_page + 1; ?></span>
                                -
                                <span class="font-semibold text-gray-900 dark:text-white"><?= min($page * $records_per_page, $productCount); ?></span>
                                of
                                <span class="font-semibold text-gray-900 dark:text-white"><?= $productCount; ?></span>
                            </span>
                            <ul class="flex items-center space-x-2">
                                <?php if ($page > 1) : ?>
                                    <li>
                                        <a href="?page=1" class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-lg hover:bg-gray-300">
                                            <span class="sr-only">Previous</span>
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M13.293 7.707a1 1 0 010 1.414L10.414 12l2.879 2.879a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $numPages = ceil($productCount / $records_per_page);
                                $maxPagesToShow = 10; // Maximum number of pages to show in the pagination

                                $startPage = max(min($page - floor($maxPagesToShow / 2), $numPages - $maxPagesToShow + 1), 1);
                                $endPage = min(max($startPage + $maxPagesToShow - 1, $maxPagesToShow), $numPages);

                                // Display ellipsis before page numbers if needed
                                if ($startPage > 1) {
                                    echo '<li><span class="text-gray-600 dark:text-gray-200">...</span></li>';
                                }

                                // Display page numbers
                                for ($i = $startPage; $i <= $endPage; $i++) {
                                    echo '<li><a href="?page=' . $i . '" class="flex items-center justify-center w-8 h-8 ' . (($page == $i) ? 'bg-blue-700 text-white' : 'bg-gray-200 hover:bg-gray-300') . ' rounded-full">' . $i . '</a></li>';
                                }

                                // Display ellipsis after page numbers if needed
                                if ($endPage < $numPages) {
                                    echo '<li><span class="text-gray-600 dark:text-gray-200">...</span></li>';
                                }
                                ?>

                                <?php if ($page < $numPages) : ?>
                                    <li>
                                        <a href="?page=<?= $numPages; ?>" class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-lg hover:bg-gray-300">
                                            <span class="sr-only">Next</span>
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10.707 16.293a1 1 0 010-1.414L13.586 12l-2.879-2.879a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <!-- DarkMode Js -->
    <script src="/portfolio/js/darkmode.js"></script>
    <!-- Modal Js  -->
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('defaultModalButton').click();
        });
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('readProductButton').click();
        });
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('updateProductButton').click();
        });
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('deleteButton').click();
        });
    </script>
</body>

</html>