<!DOCTYPE html>
<html>
<head>
    <title>Form Pesanan</title>
</head>
<body>
    <h2>Form Pemesanan Barang</h2>
    <form method="POST" action="Proses.php" onsubmit="return validateForm()">
        Email: <input type="email" name="email"><br><br>
        Password: <input type="password" name="password"><br><br>
        Nama Barang: <input type="text" name="nama_barang"><br><br>
        Jumlah: <input type="number" name="jumlah"><br><br>
        Nomor HP: <input type="text" name="nomorhp"><br><br>
        <input type="submit" value="Simpan Pesanan">
    </form>
    <script>
        /**
         * Fungsi ini dipanggil saat form akan disubmit.
         * Tujuannya untuk memastikan semua field sudah terisi dengan benar.
         */
        function validateForm() {
            // Mengambil referensi ke form pertama di halaman
            const f = document.forms[0];

            // Mengambil nilai dari setiap input field
            const email = f.email.value;
            const password = f.password.value;
            const namaBarang = f.nama_barang.value;
            const jumlah = f.jumlah.value;
            const nomorHp = f.nomorhp.value;

            // 1. Memeriksa apakah ada field yang kosong
            if (email.trim() === "" || password.trim() === "" || namaBarang.trim() === "" || jumlah.trim() === "" || nomorHp.trim() === "") {
                alert("Semua field wajib diisi!");
                return false; // Batalkan submit
            }

            // 2. TAMBAHAN: Memeriksa format email menggunakan regular expression
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Format email tidak valid!");
                return false; // Batalkan submit
            }

            // 3. Memeriksa apakah jumlah adalah angka yang valid dan lebih dari 0
            if (isNaN(jumlah) || parseInt(jumlah) <= 0) {
                alert("Jumlah harus berupa angka dan lebih besar dari 0!");
                return false; // Batalkan submit
            }

            // 4. Memeriksa apakah Nomor HP hanya berisi angka dan panjangnya wajar (8-15 digit)
            if (!/^\d+$/.test(nomorHp) || nomorHp.length < 8 || nomorHp.length > 15) {
                alert("Format Nomor HP tidak valid. Harap isi hanya dengan angka (8-15 digit).");
                return false; // Batalkan submit
            }

            // Jika semua validasi lolos, kembalikan true untuk melanjutkan pengiriman form
            return true;
        }
    </script>
</body>
</html>