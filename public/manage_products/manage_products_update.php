<?php
session_start();

// Include the database connection
require_once('../../database/connection.php');
include_once('../components/header.php');

// Initialize variables
$product_name = $photo_url = $selling_price = $manufacturer = $weight = '';
$errors = array();

// Fetch ingredient names from the Ingredients table
$ingredientNamesQuery = "SELECT IngredientID, IngredientName FROM Ingredients";
$ingredientNamesResult = mysqli_query($conn, $ingredientNamesQuery);

$ingredientNames = array();
while ($row = mysqli_fetch_assoc($ingredientNamesResult)) {
    $ingredientNames[] = $row;
}

// Fetch existing product details
if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    $productQuery = "SELECT * FROM Products WHERE ProductID = ?";
    $stmt = $conn->prepare($productQuery);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['ProductName'];
        $photo_url = $row['PhotoURL'];
        $selling_price = $row['SellingPrice'];
        $manufacturer = $row['Manufacturer'];
        $weight = $row['Weight'];
    } else {
        // Handle product not found error
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Product not found.",
            }).then(function() {
                window.location.href = "manage_products_list.php";
            });
        </script>';
        exit();
    }
}

// Form submission process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $manufacturer = mysqli_real_escape_string($conn, $_POST['manufacturer']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);

    // Handle file upload (photo_url)
    if ($_FILES['photo_url']['size'] > 0) {
        $uploadDir = '../static/image/product/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        $uploadFile = $uploadDir . basename($_FILES['photo_url']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES['photo_url']['tmp_name'], $uploadFile)) {
            $photo_url = basename($_FILES['photo_url']['name']);
        } else {
            $errors['photo_url'] = "Failed to upload image.";
        }
    }

    // If there are no errors, update data in the database
    if (empty($errors)) {
        // Begin transaction for atomic operations
        $conn->begin_transaction();

        try {
            // Step 1: Delete existing ingredients for the product
            $deleteIngredientsQuery = "DELETE FROM ProductIngredients WHERE ProductID = ?";
            $deleteStmt = $conn->prepare($deleteIngredientsQuery);
            $deleteStmt->bind_param("i", $productID);
            $deleteStmt->execute();

            // Step 2: Update product data
            $updateQuery = "UPDATE Products SET ProductName = ?, PhotoURL = ?, SellingPrice = ?, Manufacturer = ?, Weight = ? WHERE ProductID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssdssi", $product_name, $photo_url, $selling_price, $manufacturer, $weight, $productID);

            if ($stmt->execute()) {
                // Step 3: Insert updated ingredients
                $ingredients = $_POST['Ingredients'];

                foreach ($ingredients as $ingredient) {
                    $ingredientID = mysqli_real_escape_string($conn, $ingredient['IngredientID']);
                    $quantity = mysqli_real_escape_string($conn, $ingredient['Quantity']);

                    $insertIngredientQuery = "INSERT INTO ProductIngredients (ProductID, IngredientID, Quantity) VALUES (?, ?, ?)";
                    $insertStmt = $conn->prepare($insertIngredientQuery);
                    $insertStmt->bind_param("iid", $productID, $ingredientID, $quantity);
                    $insertStmt->execute();
                }

                // Commit the transaction
                $conn->commit();

                // Product update successful
                $activityDescription = "Product with ID: $productID has been updated with the following details - Product Name: $product_name, Selling Price: $selling_price, Manufacturer: $manufacturer, Weight: $weight.";
                $currentUserID = $_SESSION['UserID'];
                insertLogActivity($conn, $currentUserID, $activityDescription);

                // Redirect to the product list page
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Product updated successfully.",
                    }).then(function() {
                        window.location.href = "manage_products_list.php";
                    });
                </script>';
                exit();
            } else {
                // Product update failed
                $errors['db_error'] = "Product update failed.";

                // Display error notification
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Product update failed.",
                    });
                </script>';
            }
        } catch (Exception $e) {
            // Rollback the transaction on exception
            $conn->rollback();

            // Display error notification
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again.",
                });
            </script>';
        }
    }
}

// Close the database connection
?>

