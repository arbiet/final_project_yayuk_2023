<?php
// get file connection.php
require_once('../database/connection.php');
// Initialize the session
session_start();

if (isset($_SESSION['UserID'])) {
    // Redirect to dashboard
    header('Location: systems/dashboard.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $baseTitle; ?></title>
    <!-- Tailwind CSS -->
    <link rel="icon" href="<?php echo $baseUrl; ?>/static/logo.ico" type="image/png">
    <link rel="shortcut icon" href="<?php echo $baseUrl; ?>/static/logo.ico" type="image/png">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>dist/output.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
    <!-- SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

</head>

<body class="overflow-hidden">

    <div class="h-screen flex flex-col">
        <!-- Top Navbar -->
        <!-- End Top Navbar -->
        <!-- Main Content -->
        <main class="flex-grow bg-gray-50">
            <div class=" flex justify-center items-center h-full">
                <div class="text-center px-40">
                    <div class="flex items-center flex-shrink-0  text-gray-700 m-6 justify-center">
                        <a href="<?php echo $baseUrl; ?>public/index.php" class="flex items-center space-x-2">
                            <img src="<?php echo $baseLogoUrl; ?>" alt="Logo" class="w-20" /> <!-- Tambahkan kelas w-40 di sini -->
                        </a>
                    </div>
                    <h1 class="text-6xl font-bold text-gray-700 mb-10"><?php echo $baseTitle; ?></h1>
                    <p class="text-gray-500 mb-10 text-xl"><?php echo $baseDescription; ?></p>
                    <a href="<?php echo $baseUrl; ?>public/systems/login.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                        Login
                    </a>
                </div>
            </div>
        </main>
        <!-- Footer -->
        <!-- End Footer -->
    </div>
    <!-- End Main Content -->
</body>

</html>