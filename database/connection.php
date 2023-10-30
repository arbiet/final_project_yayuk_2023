<?php
$host = 'localhost'; // Ganti dengan host MySQL Anda
$username = 'root'; // Ganti dengan username MySQL Anda
$password = ''; // Ganti dengan password MySQL Anda
$database = 'final_project_yayuk_2023'; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Base URL Configuration
$baseUrl = "http://localhost/final_project_yayuk_2023/";

// base Title and description
$baseTitle = "O'Ayam Geprek";
$baseDescription = "O'Ayam Geprek - Mantul banget";

// Base Logo
$baseLogoUrl = "http://localhost/final_project_yayuk_2023/static/logo.png";

function insertLogActivity($conn, $userID, $activityDescription)
{
    $query = "INSERT INTO LogActivity (UserID, ActivityDescription, ActivityTimestamp) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $userID, $activityDescription);
    $stmt->execute();
    $stmt->close();
}

function generateRandomUserID()
{
    $characters = '0123456789';
    $randomUserID = '';
    $length = 10;

    for (
        $i = 0;
        $i < $length;
        $i++
    ) {
        $randomUserID .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomUserID;
}
// $hostname = "localhost";
// $db_username = "ikiz5613_admin_yayuk";
// $db_password = "yongalah";
// $db_name = "ikiz5613_final_project_yayuk_2023";

// // Membuat koneksi
// $conn = new mysqli($hostname, $db_username, $db_password, $db_name);

// // Memeriksa koneksi
// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

// // Base URL Configuration
// $baseUrl = "https://yayukyuningsih.arbiet.my.id/";

// // base Title and description
// $baseTitle = "O'Ayam Geprek";
// $baseDescription = "O'Ayam Geprek - Mantul banget";

// // Base Logo
// $baseLogoUrl = "https://yayukyuningsih.arbiet.my.id/static/logo.png";