<!-- HTML content -->
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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Update Product</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="manage_products_list.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
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
                            <p class="text-gray-600 text-sm">Product update form.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Product Update Form -->
                    <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col w-full space-x-2">
                        <!-- Product Name -->
                        <label for="product_name" class="block font-semibold text-gray-800 mt-2 mb-2">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" id="product_name" name="product_name" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Product Name" value="<?php echo $product_name; ?>">
                        <?php if (isset($errors['product_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['product_name']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Existing Photo -->
                        <label class="block font-semibold text-gray-800 mt-2 mb-2">Existing Photo</label>
                        <img src="../static/image/product/<?php echo $photo_url; ?>" alt="Existing Photo" class="mb-2" style="max-width: 200px;">

                        <!-- New Photo -->
                        <label for="photo_url" class="block font-semibold text-gray-800 mt-2 mb-2">New Photo</label>
                        <input type="file" id="photo_url" name="photo_url" accept="image/*">
                        <?php if (isset($errors['photo_url'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['photo_url']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Selling Price -->
                        <label for="selling_price" class="block font-semibold text-gray-800 mt-2 mb-2">Selling Price <span class="text-red-500">*</span></label>
                        <input type="number" id="selling_price" name="selling_price" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Selling Price" value="<?php echo $selling_price; ?>" step="any">
                        <?php if (isset($errors['selling_price'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['selling_price']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Manufacturer -->
                        <label for="manufacturer" class="block font-semibold text-gray-800 mt-2 mb-2">Manufacturer <span class="text-red-500">*</span></label>
                        <input type="text" id="manufacturer" name="manufacturer" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Manufacturer" value="<?php echo $manufacturer; ?>">
                        <?php if (isset($errors['manufacturer'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['manufacturer']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Weight -->
                        <label for="weight" class="block font-semibold text-gray-800 mt-2 mb-2">Weight <span class="text-red-500">*</span></label>
                        <input type="text" id="weight" name="weight" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Weight" value="<?php echo $weight; ?>">
                        <?php if (isset($errors['weight'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['weight']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Ingredients Section -->
                        <div class="mt-4">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Ingredients</h2>
                            <div id="ingredients-container">
                                <?php
                                // Populate existing ingredients
                                $existingIngredientsQuery = "SELECT Ingredients.IngredientID, Ingredients.IngredientName, ProductIngredients.quantity
                              FROM Ingredients
                              JOIN ProductIngredients ON Ingredients.IngredientID = ProductIngredients.IngredientID
                              WHERE ProductIngredients.ProductID = ?";
                                $existingStmt = $conn->prepare($existingIngredientsQuery);
                                $existingStmt->bind_param("i", $productID);
                                $existingStmt->execute();
                                $existingResult = $existingStmt->get_result();

                                $existingIngredients = array();
                                while ($existingRow = $existingResult->fetch_assoc()) {
                                    $existingIngredients[] = $existingRow;
                                }


                                foreach ($existingIngredients as $existingIngredient) {
                                    echo '<div class="mt-4">';
                                    echo '<h2 class="text-lg font-semibold text-gray-800 mb-2">Ingredient</h2>';
                                    echo '<label for="ingredients[' . $existingIngredient['IngredientID'] . '][ingredient_id]" class="block font-semibold text-gray-800 mt-2 mb-2">Ingredient Name <span class="text-red-500">*</span></label>';
                                    echo '<select name="ingredients[' . $existingIngredient['IngredientID'] . '][ingredient_id]" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">';
                                    foreach ($ingredientNames as $ingredient) {
                                        $selected = ($ingredient['IngredientID'] == $existingIngredient['IngredientID']) ? 'selected' : '';
                                        echo "<option value='{$ingredient['IngredientID']}' $selected>{$ingredient['IngredientName']}</option>";
                                    }
                                    echo '</select>';

                                    echo '<label for="ingredients[' . $existingIngredient['IngredientID'] . '][quantity]" class="block font-semibold text-gray-800 mt-2 mb-2">Quantity <span class="text-red-500">*</span></label>';
                                    echo '<input type="number" name="ingredients[' . $existingIngredient['IngredientID'] . '][quantity]" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Quantity" step="any" value="' . $existingIngredient['quantity'] . '">';
                                    echo '<button type="button" onclick="removeIngredientField(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-2 mb-2">';
                                    echo '<i class="fas fa-trash-alt mr-2"></i>';
                                    echo '<span>Remove Ingredient</span>';
                                    echo '</button>';
                                    echo '</div>';
                                }

                                ?>
                            </div>
                            <button type="button" onclick="addIngredientField()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-plus-circle mr-2 mt-2"></i>
                                <span>Add Ingredient</span>
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-4 text-center">
                            <i class="fas fa-check mr-2"></i>
                            <span>Update Product</span>
                        </button>
                    </form>
                    <!-- End Product Update Form -->
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

<!-- JavaScript to handle dynamic ingredient fields -->
<script>
    var ingredientNames = <?php echo json_encode($ingredientNames); ?>;

    function addIngredientField() {
        var container = document.getElementById('ingredients-container');
        var ingredientCount = container.getElementsByTagName('div').length;

        var newIngredientField = document.createElement('div');
        newIngredientField.className = 'mt-4';
        newIngredientField.innerHTML = `
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Ingredient ${ingredientCount + 1}</h2>
        <label for="ingredients[new_${ingredientCount}][ingredient_id]" class="block font-semibold text-gray-800 mt-2 mb-2">Ingredient Name <span class="text-red-500">*</span></label>
        <select name="ingredients[new_${ingredientCount}][ingredient_id]" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
            ${ingredientNames.map(ingredient => `<option value="${ingredient.id}">${ingredient.IngredientName}</option>`).join('')}
        </select>

        <label for="ingredients[new_${ingredientCount}][quantity]" class="block font-semibold text-gray-800 mt-2 mb-2">Quantity <span class="text-red-500">*</span></label>
        <input type="number" name="ingredients[new_${ingredientCount}][quantity]" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Quantity" step="any">

        <button type="button" onclick="removeIngredientField(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-2 mb-2">
            <i class="fas fa-trash-alt mr-2"></i>
            <span>Remove Ingredient</span>
        </button>
    `;

        container.appendChild(newIngredientField);
    }

    function removeIngredientField(button) {
        var container = document.getElementById('ingredients-container');
        container.removeChild(button.parentNode);
    }
</script>