<?php
session_start();

// Include the database connection
require_once('../../database/connection.php');
include_once('../components/header.php');

// Inisialisasi variabel
$ingredient_name = $purchase_price = $quantity_per_purchase = $servings_per_ingredient = $holding_cost = '';
$holding_cost_price = $shelf_life = $supplier_name = $description = $minimum_stock = $storage_location = $purchase_unit = '';

$errors = array();

// Proses pengiriman formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi dan validasi data input
    $ingredient_name = mysqli_real_escape_string($conn, $_POST['ingredient_name']);
    $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
    $quantity_per_purchase = mysqli_real_escape_string($conn, $_POST['quantity_per_purchase']);
    $servings_per_ingredient = mysqli_real_escape_string($conn, $_POST['servings_per_ingredient']);
    $holding_cost = mysqli_real_escape_string($conn, isset($_POST['holding_cost']) ? 1 : 0);
    $holding_cost_price = mysqli_real_escape_string($conn, $_POST['holding_cost_price']);
    $shelf_life = mysqli_real_escape_string($conn, $_POST['shelf_life']);
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $minimum_stock = mysqli_real_escape_string($conn, $_POST['minimum_stock']);
    $storage_location = mysqli_real_escape_string($conn, $_POST['storage_location']);
    $purchase_unit = mysqli_real_escape_string($conn, $_POST['purchase_unit']);

    // Periksa kesalahan
    if (empty($ingredient_name)) {
        $errors['ingredient_name'] = "Nama Bahan isian wajib diisi.";
    }
    if (empty($purchase_price)) {
        $errors['purchase_price'] = "Harga Beli isian wajib diisi.";
    }
    if (empty($quantity_per_purchase)) {
        $errors['quantity_per_purchase'] = "Jumlah per Beli isian wajib diisi.";
    }
    if (empty($servings_per_ingredient)) {
        $errors['servings_per_ingredient'] = "Porsi per Bahan isian wajib diisi.";
    }

    // Jika tidak ada kesalahan, masukkan data ke database
    if (empty($errors)) {
        $query = "INSERT INTO Ingredients (
            ingredient_name, 
            purchase_price, 
            quantity_per_purchase, 
            servings_per_ingredient, 
            holding_cost, 
            holding_cost_price, 
            shelf_life, 
            supplier_name, 
            description, 
            minimum_stock, 
            storage_location, 
            purchase_unit
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sdddiidssdss",
            $ingredient_name,
            $purchase_price,
            $quantity_per_purchase,
            $servings_per_ingredient,
            $holding_cost,
            $holding_cost_price,
            $shelf_life,
            $supplier_name,
            $description,
            $minimum_stock,
            $storage_location,
            $purchase_unit
        );

        if ($stmt->execute()) {
            // Penciptaan bahan berhasil
            $activityDescription = "Bahan dengan Nama: $ingredient_name telah dibuat dengan detail berikut - Harga Beli: $purchase_price, Jumlah per Beli: $quantity_per_purchase, Porsi per Bahan: $servings_per_ingredient.";

            $currentUserID = $_SESSION['UserID'];
            insertLogActivity($conn, $currentUserID, $activityDescription);

            // Tampilkan pemberitahuan keberhasilan dan redirect ke halaman daftar bahan
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Bahan berhasil dibuat.",
                }).then(function() {
                    window.location.href = "manage_ingredients_list.php";
                });
            </script>';
            exit();
        } else {
            // Penciptaan bahan gagal
            $errors['db_error'] = "Penciptaan bahan gagal.";

            // Tampilkan pemberitahuan kesalahan
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Kesalahan",
                    text: "Penciptaan bahan gagal.",
                });
            </script>';
        }
    }
}

