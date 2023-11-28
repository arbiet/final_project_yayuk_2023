<?php
session_start();

// Include the database connection
require_once('../../database/connection.php');
include_once('../components/header.php');

// Initialize variables
$ingredient_id = $quantity = $transaction_type = '';

$errors = array();

// Fetching available ingredients
$ingredients_query = "SELECT IngredientID, IngredientName FROM Ingredients";
$ingredients_result = $conn->query($ingredients_query);

// Form submission process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $ingredient_id = mysqli_real_escape_string($conn, $_POST['ingredient_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $transaction_type = 'in';

    // Check for errors
    if (empty($ingredient_id)) {
        $errors['ingredient_id'] = "Ingredient is a required field.";
    }
    if (empty($quantity)) {
        $errors['quantity'] = "Quantity is a required field.";
    }

    // If no errors, insert data into IngredientStocks and IngredientTransactions
    if (empty($errors)) {
        // Check if IngredientStocks entry exists
        $existing_stock_query = "SELECT * FROM IngredientStocks WHERE IngredientID = ?";
        $existing_stock_stmt = $conn->prepare($existing_stock_query);
        $existing_stock_stmt->bind_param("s", $ingredient_id);
        $existing_stock_stmt->execute();
        $existing_stock_result = $existing_stock_stmt->get_result();
        if ($existing_stock_result->num_rows > 0) {
            // Existing IngredientStocks entry
            $existing_stock_row = $existing_stock_result->fetch_assoc();
            $old_quantity = $existing_stock_row['Quantity'];
            $old_quantityperservings = $existing_stock_row['QuantityPerServings'];

            // Fetch QuantityPerPurchase and ServingsPerIngredient from Ingredients table
            $ingredient_info_query = "SELECT QuantityPerPurchase, ServingsPerIngredient FROM Ingredients WHERE IngredientID = ?";
            $ingredient_info_stmt = $conn->prepare($ingredient_info_query);
            $ingredient_info_stmt->bind_param("s", $ingredient_id);
            $ingredient_info_stmt->execute();

            // Store the result set for later use
            $ingredient_info_result = $ingredient_info_stmt->get_result();
            $ingredient_info_row = $ingredient_info_result->fetch_assoc();

            // Calculate new quantity using values from Ingredients table
            $quantityperservings = $old_quantityperservings + ($quantity * $ingredient_info_row['QuantityPerPurchase'] * $ingredient_info_row['ServingsPerIngredient']);
            $quantity = $old_quantity + $quantity;


            // Update existing IngredientStocks entry
            $update_stock_query = "UPDATE IngredientStocks SET Quantity = ?, QuantityPerServings = ? WHERE IngredientID = ?";
            $update_stock_stmt = $conn->prepare($update_stock_query);
            $update_stock_stmt->bind_param("dds", $new_quantity, $new_quantityperservings, $ingredient_id);
            $update_stock_stmt->execute();

            // Close the statement
            $update_stock_stmt->close();
        } else {
            $existing_ingredient_query = "SELECT * FROM Ingredients WHERE IngredientID = ?";
            $existing_ingredient_stmt = $conn->prepare($existing_ingredient_query);
            $existing_ingredient_stmt->bind_param("s", $ingredient_id);
            $existing_ingredient_stmt->execute();

            // Store the result set for later use
            $existing_ingredient_result = $existing_ingredient_stmt->get_result();

            if ($existing_ingredient_result->num_rows > 0) {
                $existing_ingredient_row = $existing_ingredient_result->fetch_assoc();

                $quantityperservings = ($quantity * $existing_ingredient_row['QuantityPerPurchase'] * $existing_ingredient_row['ServingsPerIngredient']);
                $quantity = $quantity;

                // Insert new IngredientStocks entry
                $insert_stock_query = "INSERT INTO IngredientStocks (IngredientID, Quantity, QuantityPerServings, LastUpdateStock) VALUES (?, ?, ?, NOW())";
                $insert_stock_stmt = $conn->prepare($insert_stock_query);
                $insert_stock_stmt->bind_param("sdd", $ingredient_id, $quantity, $quantityperservings);
                $insert_stock_stmt->execute();

                // Close the statement
                $insert_stock_stmt->close();
            }

            // Close the statement
            $existing_ingredient_stmt->close();
        }

        // Insert entry into IngredientTransactions
        $insert_transaction_query = "INSERT INTO IngredientTransactions (IngredientID, TransactionType, Quantity, QuantityPerServings, Timestamp) VALUES (?, ?, ?, ?, NOW())";
        $insert_transaction_stmt = $conn->prepare($insert_transaction_query);
        $insert_transaction_stmt->bind_param("ssdd", $ingredient_id, $transaction_type, $quantity, $quantityperservings);
        $insert_transaction_stmt->execute();

        // Display success message and redirect
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Ingredient stock added successfully.",
            }).then(function() {
                window.location.href = "manage_ingredient_stocks_list.php";
            });
        </script>';
        exit();
    }
}

// Close the database connection
?>

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
                <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Tambah Stok Bahan</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="manage_ingredient_stocks_list.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
                <!-- End Header Content -->

                <!-- Content -->
                <div class="flex flex-col w-full">
                    <!-- Navigation -->
                    <div class="flex flex-row justify-between items-center w-full pb-2">
                        <div>
                            <h2 class="text-lg text-gray-800 font-semibold">Selamat datang kembali, <?php echo $_SESSION['FullName']; ?>!</h2>
                            <p class="text-gray-600 text-sm">Formulir penambahan stok bahan.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Ingredient Stock Addition Form -->
                    <form action="" method="POST" class="flex flex-col w-full space-x-2">
                        <!-- Ingredient Selector -->
                        <label for="ingredient_id" class="block font-semibold text-gray-800 mt-2 mb-2">Bahan <span class="text-red-500">*</span></label>
                        <select id="ingredient_id" name="ingredient_id" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
                            <?php
                            while ($row = $ingredients_result->fetch_assoc()) {
                                echo "<option value='{$row['IngredientID']}'>{$row['IngredientName']}</option>";
                            }
                            ?>
                        </select>
                        <?php if (isset($errors['ingredient_id'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['ingredient_id']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Quantity -->
                        <label for="quantity" class="block font-semibold text-gray-800 mt-2 mb-2">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" id="quantity" name="quantity" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Jumlah" value="<?php echo $quantity; ?>" step="any">
                        <?php if (isset($errors['quantity'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['quantity']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-4 text-center">
                            <i class="fas fa-check mr-2"></i>
                            <span>Tambah Stok Bahan</span>
                        </button>
                    </form>
                </div>
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

</body>

</html>