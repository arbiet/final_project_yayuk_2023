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
        <main class=" bg-gray-50 flex flex-col flex-1 overflow-y-scroll h-screen flex-shrink-0 sc-hide pb-40">
            <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                <!-- Header Content -->
                <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
                    <h1 class="text-3xl text-gray-800 font-semibol w-full">Ingredient Stocks</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="<?php echo $baseUrl; ?>public/manage_ingredient_stocks/manage_ingredient_stocks_add.php" class="bg-green-500 hover-bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Create</span>
                        </a>
                    </div>
                </div>
                <!-- End Header Content -->
                <!-- Content -->
                <div class="flex flex-col w-full">
                    <!-- Navigation -->
                    <div class="flex flex-row justify-between items-center w-full mb-2 pb-2">
                        <div>
                            <h2 class="text-lg text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['FullName']; ?>!</h2>
                            <p class="text-gray-600 text-sm">Ingredient stock information.</p>
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
                    <!-- Table -->
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left py-2">No</th>
                                <th class="text-left py-2">Ingredient Name</th>
                                <th class="text-left py-2">Quantity</th>
                                <th class="text-left py-2">Quantity Per Servings</th>
                                <th class="text-left py-2">Last Update</th>
                                <th class="text-left py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch ingredient stock data from the database
                            $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $query = "SELECT IngStk.StockID, IngStk.IngredientID, IngStk.Quantity, IngStk.QuantityPerServings, IngStk.LastUpdateStock, I.IngredientName
                                FROM IngredientStocks IngStk
                                INNER JOIN Ingredients I ON IngStk.IngredientID = I.IngredientID
                                WHERE I.IngredientName LIKE '%$searchTerm%'
                                LIMIT 15 OFFSET " . ($page - 1) * 15;
                            $result = $conn->query($query);

                            // Count total rows in the table
                            $queryCount = "SELECT COUNT(*) AS count
                                FROM IngredientStocks IngStk
                                INNER JOIN Ingredients I ON IngStk.IngredientID = I.IngredientID
                                WHERE I.IngredientName LIKE '%$searchTerm%'";
                            $resultCount = $conn->query($queryCount);
                            $rowCount = $resultCount->fetch_assoc()['count'];
                            $totalPage = ceil($rowCount / 15);
                            $no = 1;

                            // Loop through the results and display data in rows
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="py-2"><?php echo $no++; ?></td>
                                    <td class="py-2"><?php echo $row['IngredientName']; ?></td>
                                    <td class="py-2"><?php echo $row['Quantity']; ?></td>
                                    <td class="py-2"><?php echo $row['QuantityPerServings']; ?></td>
                                    <td class="py-2"><?php echo $row['LastUpdateStock']; ?></td>
                                    <td class='py-2'>
                                        <a href="#" onclick="showStockInForm(<?php echo $row['IngredientID']; ?>)" class='bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2 text-sm'>
                                            <i class='fas fa-plus mr-2'></i>
                                            <span>In</span>
                                        </a>
                                        <a href="#" onclick="showStockOutForm(<?php echo $row['IngredientID']; ?>)" class='bg-red-500 hover-bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm'>
                                            <i class='fas fa-minus mr-2'></i>
                                            <span>Out</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            if ($result->num_rows === 0) {
                            ?>
                                <tr>
                                    <td colspan="5" class="py-2 text-center">No data found.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- End Table -->
                    <?php
                    // Pagination
                    ?>
                    <div class="flex flex-row justify-between items-center w-full mt-4">
                        <div class="flex flex-row justify-start items-center">
                            <span class="text-gray-600">Total <?php echo $rowCount; ?> rows</span>
                        </div>
                        <div class="flex flex-row justify-end items-center space-x-2">
                            <a href="?page=1&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <a href="?page=<?php if ($page == 1) {
                                                echo $page;
                                            } else {
                                                echo $page - 1;
                                            } ?>&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-left"></i>
                            </a>
                            <!-- Page number -->
                            <?php
                            $startPage = $page - 2;
                            $endPage = $page + 2;
                            if ($startPage < 1) {
                                $endPage += abs($startPage) + 1;
                                $startPage = 1;
                            }
                            if ($endPage > $totalPage) {
                                $startPage -= $endPage - $totalPage;
                                $endPage = $totalPage;
                            }
                            if ($startPage < 1) {
                                $startPage = 1;
                            }
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                if ($i == $page) {
                                    echo "<a href='?page=$i&search=$searchTerm' class='bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center'>$i</a>";
                                } else {
                                    echo "<a href='?page=$i&search=$searchTerm' class='bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center'>$i</a>";
                                }
                            }
                            ?>
                            <a href="?page=<?php if ($page == $totalPage) {
                                                echo $page;
                                            } else {
                                                echo $page + 1;
                                            } ?>&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $totalPage; ?>&search=<?php echo $searchTerm; ?>" class="bg-gray-200 hover-bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                        <div class="flex flex-row justify-end items-center ml-2">
                            <span class="text-gray-600">Page <?php echo $page; ?> of <?php echo $totalPage; ?></span>
                        </div>
                    </div>
                </div>
                <!-- End Content -->
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
    function confirmDelete(ingredientID) {
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
                window.location.href = `manage_ingredients_delete.php?id=${ingredientID}`;
            }
        });
    }
</script>
<script>
// Function to show a SweetAlert dialog with a form for stock in
function showStockInForm(ingredientID) {
    Swal.fire({
        title: 'Stock In',
        html:
            `<form id="stockInForm" class="p-4">
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                    <input type="date" id="date" name="date" required class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </form>`,
        showCancelButton: true,
        confirmButtonText: 'Stock In',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const quantity = document.getElementById('quantity').value;
            const date = document.getElementById('date').value;

            // Perform AJAX request here
            return fetch(`in.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${ingredientID}&quantity=${quantity}&date=${date}`,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                    console.error('Request failed:', error);
                });
        }
    }).then((result) => {
        // Handle the result
        if (result.isConfirmed && result.value.status === 'success') {
            Swal.fire({
                title: 'Success!',
                text: result.value.message,
                icon: 'success',
            }).then(() => {
                location.reload(); // Reload the page
            });
        } else if (result.isConfirmed && result.value.status === 'error') {
            Swal.fire({
                title: 'Error!',
                text: result.value.message,
                icon: 'error',
            });
        }
    });
}

// Function to show a SweetAlert dialog with a form for stock out
function showStockOutForm(ingredientID) {
    Swal.fire({
        title: 'Stock Out',
        html:
            `<form id="stockOutForm" class="p-4">
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                    <input type="date" id="date" name="date" required class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </form>`,
        showCancelButton: true,
        confirmButtonText: 'Stock Out',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const quantity = document.getElementById('quantity').value;
            const date = document.getElementById('date').value;

            // Perform AJAX request here
            return fetch(`out.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${ingredientID}&quantity=${quantity}&date=${date}`,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                    console.error('Request failed:', error);
                });
        }
    }).then((result) => {
        // Handle the result
        if (result.isConfirmed && result.value.status === 'success') {
            Swal.fire({
                title: 'Success!',
                text: result.value.message,
                icon: 'success',
            }).then(() => {
                location.reload(); // Reload the page
            });
        } else if (result.isConfirmed && result.value.status === 'error') {
            Swal.fire({
                title: 'Error!',
                text: result.value.message,
                icon: 'error',
            });
        }
    });
}
</script>


</body>

</html>