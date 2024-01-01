<aside class="bg-gray-800 text-white w-64 overflow-y-scroll h-screen flex-shrink-0 sc-hide">
    <ul class="text-gray-400">
        <li class="px-6 py-4 hover:bg-gray-700 cursor-pointer space-x-2 flex items-center">
            <i class="fas fa-tachometer-alt mr-3"></i>
            <a href="../systems/dashboard.php">Dashboard</a>
        </li>
        <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
            <i class="fas fa-user mr-3"></i>
            <a href="../profiles/profile.php">Profile</a>
        </li>
        <?php
        if ($_SESSION['RoleID'] === 1) {
            // Menu "Users" hanya ditampilkan jika peran pengguna adalah "Admin"
            echo '
            <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
                <i class="fas fa-user-cog mr-3"></i>
                <a href="../manage_users/manage_users_list.php">Users</a>
            </li>
            ';
            echo '
            <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
                <i class="fa-solid fa-cloud-meatball mr-3"></i>
                <a href="../manage_ingredients/manage_ingredients_list.php">Ingredients</a>
            </li>
            ';
            // echo '
            // <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
            //     <i class="fa-solid fa-utensils mr-3"></i>
            //     <a href="../manage_products/manage_products_list.php">Products</a>
            // </li>
            // ';

            // echo '
            // <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
            //     <i class="fa-solid fa-money-bill-transfer mr-3"></i>
            //     <a href="../manage_transactions/manage_transactions_list.php">Transactions</a>
            // </li>
            // ';

        }
        echo '
            <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
                <i class="fa-solid fa-cubes-stacked mr-3"></i>
                <a href="../manage_ingredient_stocks/manage_ingredient_stocks_list.php">Ingredient Stock</a>
            </li>
            ';
        echo '
            <li class="px-6 py-4 hover-bg-gray-700 cursor-pointer space-x-2 flex items-center">
                <i class="fa-solid fa-utensils mr-3"></i>
                <a href="../manage_restocks/manage_restocks_list.php">Restock Analisis</a>
            </li>
            ';
        ?>
    </ul>
    <hr class="mt-60 border-transparent">
</aside>
<script>
    // Mendapatkan halaman saat ini
    var currentPage = window.location.href;

    // Mengambil semua tautan dalam daftar
    var links = document.querySelectorAll("aside ul li a");

    // Loop melalui tautan dan periksa jika URL cocok
    links.forEach(function(link) {
        var currentPathParts = currentPage.split("/");
        var linkPathParts = link.href.split("/");
        if (linkPathParts[linkPathParts.length - 2] === currentPathParts[currentPathParts.length - 2]) {
            if (currentPathParts[currentPathParts.length - 2] != "systems") {
                link.parentElement.classList.add("bg-gray-700");
            } else if (currentPathParts[currentPathParts.length - 2] == "systems" && link.href === currentPage) {
                link.parentElement.classList.add("bg-gray-700");
            }
        }
    });
</script>