// Tutup koneksi database
?>


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
                    <h1 class="text-3xl text-gray-800 font-semibold w-full">Buat Bahan</h1>
                    <div class="flex flex-row justify-end items-center">
                        <a href="manage_ingredients_list.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
                <!-- End Header Content -->
                <!-- Content -->
                <div class="flex flex-col w-full">
                    <!-- Navigation -->
                    <div class="flex flex-row justify-between items-center w-full pb-2">
                        <div>
                            <h2 class="text-lg text-gray-800 font-semibold">Selamat datang kembali, <?php echo $_SESSION['FullName']; ?>!</h2>
                            <p class="text-gray-600 text-sm">Formulir pembuatan bahan.</p>
                        </div>
                    </div>
                    <!-- End Navigation -->
                    <!-- Ingredient Creation Form -->
                    <form action="" method="POST" class="flex flex-col w-full space-x-2">
                        <!-- Nama Bahan -->
                        <label for="ingredient_name" class="block font-semibold text-gray-800 mt-2 mb-2">Nama Bahan <span class="text-red-500">*</span></label>
                        <input type="text" id="ingredient_name" name="ingredient_name" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Nama Bahan" value="<?php echo $ingredient_name; ?>">
                        <?php if (isset($errors['ingredient_name'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['ingredient_name']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Harga Beli -->
                        <label for="purchase_price" class="block font-semibold text-gray-800 mt-2 mb-2">Harga Beli <span class="text-red-500">*</span></label>
                        <input type="number" id="purchase_price" name="purchase_price" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Harga Beli" value="<?php echo $purchase_price; ?>" step="any">
                        <?php if (isset($errors['purchase_price'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['purchase_price']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Jumlah per Beli -->
                        <label for="quantity_per_purchase" class="block font-semibold text-gray-800 mt-2 mb-2">Jumlah per Beli <span class="text-red-500">*</span></label>
                        <input type="number" id="quantity_per_purchase" name="quantity_per_purchase" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Jumlah per Beli" value="<?php echo $quantity_per_purchase; ?>" step="any">
                        <?php if (isset($errors['quantity_per_purchase'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['quantity_per_purchase']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Porsi per Bahan -->
                        <label for="servings_per_ingredient" class="block font-semibold text-gray-800 mt-2 mb-2">Porsi per Bahan <span class="text-red-500">*</span></label>
                        <input type="number" id="servings_per_ingredient" name="servings_per_ingredient" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Porsi per Bahan" value="<?php echo $servings_per_ingredient; ?>">
                        <?php if (isset($errors['servings_per_ingredient'])) : ?>
                            <p class="text-red-500 text-sm">
                                <?php echo $errors['servings_per_ingredient']; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Holding Cost -->
                        <label for="holding_cost" class="block font-semibold text-gray-800 mt-2 mb-2">Holding Cost</label>
                        <input type="checkbox" id="holding_cost" name="holding_cost" class="border-gray-300 text-gray-600" <?php echo $holding_cost ? 'checked' : ''; ?>>

                        <!-- Harga Holding Cost -->
                        <label for="holding_cost_price" class="block font-semibold text-gray-800 mt-2 mb-2">Harga Holding Cost</label>
                        <input type="number" id="holding_cost_price" name="holding_cost_price" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Harga Holding Cost" value="<?php echo $holding_cost_price; ?>" step="any">

                        <!-- Masa Simpan -->
                        <label for="shelf_life" class="block font-semibold text-gray-800 mt-2 mb-2">Masa Simpan</label>
                        <input type="text" id="shelf_life" name="shelf_life" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Masa Simpan" value="<?php echo $shelf_life; ?>">

                        <!-- Nama Pemasok -->
                        <label for="supplier_name" class="block font-semibold text-gray-800 mt-2 mb-2">Nama Pemasok</label>
                        <input type="text" id="supplier_name" name="supplier_name" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Nama Pemasok" value="<?php echo $supplier_name; ?>">

                        <!-- Deskripsi -->
                        <label for="description" class="block font-semibold text-gray-800 mt-2 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Deskripsi"><?php echo $description; ?></textarea>

                        <!-- Persediaan Minimum -->
                        <label for="minimum_stock" class="block font-semibold text-gray-800 mt-2 mb-2">Persediaan Minimum</label>
                        <input type="number" id="minimum_stock" name="minimum_stock" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600" placeholder="Persediaan Minimum" value="<?php echo $minimum_stock; ?>">

                        <!-- Storage Location -->
                        <label for="storage_location" class="block font-semibold text-gray-800 mt-2 mb-2">Lokasi Penyimpanan</label>
                        <select id="storage_location" name="storage_location" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
                            <option value="Cool Storage" <?php echo ($storage_location === 'Cool Storage') ? 'selected' : ''; ?>>Cool Storage</option>
                            <option value="Dry Storage" <?php echo ($storage_location === 'Dry Storage') ? 'selected' : ''; ?>>Dry Storage</option>
                            <option value="Warm Storage" <?php echo ($storage_location === 'Warm Storage') ? 'selected' : ''; ?>>Warm Storage</option>
                        </select>

                        <!-- Purchase Unit -->
                        <label for="purchase_unit" class="block font-semibold text-gray-800 mt-2 mb-2">Satuan Beli</label>
                        <select id="purchase_unit" name="purchase_unit" class="w-full rounded-md border-gray-300 px-2 py-2 border text-gray-600">
                            <option value="kg" <?php echo ($purchase_unit === 'kg') ? 'selected' : ''; ?>>Kilogram (kg)</option>
                            <option value="g" <?php echo ($purchase_unit === 'g') ? 'selected' : ''; ?>>Gram (g)</option>
                            <option value="piece" <?php echo ($purchase_unit === 'piece') ? 'selected' : ''; ?>>Piece</option>
                            <option value="liter" <?php echo ($purchase_unit === 'liter') ? 'selected' : ''; ?>>Liter</option>
                            <option value="pack" <?php echo ($purchase_unit === 'pack') ? 'selected' : ''; ?>>Pack</option>
                        </select>

                        <!-- Tombol Kirim -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-4 text-center">
                            <i class="fas fa-check mr-2"></i>
                            <span>Buat Bahan</span>
                        </button>
                    </form>
                    <!-- End Ingredient Creation Form -->
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
</body>

</html>