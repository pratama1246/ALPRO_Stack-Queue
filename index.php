<?php session_start(); // Memulai sesi PHP ?>
<!DOCTYPE html> <!-- Deklarasi tipe dokumen HTML -->
<html>
<head>
    <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsif untuk perangkat mobile -->
    <link rel="stylesheet" href="style.css"> <!-- Memasukkan file CSS eksternal -->
    <title>Turnamen Stack & Queue Based</title> <!-- Judul halaman -->
</head>
<body>
    <header>
    <h1 class="judul">Sistem Manajemen Turnamen E-Sport Berbasis Struktur Data</h1> <!-- Judul utama halaman -->
    </header>

    <main class="main-container">
    
    <div class="form-container">
    <div class="form-section">
        <h2>Input Strategi Tim</h2> <!-- Judul form input strategi tim -->
        <form method="post" action="stack.php"> <!-- Form untuk input strategi, dikirim ke stack.php -->
            <label>Nama Tim:</label> <!-- Label input nama tim -->
            <input type="text" name="tim"></br> <!-- Input teks untuk nama tim -->
            <label>Strategi:</label> <!-- Label input strategi -->
            <input type="text" name="strategi"> <!-- Input teks untuk strategi -->
            <br><br>
            <input type="submit" name="aksi" value="Tambah"> <!-- Tombol submit untuk tambah strategi -->
            <input type="submit" name="aksi" value="Undo"> <!-- Tombol submit untuk undo strategi -->
            <input type="submit" name="aksi" value="Cetak"> <!-- Tombol submit untuk cetak strategi -->
            <input type="submit" name="aksi" value="Reset Strategi" onclick="return confirm('Yakin ingin reset semua strategi?')"> <!-- Tombol reset strategi dengan konfirmasi -->
        </form>
    </div>

    <div class="form-section">
        <h2>Antrian Pertandingan</h2> <!-- Judul form antrian pertandingan -->
        <form method="post" action="queue.php"> <!-- Form untuk antrian pertandingan, dikirim ke queue.php -->
            <label>Pilih Tim:</label> <!-- Label untuk memilih tim -->
            <select name="tim"> <!-- Dropdown untuk memilih tim -->
                <?php
                if (isset($_SESSION['stack']['data'])) { // Jika data stack ada di sesi
                    foreach ($_SESSION['stack']['data'] as $timData) { // Loop setiap data tim
                        if (!empty($timData['tim'])) { // Jika nama tim tidak kosong
                            echo "<option value=\"{$timData['tim']}\">{$timData['tim']}</option>"; // Tampilkan opsi tim
                        }
                    }
                }
                ?>
            </select>
            <br><br>
            <input type="submit" name="aksi" value="Tambah Antrian"> <!-- Tombol tambah antrian -->
            <input type="submit" name="aksi" value="Panggil Tim"> <!-- Tombol panggil tim -->
            <input type="submit" name="aksi" value="Tampilkan Antrian"> <!-- Tombol tampilkan antrian -->
            <input type="submit" name="aksi" value="Reset Antrian" onclick="return confirm('Yakin ingin reset antrian?')"> <!-- Tombol reset antrian dengan konfirmasi -->
        </form>
    </div>
    </div>

     <div class="notif-section">
    <div class="output">
        <h2>Notifikasi</h2> <!-- Judul notifikasi -->
        <?php
        if (isset($_SESSION['flash'])) { // Jika ada pesan flash di sesi
            foreach ($_SESSION['flash'] as $msg) { // Loop setiap pesan
                echo "<p>$msg</p>"; // Tampilkan pesan
            }
            unset($_SESSION['flash']); // Hapus pesan setelah ditampilkan
        }
        ?>
    </div>
    </div>
    </main>

    <footer>
  <div class="footer-left">
    <p><strong>&copy; 2025 UTS Project Struktur Data</strong></p> <!-- Copyright -->
    <p><strong>Disusun oleh:</strong></p> <!-- Daftar penyusun -->
    <ol>
    <li>Aliyya Fadhilah (240102097)</li> <!-- Anggota tim 1 -->
    <li>Amelia Nur Hamda Rina (240102098)</li> <!-- Anggota tim 2 -->
    <li>Nuke Zahra Alifia (240302113)</li> <!-- Anggota tim 3 -->
    <li>Panji Parisya Akmal Hoetomo (240202114)</li> <!-- Anggota tim 4 -->
    <li>Pratama Putra Purwanto (240202115)</li> <!-- Anggota tim 5 -->
    </ol>
    <p><strong>Teknik Informatika 1D</strong></p> <!-- Kelas -->
  </div>

  <div class="footer-right">
    <p>Mata Kuliah: Pemrograman Struktur Data (Stack & Queue)</p> <!-- Nama mata kuliah -->
    <p>Dosen Pengampu: Dwi Novia Prasetyanti, S.Kom., M.Cs.</p> <!-- Nama dosen -->
    <p>Politeknik Negeri Cilacap</p> <!-- Nama kampus -->
    <p><strong>Versi: 1.0</strong></p> <!-- Versi aplikasi -->
  </div>
</footer>

</body>
</html>
