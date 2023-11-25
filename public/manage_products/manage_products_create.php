<?php
session_start();

// Include the database connection
require_once('../../database/connection.php');
include_once('../components/header.php');

// Initialize variables
$product_name = $photo_url = $selling_price = $manufacturer = $weight = '';
$errors = array();

// Fetch ingredient names from the Ingredients table
$ingredientNamesQuery = "SELECT id, ingredient_name FROM Ingredients";
$ingredientNamesResult = mysqli_query($conn, $ingredientNamesQuery);

$ingredientNames = array();
while ($row = mysqli_fetch_assoc($ingredientNamesResult)) {
    $ingredientNames[] = $row;
}

// Form submission process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $manufacturer = mysqli_real_escape_string($conn, $_POST['manufacturer']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);

    // Handle file upload (photo_url)
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

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        // Insert product data
        $query = "INSERT INTO Products (product_name, photo_url, selling_price, manufacturer, weight) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdss", $product_name, $photo_url, $selling_price, $manufacturer, $weight);

        if ($stmt->execute()) {
            $productID = $stmt->insert_id; // Get the ID of the newly inserted product

            // Insert ingredients data
            $ingredients = $_POST['ingredients'];

            foreach ($ingredients as $ingredient) {
                $ingredientID = mysqli_real_escape_string($conn, $ingredient['ingredient_id']);
                $quantity = mysqli_real_escape_string($conn, $ingredient['quantity']);

                $query = "INSERT INTO ProductIngredients (product_id, ingredient_id, quantity) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iis", $productID, $ingredientID, $quantity);
                $stmt->execute();
            }

            // Product creation successful
            $activityDescription = "Product with Name: $product_name has been created with the following details - Selling Price: $selling_price, Manufacturer: $manufacturer, Weight: $weight.";
            $currentUserID = $_SESSION['UserID'];
            insertLogActivity($conn, $currentUserID, $activityDescription);

            // Redirect to the product list page
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Product created successfully.",
                }).then(function() {
                    window.location.href = "manage_products_list.php";
                });
            </script>';
            exit();
        } else {
            // Product creation failed
            $errors['db_error'] = "Product creation failed.";

            // Display error notification
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Product creation failed.",
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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Create Product</h1>
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
                            <p class="text-gray-600 text-sm">Product creation form.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Product Creation Form -->
                    <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col w-full space-x-2">
                        <!-- Product Name -->
                        <label for="product_name" class="block font-semibold text-gray-800 mt-2 mb-2">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" id="product_name" name="product_name" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Product Name" value="<?php echo $product_name; ?>">
                        <?php if (isset($errors['product_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['product_name']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Photo -->
                        <label for="photo_url" class="block font-semibold text-gray-800 mt-2 mb-2">Photo <span class="text-red-500">*</span></label>
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
                                <!-- Dynamic Ingredients Fields Will be Added Here -->
                            </div>
                            <button type="button" onclick="addIngredientField()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-plus-circle mr-2 mt-2"></i>
                                <span>Add Ingredient</span>
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-4 text-center">
                            <i class="fas fa-check mr-2"></i>
                            <span>Create Product</span>
                        </button>
                    </form>
                    <!-- End Product Creation Form -->
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
            <label for="ingredients[${ingredientCount}][ingredient_id]" class="block font-semibold text-gray-800 mt-2 mb-2">Ingredient Name <span class="text-red-500">*</span></label>
            <select name="ingredients[${ingredientCount}][ingredient_id]" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
                <?php
                foreach ($ingredientNames as $ingredient) {
                    echo "<option value='{$ingredient['id']}'>{$ingredient['ingredient_name']}</option>";
                }
                ?>
            </select>

            <label for="ingredients[${ingredientCount}][quantity]" class="block font-semibold text-gray-800 mt-2 mb-2">Quantity <span class="text-red-500">*</span></label>
            <input type="number" name="ingredients[${ingredientCount}][quantity]" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Quantity" step="any">

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


</body>

</html>