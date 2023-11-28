<?php
session_start();

// Include the database connection
require_once('../../database/connection.php');
include_once('../components/header.php');

// Initialize variables
$ingredient_id = $ingredient_name = $purchase_price = $quantity_per_purchase = $servings_per_ingredient = '';
$holding_cost = $holding_cost_price = $shelf_life = $supplier_name = $description = $minimum_stock = '';
$storage_location = $purchase_unit = '';
$errors = array();

// Retrieve the ingredient's data to be updated (you might need to pass the ingredient ID to this page)
if (isset($_GET['id'])) {
    $ingredient_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch the existing ingredient data
    $query = "SELECT * FROM Ingredients WHERE IngredientID = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $ingredient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ingredient = $result->fetch_assoc();

    // Check if the ingredient exists
    if (!$ingredient) {
        // Ingredient not found, handle accordingly (e.g., redirect to an error page)
    } else {
        // Populate variables with existing ingredient data
        $ingredient_name = $ingredient['IngredientName'];
        $purchase_price = $ingredient['PurchasePrice'];
        $quantity_per_purchase = $ingredient['QuantityPerPurchase'];
        $servings_per_ingredient = $ingredient['ServingsPerIngredient'];
        $holding_cost = $ingredient['HoldingCost'];
        $holding_cost_price = $ingredient['HoldingCostPrice'];
        $shelf_life = $ingredient['ShelfLife'];
        $supplier_name = $ingredient['SupplierName'];
        $description = $ingredient['Description'];
        $minimum_stock = $ingredient['MinimumStock'];
        $storage_location = $ingredient['StorageLocation'];
        $purchase_unit = $ingredient['PurchaseUnit'];
        // You can also retrieve other fields as needed
    }
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the input data (similar to create ingredient form)
    $ingredient_name = mysqli_real_escape_string($conn, $_POST['ingredient_name']);
    $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
    $quantity_per_purchase = mysqli_real_escape_string($conn, $_POST['quantity_per_purchase']);
    $servings_per_ingredient = mysqli_real_escape_string($conn, $_POST['servings_per_ingredient']);
    $holding_cost = mysqli_real_escape_string($conn, isset($_POST['holding_cost']) ? 1 : 0);
    $holding_cost_price = mysqli_real_escape_string($conn, $_POST['holding_cost_price']);
    $shelf_life = mysqli_real_escape_string($conn, $_POST['shelf_life']);
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $minimum_stock = mysqli_real_escape_string($conn, $_POST['minimum_stock']);
    $storage_location = mysqli_real_escape_string($conn, $_POST['storage_location']);
    $purchase_unit = mysqli_real_escape_string($conn, $_POST['purchase_unit']);
    // You should validate the fields and handle errors as needed

    // Update ingredient data in the database
    $query = "UPDATE Ingredients 
              SET IngredientName = ?, PurchasePrice = ?, QuantityPerPurchase = ?, ServingsPerIngredient = ?, 
                  HoldingCost = ?, HoldingCostPrice = ?, ShelfLife = ?, SupplierName = ?, Description = ?, 
                  MinimumStock = ?, StorageLocation = ?, PurchaseUnit = ? 
              WHERE IngredientID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sdddiidssdsss",
        $ingredient_name,
        $purchase_price,
        $quantity_per_purchase,
        $servings_per_ingredient,
        $holding_cost,
        $holding_cost_price,
        $shelf_life,
        $supplier_name,
        $description,
        $minimum_stock,
        $storage_location,
        $purchase_unit,
        $ingredient_id
    );

    if ($stmt->execute()) {
        // Update successful
        $activityDescription = "Ingredient with Name: $ingredient_name has been updated.";

        $currentUserID = $_SESSION['UserID'];
        insertLogActivity($conn, $currentUserID, $activityDescription);

        // Display SweetAlert notification for success
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Ingredient update successful.",
        }).then(function() {
            window.location.href = "manage_ingredients_list.php";
        });
    </script>';
        exit();
    } else {
        // Update failed
        $errors['db_error'] = "Ingredient update failed.";

        // Display SweetAlert notification for failure
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ingredient update failed.",
        });
    </script>';
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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Update Ingredient</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="manage_ingredients_list.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
                <!-- End Header Content -->
                <!-- Content -->
                <div class="flex flex-col w-full">
                    <!-- Navigation -->
                    <div class="flex flex-row justify-between items-center w-full pb-2">
                        <div>
                            <h2 class="text-lg text-gray-800 font-semibold">Welcome back, <?php echo $_SESSION['FullName']; ?>!</h2>
                            <p class="text-gray-600 text-sm">Update ingredient information form.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Ingredient Update Form -->
                    <form action="" method="POST" class="flex flex-col w-full space-x-2">
                        <!-- Ingredient Name -->
                        <label for="ingredient_name" class="block font-semibold text-gray-800 mt-2 mb-2">Ingredient Name <span class="text-red-500">*</span></label>
                        <input type="text" id="ingredient_name" name="ingredient_name" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Ingredient Name" value="<?php echo $ingredient_name; ?>">
                        <?php if (isset($errors['ingredient_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['ingredient_name']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Purchase Price -->
                        <label for="purchase_price" class="block font-semibold text-gray-800 mt-2 mb-2">Purchase Price <span class="text-red-500">*</span></label>
                        <input type="number" id="purchase_price" name="purchase_price" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Purchase Price" value="<?php echo $purchase_price; ?>">
                        <?php if (isset($errors['purchase_price'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['purchase_price']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Quantity per Purchase -->
                        <label for="quantity_per_purchase" class="block font-semibold text-gray-800 mt-2 mb-2">Quantity per Purchase <span class="text-red-500">*</span></label>
                        <input type="number" id="quantity_per_purchase" name="quantity_per_purchase" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Quantity per Purchase" value="<?php echo $quantity_per_purchase; ?>">
                        <?php if (isset($errors['quantity_per_purchase'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['quantity_per_purchase']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Servings per Ingredient -->
                        <label for="servings_per_ingredient" class="block font-semibold text-gray-800 mt-2 mb-2">Servings per Ingredient <span class="text-red-500">*</span></label>
                        <input type="number" id="servings_per_ingredient" name="servings_per_ingredient" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Servings per Ingredient" value="<?php echo $servings_per_ingredient; ?>">
                        <?php if (isset($errors['servings_per_ingredient'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['servings_per_ingredient']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Holding Cost -->
                        <label for="holding_cost" class="block font-semibold text-gray-800 mt-2 mb-2">Holding Cost</label>
                        <input type="checkbox" id="holding_cost" name="holding_cost" class="mr-2" <?php echo ($holding_cost == 1) ? 'checked' : ''; ?>>

                        <!-- Holding Cost Price -->
                        <label for="holding_cost_price" class="block font-semibold text-gray-800 mt-2 mb-2">Holding Cost Price</label>
                        <input type="number" id="holding_cost_price" name="holding_cost_price" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Holding Cost Price" value="<?php echo $holding_cost_price; ?>">
                        <?php if (isset($errors['holding_cost_price'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['holding_cost_price']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Shelf Life -->
                        <label for="shelf_life" class="block font-semibold text-gray-800 mt-2 mb-2">Shelf Life</label>
                        <input type="text" id="shelf_life" name="shelf_life" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Shelf Life" value="<?php echo $shelf_life; ?>">
                        <?php if (isset($errors['shelf_life'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['shelf_life']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Supplier Name -->
                        <label for="supplier_name" class="block font-semibold text-gray-800 mt-2 mb-2">Supplier Name</label>
                        <input type="text" id="supplier_name" name="supplier_name" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Supplier Name" value="<?php echo $supplier_name; ?>">
                        <?php if (isset($errors['supplier_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['supplier_name']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Description -->
                        <label for="description" class="block font-semibold text-gray-800 mt-2 mb-2">Description</label>
                        <textarea id="description" name="description" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Description"><?php echo $description; ?></textarea>

                        <!-- Minimum Stock -->
                        <label for="minimum_stock" class="block font-semibold text-gray-800 mt-2 mb-2">Minimum Stock</label>
                        <input type="number" id="minimum_stock" name="minimum_stock" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Minimum Stock" value="<?php echo $minimum_stock; ?>">
                        <?php if (isset($errors['minimum_stock'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['minimum_stock']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Storage Location -->
                        <label for="storage_location" class="block font-semibold text-gray-800 mt-2 mb-2">Storage Location</label>
                        <select id="storage_location" name="storage_location" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
                            <option value="Cool Storage" <?php echo ($storage_location === 'Cool Storage') ? 'selected' : ''; ?>>Cool Storage</option>
                            <option value="Dry Storage" <?php echo ($storage_location === 'Dry Storage') ? 'selected' : ''; ?>>Dry Storage</option>
                            <option value="Warm Storage" <?php echo ($storage_location === 'Warm Storage') ? 'selected' : ''; ?>>Warm Storage</option>
                        </select>
                        <?php if (isset($errors['storage_location'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['storage_location']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Purchase Unit -->
                        <label for="purchase_unit" class="block font-semibold text-gray-800 mt-2 mb-2">Purchase Unit</label>
                        <select id="purchase_unit" name="purchase_unit" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
                            <option value="kg" <?php echo ($purchase_unit === 'kg') ? 'selected' : ''; ?>>Kilogram (kg)</option>
                            <option value="g" <?php echo ($purchase_unit === 'g') ? 'selected' : ''; ?>>Gram (g)</option>
                            <option value="piece" <?php echo ($purchase_unit === 'piece') ? 'selected' : ''; ?>>Piece</option>
                            <option value="liter" <?php echo ($purchase_unit === 'liter') ? 'selected' : ''; ?>>Liter</option>
                            <option value="pack" <?php echo ($purchase_unit === 'pack') ? 'selected' : ''; ?>>Pack</option>
                        </select>
                        <?php if (isset($errors['purchase_unit'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['purchase_unit']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-green-500 hover:bg-green-600 mt-4 text-white font-bold py-2 px-4 rounded">
                            Update Ingredient
                        </button>
                    </form>
                    <!-- End Ingredient Update Form -->
                </div>
                <!-- End Content -->
            </div>
        </main>
        <!-- End Main Content -->
    </div>
    <!-- Footer -->
    <?php include('../components/footer.php'); ?>
    <!-- End Footer -->
</div>
</body>

</html>