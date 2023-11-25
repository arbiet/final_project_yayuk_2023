<?php
// Initialize the session
session_start();
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$ingredientID = ''; // Initialize with the specific ingredient's ID you want to display
$errors = array();
$ingredientData = array();

// Retrieve ingredient data
if (isset($_GET['id'])) {
    $ingredientID = $_GET['id'];
    $query = "SELECT * FROM Ingredients WHERE id = $ingredientID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $ingredientData = $result->fetch_assoc();
    } else {
        $errors[] = "Ingredient not found.";
    }
}

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
        <main class="bg-gray-50 flex flex-col flex-1 overflow-y-scroll h-screen flex-shrink-0 sc-hide pb-40">
            <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                <!-- Header Content -->
                <div class="flex flex-row justify-between items-center w-full border-b-2 border-gray-600 mb-2 pb-2">
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Ingredient Details</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="../manage_ingredients/manage_ingredients_list.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
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
                            <p class="text-gray-600 text-sm">Ingredient information.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Ingredient Details -->
                    <?php if (!empty($ingredientData)) : ?>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white shadow-md p-4 rounded-md">
                                <h3 class="text-lg font-semibold text-gray-800">Ingredient Information</h3>
                                <p><strong>Ingredient Name:</strong> <?php echo $ingredientData['ingredient_name']; ?></p>
                                <p><strong>Purchase Price:</strong> <?php echo $ingredientData['purchase_price']; ?></p>
                                <p><strong>Quantity per Purchase:</strong> <?php echo $ingredientData['quantity_per_purchase']; ?></p>
                                <p><strong>Servings per Ingredient:</strong> <?php echo $ingredientData['servings_per_ingredient']; ?></p>
                                <p><strong>Holding Cost:</strong> <?php echo $ingredientData['holding_cost'] ? 'Yes' : 'No'; ?></p>
                                <p><strong>Holding Cost Price:</strong> <?php echo $ingredientData['holding_cost_price']; ?></p>
                            </div>
                            <div class="bg-white shadow-md p-4 rounded-md">
                                <h3 class="text-lg font-semibold text-gray-800">Additional Information</h3>
                                <p><strong>Shelf Life:</strong> <?php echo $ingredientData['shelf_life']; ?></p>
                                <p><strong>Supplier Name:</strong> <?php echo $ingredientData['supplier_name']; ?></p>
                                <p><strong>Description:</strong> <?php echo $ingredientData['description']; ?></p>
                                <p><strong>Minimum Stock:</strong> <?php echo $ingredientData['minimum_stock']; ?></p>
                                <p><strong>Storage Location:</strong> <?php echo $ingredientData['storage_location']; ?></p>
                                <p><strong>Purchase Unit:</strong> <?php echo $ingredientData['purchase_unit']; ?></p>
                            </div>
                        </div>
                        <!-- Add Edit and Delete Buttons -->
                        <div class="mt-4">
                            <a href="manage_ingredients_update.php?id=<?php echo $ingredientID; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mr-2">
                                <i class="fas fa-edit mr-2"></i>
                                <span>Edit</span>
                            </a>
                            <a href="#" onclick="confirmDelete(<?php echo $ingredientID; ?>)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-trash mr-2"></i>
                                <span>Delete</span>
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="bg-white shadow-md p-4 rounded-md">
                            <p>No ingredient data available.</p>
                        </div>
                    <?php endif; ?>
                    <!-- End Ingredient Details -->
                </div>
                <!-- End Content -->
            </div>
        </main>
    </div>

    <!-- End Main Content -->
    <!-- Footer -->
    <?php include('../components/footer.php'); ?>
    <!-- End Footer -->
</div>

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
</body>

</html>