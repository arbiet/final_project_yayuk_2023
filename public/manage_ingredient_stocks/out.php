<?php
// Include the connection file
require_once('../../database/connection.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ingredient ID, quantity, and date from the POST data
    $ingredientID = $_POST['id'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    // Perform the stock out transaction
    try {
        // Start a transaction
        $conn->begin_transaction();

        // Fetch QuantityPerPurchase and ServingsPerIngredient from the Ingredients table
        $ingredientInfoQuery = "SELECT QuantityPerPurchase, ServingsPerIngredient FROM Ingredients WHERE IngredientID = $ingredientID";
        $ingredientInfoResult = $conn->query($ingredientInfoQuery);

        if ($ingredientInfoResult->num_rows > 0) {
            $ingredientInfo = $ingredientInfoResult->fetch_assoc();
            $quantityPerPurchase = $ingredientInfo['QuantityPerPurchase'];
            $servingsPerIngredient = $ingredientInfo['ServingsPerIngredient'];

            // Check if the ingredient stock exists
            $checkQuery = "SELECT * FROM IngredientStocks WHERE IngredientID = $ingredientID";
            $checkResult = $conn->query($checkQuery);

            if ($checkResult->num_rows > 0) {
                // If the ingredient stock exists, update the quantity and calculate QuantityPerServings
                $updateQuery = "UPDATE IngredientStocks SET Quantity = Quantity - $quantity, QuantityPerServings = QuantityPerServings - ($quantity * $quantityPerPurchase * $servingsPerIngredient), LastUpdateStock = '$date' WHERE IngredientID = $ingredientID";
                $conn->query($updateQuery);
            } else {
                // If the ingredient stock doesn't exist, throw an error
                throw new Exception('Ingredient stock not found for the specified ingredient.');
            }

            // Insert a record in the IngredientTransactions table
            $transactionQuery = "INSERT INTO IngredientTransactions (IngredientID, TransactionType, Quantity, QuantityPerServings, Timestamp)
                                VALUES ($ingredientID, 'OUT', $quantity, $quantity * $quantityPerPurchase * $servingsPerIngredient, '$date')";
            $conn->query($transactionQuery);

            // Commit the transaction
            $conn->commit();

            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Stock out transaction successful']);
        } else {
            // If QuantityPerPurchase or ServingsPerIngredient is not found, throw an error
            throw new Exception('QuantityPerPurchase or ServingsPerIngredient not found for the specified ingredient.');
        }
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();

        // Return error response
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // Return an error if the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
