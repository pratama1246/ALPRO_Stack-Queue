<?php session_start(); // Memulai sesi PHP ?>
<?php
// Inisialisasi stack jika belum ada
if (!isset($_SESSION['stack']) || !is_array($_SESSION['stack'])) { // Jika stack belum ada di sesi atau bukan array
    $_SESSION['stack'] = [ // Inisialisasi stack
        'top' => -1, // Penanda posisi teratas stack, -1 berarti kosong
        'data' => [] // Data stack berupa array kosong
    ];
}

$stack = &$_SESSION['stack']; // Mengambil referensi stack dari sesi
define("MAX", 10); // Mendefinisikan kapasitas maksimum stack

function pushStrategi($tim, $strategi) { // Fungsi untuk menambah strategi ke stack
    global $stack; // Menggunakan variabel stack global
    $found = false; // Penanda apakah tim sudah ada
    for ($i = 0; $i <= $stack['top']; $i++) { // Loop untuk mencari tim di stack
        if ($stack['data'][$i]['tim'] === $tim) { // Jika tim ditemukan
            $stack['data'][$i]['strategi'][] = $strategi; // Tambahkan strategi ke tim tersebut
            $_SESSION['flash'][] = "Strategi <strong>$strategi</strong> ditambahkan ke Tim <strong>$tim</strong>."; // Pesan sukses
            $found = true; // Tandai bahwa tim sudah ditemukan
            break; // Keluar dari loop
        }
    }
    if (!$found) { // Jika tim belum ada di stack
        if ($stack['top'] < MAX - 1) { // Jika stack belum penuh
            $stack['top']++; // Naikkan posisi top
            $stack['data'][$stack['top']] = [ // Tambahkan tim baru ke stack
                'tim' => $tim, // Nama tim
                'strategi' => [$strategi] // Strategi pertama untuk tim tersebut
            ];
            $_SESSION['flash'][] = "Tim <strong>$tim</strong> ditambahkan dengan strategi <strong>$strategi</strong>."; // Pesan sukses
        } else { // Jika stack penuh
            $_SESSION['flash'][] = "Stack penuh."; // Pesan stack penuh
        }
    }
}

function popStrategiTerakhir() { // Fungsi untuk menghapus strategi terakhir dari stack
    global $stack; // Menggunakan variabel stack global
    for ($i = $stack['top']; $i >= 0; $i--) { // Loop dari atas ke bawah stack
        if (!empty($stack['data'][$i]['strategi'])) { // Jika tim memiliki strategi
            $hapus = array_pop($stack['data'][$i]['strategi']); // Hapus strategi terakhir
            $_SESSION['flash'][] = "Strategi terakhir <strong>$hapus</strong> dari Tim <strong>{$stack['data'][$i]['tim']}</strong> dihapus."; // Pesan sukses
            return; // Keluar dari fungsi
        }
    }
    $_SESSION['flash'][] = "Tidak ada strategi untuk dihapus."; // Pesan jika tidak ada strategi
}

function cetakStack() { // Fungsi untuk mencetak isi stack
    global $stack; // Menggunakan variabel stack global
    if ($stack['top'] == -1) { // Jika stack kosong
        $_SESSION['flash'][] = "Stack kosong."; // Pesan stack kosong
        return; // Keluar dari fungsi
    }
    $_SESSION['flash'][] = "<strong>Daftar Strategi Per Tim:</strong><br/>"; // Judul daftar strategi
    for ($i = $stack['top']; $i >= 0; $i--) { // Loop dari atas ke bawah stack
        $tim = $stack['data'][$i]['tim']; // Ambil nama tim
        $strategiList = $stack['data'][$i]['strategi']; // Ambil daftar strategi tim
        if (!empty($strategiList)) { // Jika ada strategi
            $_SESSION['flash'][] = "<strong>Tim: $tim</strong><br/>"; // Tampilkan nama tim
            foreach (array_reverse($strategiList) as $strat) { // Loop strategi dari yang terbaru
                $_SESSION['flash'][] = "- $strat"; // Tampilkan strategi
            }
        }
    }
}

function resetStack() { // Fungsi untuk mereset stack
    $_SESSION['stack'] = ['top' => -1, 'data' => []]; // Set stack menjadi kosong
    $_SESSION['flash'][] = "Strategi berhasil direset."; // Pesan sukses reset
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Jika ada request POST
    $aksi = $_POST['aksi'] ?? ''; // Ambil aksi dari form
    $tim = trim($_POST['tim'] ?? ''); // Ambil nama tim dari form
    $strategi = trim($_POST['strategi'] ?? ''); // Ambil strategi dari form

    switch ($aksi) { // Pilih aksi berdasarkan input
        case "Tambah": // Jika aksi tambah
            if ($tim !== '' && $strategi !== '') { // Jika nama tim dan strategi tidak kosong
                pushStrategi($tim, $strategi); // Tambahkan strategi ke stack
            } else { // Jika ada yang kosong
                $_SESSION['flash'][] = "Harap isi nama tim dan strategi."; // Pesan error
            }
            break;

        case "Undo": // Jika aksi undo
            popStrategiTerakhir(); // Hapus strategi terakhir
            break;

        case "Cetak": // Jika aksi cetak
            cetakStack(); // Cetak isi stack
            break;

        case "Reset Strategi": // Jika aksi reset
            resetStack(); // Reset stack
            break;
    }
    header("Location: index.php"); // Redirect ke index.php
    exit; // Keluar dari script
}
?>
