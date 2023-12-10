<?php
// Initialize the session
session_start();
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$errors = array();
?>

<?php include_once('../components/header.php'); ?>
<div class="h-screen flex flex-col">
    <!-- Top Navbar -->
    <?php include('../components/navbar.php'); ?>
    <!-- End Top Navbar -->
    <!-- Main Content -->
    <div class="flex-grow bg-gray-50 flex flex-row shadow-md">
        <!-- Sidebar -->
        <?php include('../components/sidebar.php'); ?>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <main class="bg-gray-50 flex flex-col flex-1 overflow-y-scroll h-screen flex-shrink-0 sc-hide pb-40">
            <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                <!-- Header Content -->
                <header class="w-full border-b-2 border-gray-600 mb-2 pb-2">
                    <h1 class="text-3xl text-gray-800 font-semibold">Products</h1>
                    <div class="flex justify-end items-center">
                        <a href="<?php echo $baseUrl; ?>public/manage_products/manage_products_create.php" class="bg-green-500 hover-bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Create</span>
                        </a>
                    </div>
                </header>
                <!-- End Header Content -->
                <!-- Content -->
                <section class="w-full">
                    <!-- Navigation -->
                    <div class="flex justify-between items-center w-full mb-2 pb-2">
                        <div>
                            <h2 class="text-lg text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['FullName']; ?>!</h2>
                            <p class="text-gray-600 text-sm">Product information.</p>
                        </div>
                        <!-- Search -->
                        <form class="flex items-center justify-end space-x-2 w-96">
                            <input type="text" name="search" class="bg-gray-200 focus-bg-white focus-outline-none border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button type="submit" class="bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded space-x-2 inline-flex items-center">
                                <i class="fas fa-search"></i>
                                <span>Search</span>
                            </button>
                        </form>
                        <!-- End Search -->
                    </div>
                    <!-- End Navigation -->
                    <!-- Product List -->
                    <div class="flex flex-col w-full">
                        <?php
                        // Fetch product data from the database
                        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $query = "SELECT p.*, GROUP_CONCAT(i.IngredientName, ': ', pi.Quantity) AS Ingredients_List
                                  FROM Products p
                                  LEFT JOIN ProductIngredients pi ON p.ProductID = pi.ProductID
                                  LEFT JOIN Ingredients i ON pi.IngredientID = i.IngredientID
                                  WHERE p.ProductName LIKE '%$searchTerm%'
                                  GROUP BY p.ProductID
                                  LIMIT 15 OFFSET " . ($page - 1) * 15;
                        $result = $conn->query($query);

                        // Count total rows in the table
                        $queryCount = "SELECT COUNT(DISTINCT p.ProductID) AS count
                                       FROM Products p
                                       LEFT JOIN ProductIngredients pi ON p.ProductID = pi.ProductID
                                       LEFT JOIN Ingredients i ON pi.IngredientID = i.IngredientID
                                       WHERE p.ProductName LIKE '%$searchTerm%'";
                        $resultCount = $conn->query($queryCount);
                        $rowCount = $resultCount->fetch_assoc()['count'];
                        $totalPage = ceil($rowCount / 15);
                        $no = 1;

                        // Loop through the results and display data in div elements
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="border-b-2 border-gray-300 p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="ml-4 flex flex-row space-x-2">
                                        <div class="flex">
                                            <img src="../static/image/product/<?php echo $row['PhotoURL']; ?>" alt="<?php echo $row['ProductName']; ?>" class="w-40 h-40 object-cover rounded">
                                        </div>
                                        <div class="mt-2">
                                            <h3 class="text-xl text-gray-800 font-semibold"><?php echo $row['ProductName']; ?></h3>
                                            <p class="text-gray-600">Manufacturer: <?php echo $row['Manufacturer']; ?></p>
                                            <p class="text-gray-800">Selling Price (IDR): <?php echo number_format($row['SellingPrice'], 0, ',', '.'); ?></p>
                                            <p class="text-gray-800">Weight: <?php echo $row['Weight']; ?></p>
                                        </div>
                                        <table class="table-auto">
                                            <thead>
                                                <tr>
                                                    <th class="text-xs">Ingredient</th>
                                                    <th class="text-xs">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ingredients = explode(',', $row['Ingredients_List']);
                                                foreach ($ingredients as $ingredient) {
                                                    list($name, $quantity) = explode(':', $ingredient);
                                                ?>
                                                    <tr>
                                                        <td class="border text-xs"><?php echo $name; ?></td>
                                                        <td class="border text-xs"><?php echo $quantity; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <!-- Tombol-tombol action tetap di sisi kanan -->
                                        <a href="<?php echo $baseUrl; ?>public/manage_products/manage_products_detail.php?id=<?php echo $row['ProductID'] ?>" class='bg-green-500 hover-bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                                            <i class='fas fa-eye mr-2'></i>
                                            <span>Detail</span>
                                        </a>
                                        <a href="<?php echo $baseUrl; ?>public/manage_products/manage_products_update.php?id=<?php echo $row['ProductID'] ?>" class='bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                                            <i class='fas fa-edit mr-2'></i>
                                            <span>Edit</span>
                                        </a>
                                        <a href="#" onclick="confirmDelete(<?php echo $row['ProductID']; ?>)" class='bg-red-500 hover-bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm'>
                                            <i class='fas fa-trash mr-2'></i>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        if ($result->num_rows === 0) {
                        ?>
                            <div class="py-2 text-center text-gray-800">No data found.</div>
                        <?php
                        }
                        ?>
                    </div>
                    <!-- End Product List -->
                    <?php
                    // Pagination
                    ?>
                    <div class="flex justify-between items-center w-full mt-4">
                        <div class="flex items-center">
                            <span class="text-gray-600">Total <?php echo $rowCount; ?> rows</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="?page=1&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <a href="?page=<?php echo $page > 1 ? $page - 1 : 1; ?>&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-left"></i>
                            </a>
                            <!-- Page number -->
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPage, $page + 2);
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                if ($i == $page) {
                                    echo "<span class='bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center'>$i</span>";
                                } else {
                                    echo "<a href='?page=$i&search=$searchTerm' class='bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center'>$i</a>";
                                }
                            }
                            ?>
                            <a href="?page=<?php echo $page < $totalPage ? $page + 1 : $totalPage; ?>&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $totalPage; ?>&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600">Page <?php echo $page; ?> of <?php echo $totalPage; ?></span>
                        </div>
                    </div>
                </section>
                <!-- End Content -->
            </div>
        </main>
        <!-- End Main Content -->
    </div>
    <!-- End Main Content -->
    <!-- Footer -->
    <?php include('../components/footer.php'); ?>
    <!-- End Footer -->
</div>
<!-- End Main Content -->
<script>
    // Function to show a confirmation dialog
    function confirmDelete(productID) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, redirect to the delete page
                window.location.href = `manage_products_delete.php?id=${productID}`;
            }
        });
    }
</script>
</body>

</html>