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
                <?php
                // Fetch ingredient stock data from the database
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $query = "SELECT IngStk.StockID, IngStk.IngredientID, IngStk.Quantity AS Stock, IngStk.LastUpdateStock, I.*
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

                while ($row = $result->fetch_assoc()) {
                    // EOQ calculation
                    $demand = $row['UsagePerMonth'];
                    $orderCost = $row['OrderCost'];
                    $purchasePrice = $row['PurchasePrice'];
                    $holdingCostPercentage = $row['HoldingCostPercentage'] ;
                    $stock = $row['Stock'] ;

                    $eoq = sqrt((2 * $demand * $orderCost) / ((($purchasePrice / 100) * $holdingCostPercentage)));

                    // Calculate historical demand from IngredientTransactions table
                    $ingredientID = $row['IngredientID'];
                    $historicalDemandQuery = "SELECT Quantity FROM IngredientTransactions WHERE IngredientID = $ingredientID AND TransactionType = 'Out'";
                    $historicalDemandResult = $conn->query($historicalDemandQuery);

                    $historicalDemand = array();
                    while ($demandRow = $historicalDemandResult->fetch_assoc()) {
                        $historicalDemand[] = $demandRow['Quantity'];
                    }

                    // Calculate mean demand
                    $demandMean = ($historicalDemand) ? array_sum($historicalDemand) / count($historicalDemand) : 0;

                    // Calculate standard deviation of demand
                    $standardDeviation = ($historicalDemand) ? sqrt(array_sum(array_map(function ($demand) use ($demandMean) {
                        return pow($demand - $demandMean, 2);
                    }, $historicalDemand)) / count($historicalDemand)) : 0;

                    // Safety Stock calculation
                    $safetyFactor = 1.645; // You can adjust this based on your desired confidence level
                    $safetyStock = $safetyFactor * $standardDeviation;

                    // Calculate restock information
                    $restockQuantity = $eoq + $safetyStock; // You can modify this based on your specific logic

                    // Calculate restocksPerMonth based on demand and EOQ
                    $demand = $row['UsagePerMonth']; // You might want to move this line inside the while loop
                    $restocksPerMonth = ($demand > 0) ? ceil($demand / $restockQuantity) : 0;

                    // Calculate the days in the current month
                    $currentMonth = date('n'); // Get the current month (1-12)
                    $currentYear = date('Y'); // Get the current year
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

                    $daysBetweenRestocks = ($restocksPerMonth > 0) ? round($daysInMonth / $restocksPerMonth) : 0;

                    // Check if today requires restocking
                    $currentDay = date('j'); // Get the current day of the month (1-31)

                    

                    // Check if today requires restocking considering Safety Stock
                    if ($stock < ($eoq + $safetyStock)) {
                        $restockStatus = 'Restock Required';
                        $restockColor = 'text-red-500';
                    } else {
                        $restockStatus = 'No Restock Needed';
                        $restockColor = 'text-green-500';
                    }
                    ?>
                        <!-- Displaying each ingredient information -->
                        <div class="flex items-start flex-col justify-between border-b border-gray-300 py-2">
                            <!-- Ingredient Name -->
                            <div class="text-3xl font-semibold">
                                <?php echo $row['IngredientName']; ?>
                            </div>
                            <div class="flex flex-row flex-wrap space-x-2">
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-id-card-alt"></i><?php echo $row['IngredientID']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-dollar-sign"></i><?php echo $row['PurchasePrice']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-box"></i><?php echo $row['QuantityPerPurchase']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-utensils"></i><?php echo $row['ServingsPerIngredient']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-file-invoice-dollar"></i><?php echo $row['HoldingCost']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-coins"></i><?php echo $row['HoldingCostPrice']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-clock"></i><?php echo $row['ShelfLife']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-industry"></i><?php echo $row['SupplierName']; ?>
                                </div>
                                
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-sort-numeric-up"></i><?php echo $row['MinimumStock']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-map-marker-alt"></i><?php echo $row['StorageLocation']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-cube"></i><?php echo $row['PurchaseUnit']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-chart-line"></i><?php echo $row['UsagePerDay']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-chart-bar"></i><?php echo $row['UsagePerMonth']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-file-invoice-dollar"></i><?php echo $row['OrderCost']; ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-percent"></i><?php echo $row['HoldingCostPercentage']; ?>
                                </div>
                            </div>
                            <div class="text-gray-600">
                                <i class="mr-2 fas fa-info-circle"></i><?php echo $row['Description']; ?>
                            </div>
                            <div class="text-gray-600">
                                <div class="text-xl font-semibold">EOQ - Economy Order Quantity</div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-sort-numeric-up"></i>EOQ: <?php echo number_format($eoq, 2); ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-sort-numeric-down"></i>Safety Stock: <?php echo number_format($safetyStock, 2); ?>
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-sort-numeric-down"></i>Reorder Point: <?php echo number_format($restockQuantity, 2), " " ,  $row['PurchaseUnit']; ?> 
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-calendar-day"></i>Restocks Per Month: <?php echo $restocksPerMonth; ?> Times
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-clock"></i>Days Between Restocks: <?php echo $daysBetweenRestocks; ?> days
                                </div>
                                <div class="text-gray-600">
                                    <i class="mr-2 fas fa-info-circle"></i>Components:
                                    <ul>
                                        <li>Demand: <?php echo number_format($demand, 2), " " ,$row['PurchaseUnit'] , " / month"; ?></li>
                                        <li>Order Cost: Rp <?php echo number_format($orderCost, 2); ?></li>
                                        <li>Holding Cost Percentage: <?php echo $holdingCostPercentage; ?>%</li>
                                        <li>Purchase Price: Rp <?php echo number_format($purchasePrice, 2); ?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-gray-600 <?php echo $restockColor; ?>">
                                <i class="mr-2 fas fa-info-circle"></i>Restock Status: <?php echo $restockStatus; ?>
                            </div>
                            <!-- Action: View Transactions -->
                            <div class="flex-shrink-0 mt-2">
                                <a href="<?php echo $baseUrl; ?>public/view_transactions.php?stock_id=<?php echo $row['StockID']; ?>" class="text-xs bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    <span>Transactions</span>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    
                    // Check if no data found
                    if ($result->num_rows === 0) {
                    ?>
                        <!-- Display a message if no data is found -->
                        <div class="py-2 text-center">No data found.</div>
                    <?php
                    }
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




</body>

</html>