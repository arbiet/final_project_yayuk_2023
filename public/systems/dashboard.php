<?php
// Initialize the session
session_start();
// Include the connection file
require_once('../../database/connection.php');

// Initialize variables
$username = $password = '';
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform basic validation
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    // If no errors, proceed with login
    if (empty($errors)) {
        // Hash the password for comparison
        $hashed_password = hash('sha256', $password);

        // Prepare and execute a query to check user credentials
        $query = "SELECT * FROM Users WHERE Username = ? AND Password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 1) {
            // Perform login actions (e.g., set sessions, redirect, etc.)
            $row = $result->fetch_assoc();
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['RoleID'] = $row['RoleID'];
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['FullName'] = $row['FullName'];

            // Redirect to a dashboard or homepage
            header('Location: systems/dashboard.php');
            exit();
        } else {
            $errors['login_failed'] = 'Invalid username or password.';
        }

        // Close the statement
        $stmt->close();
    }
}

// Fetch data for Ingredient Purchase Price Distribution
$query = "SELECT IngredientName, PurchasePrice FROM Ingredients";
$result = $conn->query($query);
$purchasePriceData = [];
while ($row = $result->fetch_assoc()) {
    $purchasePriceData[] = $row;
}

// Fetch data for Ingredient Stock Levels
$query = "SELECT i.IngredientName, s.Quantity FROM Ingredients i
          JOIN IngredientStocks s ON i.IngredientID = s.IngredientID";
$result = $conn->query($query);
$stockLevelsData = [];
while ($row = $result->fetch_assoc()) {
    $stockLevelsData[] = $row;
}


// Fetch data for Ingredient Transaction History
$query = "SELECT Timestamp, Quantity, TransactionType FROM IngredientTransactions";
$result = $conn->query($query);
$transactionHistoryData = [];
while ($row = $result->fetch_assoc()) {
    $transactionHistoryData[] = $row;
}


// Close the database connection
$conn->close();
?>

<?php include('../components/header.php'); ?>

<div class="h-screen flex flex-col">
    <!-- Top Navbar -->
    <?php include('../components/navbar.php'); ?>
    <!-- End Top Navbar -->
    <!-- Main Content -->
    <div class="bg-gray-50 flex flex-row shadow-md">
        <!-- Sidebar -->
        <?php include('../components/sidebar.php'); ?>
        <!-- End Sidebar -->
        <!-- Main Content -->
        <main class=" bg-gray-50 flex flex-col flex-1 overflow-y-scroll h-screen flex-shrink-0 sc-hide pb-40">
            <div class="flex items-start justify-start p-6 shadow-md m-4 flex-1 flex-col">
                <h1 class="text-3xl text-gray-800 font-semibold border-b border-gray-200 w-full">Dashboard</h1>
                <h2 class="text-xl text-gray-800 font-semibold">
                    Welcome back, <?php echo $_SESSION['FullName']; ?>!
                    <?php
                    if ($_SESSION['RoleID'] === 'admin') {
                        echo " (Admin)";
                    } elseif ($_SESSION['RoleID'] === 'manager') {
                        echo " (Manager)";
                    }
                    ?>
                </h2>
                <p class="text-gray-600">Here's what's happening with your projects today.</p>
                <!-- Grafik -->
                <div class="w-full overflow-x-auto mt-4 mb-4">
                    <div class="flex flex-row flex-wrap space-x-2">
                        <div class="flex-shrink-0">
                            <canvas id="purchasePriceChart" width="1000" height="400"></canvas>
                        </div>
                        <div class="flex-shrink-0">
                            <canvas id="stockLevelsChart" width="1000" height="400"></canvas>
                        </div>
                        <div class="flex-shrink-0">
                            <canvas id="transactionHistoryChart" width="1000" height="400"></canvas>
                        </div>
                    </div>
                </div>
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
<script>
// Chart for Ingredient Purchase Price Distribution
var ctx1 = document.getElementById('purchasePriceChart').getContext('2d');
var purchasePriceChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($purchasePriceData, 'IngredientName')); ?>,
        datasets: [{
            label: 'Purchase Price',
            data: <?php echo json_encode(array_column($purchasePriceData, 'PurchasePrice')); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Chart for Ingredient Stock Levels
var ctx2 = document.getElementById('stockLevelsChart').getContext('2d');
var stockLevelsChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($stockLevelsData, 'IngredientName')); ?>,
        datasets: [{
            label: 'Stock Levels',
            data: <?php echo json_encode(array_column($stockLevelsData, 'Quantity')); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Chart for Ingredient Transaction History
var ctx3 = document.getElementById('transactionHistoryChart').getContext('2d');
var transactionHistoryChart = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($transactionHistoryData, 'Timestamp')); ?>,
        datasets: [{
            label: 'Quantity',
            data: <?php echo json_encode(array_column($transactionHistoryData, 'Quantity')); ?>,
            fill: false,
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</html>