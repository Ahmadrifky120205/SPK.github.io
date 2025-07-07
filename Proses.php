<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pesanan</title>
</head>

<body>
    <?php
    /**
     * ===================================================================
     * KODE PALING PENTING ADA DI BAWAH INI.
     * 'include "koneksi.php";' WAJIB menjadi baris pertama setelah <?php
     * agar variabel koneksi ($conn) siap digunakan oleh semua kode di bawahnya.
     * ===================================================================
     */
    include "koneksi.php";

    // Baris ini untuk menampilkan semua jenis error, sangat membantu debugging.
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    /**
     * ===================================================================
     * PEMERIKSAAN DIAGNOSTIK BARU
     * Kode ini akan memeriksa apakah variabel $conn berhasil dibuat.
     * Jika tidak, program akan berhenti dan memberikan pesan yang jelas.
     * ===================================================================
     */
    if (!isset($conn) || $conn->connect_error) {
        // Jika $conn tidak ada, atau jika ada error koneksi
        $error_message = isset($conn) ? $conn->connect_error : "Variabel koneksi (\$conn) tidak ditemukan.";
        die("<h1>Koneksi ke Database Gagal Total!</h1><p><strong>Pesan Error:</strong> " . $error_message . "</p><p><strong>Solusi:</strong> Pastikan file 'koneksi.php' ada di folder yang sama ('C:\\xampp\\htdocs\\praktik 11\\') dan tidak ada kesalahan penulisan (username, password, nama database) di dalamnya.</p>");
    }


    // Bagian ini hanya berjalan jika ada data yang dikirim dari form (method POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nama_barang = $_POST['nama_barang'];
        $jumlah = (int)$_POST['jumlah'];
        $nomorhp = $_POST['nomorhp'];

        // Logika untuk menentukan keterangan dan ketentuan
        if (strtolower($nama_barang) === "laptop" && $jumlah >= 5) {
            $keterangan = "Butuh konfirmasi";
            $ketentuan = "Perlu cek stok";
        } else {
            $keterangan = "Langsung diproses";
            $ketentuan = "Siap kirim";
        }
        
        $sql = "INSERT INTO pesanan (nama_barang, jumlah, nomorhp, keterangan, ketentuan) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisss", $nama_barang, $jumlah, $nomorhp, $keterangan, $ketentuan);

        if (mysqli_stmt_execute($stmt)) {
            echo "<h3>Pesanan berhasil disimpan!</h3>";
        } else {
            echo "Gagal menyimpan: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }

    // Tampilkan link untuk melihat data
    echo "<br><br><a href='Proses.php?lihat=1'>Lihat semua pesanan</a>";

    // Bagian ini hanya berjalan jika URL di browser mengandung ?lihat=1
    if (isset($_GET['lihat'])) {
        echo "<h2>Daftar Pesanan</h2>";

        $hasil = mysqli_query($conn, "SELECT * FROM pesanan");

        echo "<table border='1' cellpadding='5' cellspacing='0'>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Nomor HP</th>
                    <th>Keterangan</th>
                    <th>Ketentuan</th>
                </tr>";

        // Loop untuk menampilkan setiap baris data dari database
        while ($row = mysqli_fetch_assoc($hasil)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama_barang']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>{$row['nomorhp']}</td>
                    <td>{$row['keterangan']}</td>
                    <td>{$row['ketentuan']}</td>
                </tr>";
        }

        echo "</table>";
    }

    // Menutup koneksi database di akhir setelah semua proses selesai.
    mysqli_close($conn); 
    ?>
</body>
</html>
