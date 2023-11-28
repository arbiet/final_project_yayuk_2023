<?php
session_start();
require_once('../../database/connection.php');
include_once('../components/header.php');

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header('Location: login.php');
    exit();
}

// Check if the ingredient ID is provided in the query parameters
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to the error page or an appropriate location
    header('Location: error.php');
    exit();
}

$id = $_GET['id'];

// Initialize success and error messages
$success_message = '';
$error_message = '';

// Delete related records from the "logactivity" table
$query = "DELETE FROM LogActivities WHERE UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Deletion of related records successful
    $stmt->close();

    // Now, proceed with deleting the ingredient
    $query = "DELETE FROM Ingredients WHERE IngredientID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Activity description
        $activityDescription = "Ingredient with ID: $id has been deleted.";

        $currentUserID = $_SESSION['UserID'];
        insertLogActivity($conn, $currentUserID, $activityDescription);

        // Ingredient deletion successful
        $stmt->close();
        $success_message = "Bahan berhasil dihapus!";
    } else {
        // Ingredient deletion failed
        $stmt->close();
        $error_message = "Gagal menghapus bahan.";
    }
} else {
    // Deletion of related records failed
    $stmt->close();
    $error_message = "Gagal menghapus catatan terkait dari logactivity.";
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
        window.location.href = 'manage_ingredients_list.php'; // Redirect to the ingredient list page
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
        window.location.href = 'manage_ingredients_list.php'; // Redirect to the ingredient list page
    });
    </script>";
}
?>

<div class="h-screen flex flex-col">
</div>