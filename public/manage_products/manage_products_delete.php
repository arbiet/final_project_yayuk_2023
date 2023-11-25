<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header('Location: login.php');
    exit();
}

// Check if the product ID is provided in the query parameters
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to the error page or an appropriate location
    header('Location: error.php');
    exit();
}

$id = $_GET['id'];

// Initialize success and error messages
$success_message = '';
$error_message = '';

// Fetch the product details before deletion for logging
$productQuery = "SELECT * FROM Products WHERE id = ?";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param('i', $id);
$stmt->execute();
$productResult = $stmt->get_result();

if ($productResult->num_rows > 0) {
    $productDetails = $productResult->fetch_assoc();

    // Delete related records from the "ProductIngredients" table
    $deleteProductIngredientsQuery = "DELETE FROM ProductIngredients WHERE product_id = ?";
    $stmt = $conn->prepare($deleteProductIngredientsQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Deletion of related records successful
        $stmt->close();

        // Now, proceed with deleting the product
        $deleteProductQuery = "DELETE FROM Products WHERE id = ?";
        $stmt = $conn->prepare($deleteProductQuery);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Activity description
            $activityDescription = "Product with ID: $id, Product Name: {$productDetails['product_name']} has been deleted.";

            $currentUserID = $_SESSION['UserID'];
            insertLogActivity($conn, $currentUserID, $activityDescription);

            // Delete product photo
            $photoPath = '../static/image/product/' . $productDetails['photo_url'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            // Product deletion successful
            $stmt->close();
            $success_message = "Produk berhasil dihapus!";
        } else {
            // Product deletion failed
            $stmt->close();
            $error_message = "Gagal menghapus produk.";
        }
    } else {
        // Deletion of related records failed
        $stmt->close();
        $error_message = "Gagal menghapus catatan terkait dari ProductIngredients.";
    }
} else {
    // Product not found
    $error_message = "Produk tidak ditemukan.";
}

// Display success or error message using SweetAlert2
if (!empty($success_message)) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '$success_message',
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
        window.location.href = 'manage_products_list.php'; // Redirect to the product list page
    });
    </script>";
} elseif (!empty($error_message)) {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '$error_message',
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
        window.location.href = 'manage_products_list.php'; // Redirect to the product list page
    });
    </script>";
}
?>

<div class="h-screen flex flex-col">
</div>