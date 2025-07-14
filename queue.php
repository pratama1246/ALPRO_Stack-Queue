<?php session_start(); // Memulai sesi PHP ?>
<?php
// Inisialisasi queue jika belum ada
if (!isset($_SESSION['queue'])) { // Jika queue belum ada di session
    $_SESSION['queue'] = [ // Inisialisasi queue
        'head' => -1, // Penanda head queue
        'tail' => -1, // Penanda tail queue
        'data' => [] // Data queue
    ];
}

$queue = &$_SESSION['queue']; // Referensi queue dari session
define("MAX", 10); // Maksimal jumlah antrian

function isQueueFull() { // Fungsi untuk mengecek apakah queue penuh
    global $queue; // Menggunakan variabel global queue
    return $queue['tail'] >= MAX - 1; // Mengembalikan true jika tail sudah mencapai batas maksimal
}

function isQueueEmpty() { // Fungsi untuk mengecek apakah queue kosong
    global $queue; // Menggunakan variabel global queue
    return $queue['tail'] == -1; // Mengembalikan true jika tail bernilai -1
}

function enqueue($tim) { // Fungsi untuk menambah tim ke antrian
    global $queue; // Menggunakan variabel global queue
    if (isQueueFull()) { // Jika queue penuh
        $_SESSION['flash'][] = "Antrian penuh."; // Tambahkan pesan ke flash session
        return; // Keluar dari fungsi
    }
    for ($i = $queue['head']; $i <= $queue['tail']; $i++) { // Loop untuk mengecek duplikasi tim
        if ($queue['data'][$i] === $tim) { // Jika tim sudah ada di antrian
            $_SESSION['flash'][] = "Tim <strong>$tim</strong> sudah ada dalam antrian."; // Tambahkan pesan ke flash session
            return; // Keluar dari fungsi
        }
    }
    if (isQueueEmpty()) { // Jika queue kosong
        $queue['head'] = $queue['tail'] = 0; // Set head dan tail ke 0
    } else {
        $queue['tail']++; // Tambah tail
    }
    $queue['data'][$queue['tail']] = $tim; // Masukkan tim ke data queue
    $_SESSION['flash'][] = "Tim <strong>$tim</strong> masuk ke dalam antrian."; // Tambahkan pesan ke flash session
}

function dequeue() { // Fungsi untuk mengambil tim dari antrian
    global $queue; // Menggunakan variabel global queue
    if (isQueueEmpty()) { // Jika queue kosong
        $_SESSION['flash'][] = "Antrian kosong."; // Tambahkan pesan ke flash session
        return; // Keluar dari fungsi
    }
    $tim = $queue['data'][$queue['head']]; // Ambil tim dari head

    // Ambil strategi dari stack
    $strategi = [];
    if (isset($_SESSION['stack']['data'])) {
        foreach ($_SESSION['stack']['data'] as $timData) {
            if ($timData['tim'] === $tim && !empty($timData['strategi'])) {
                $strategi = $timData['strategi'];
                break;
            }
        }
    }
    $listStrategi = !empty($strategi) ? implode(", ", $strategi) : "tidak memiliki strategi.";

    $_SESSION['flash'][] = "Tim berikutnya: <strong>$tim</strong> dengan strategi: <strong>$listStrategi</strong>"; // Tambahkan pesan ke flash session

    for ($i = $queue['head']; $i < $queue['tail']; $i++) { // Geser data queue ke depan
        $queue['data'][$i] = $queue['data'][$i + 1]; // Geser data
    }
    unset($queue['data'][$queue['tail']]); // Hapus data pada posisi tail
    $queue['tail']--; // Kurangi tail

    if ($queue['tail'] < 0) { // Jika tail kurang dari 0
        $queue['head'] = -1; // Set head ke -1
    }

    // Hapus strategi dari stack saat tim dipanggil
    for ($j = 0; $j <= $_SESSION['stack']['top']; $j++) { // Loop stack
        if ($_SESSION['stack']['data'][$j]['tim'] === $tim) { // Jika tim ditemukan di stack
            array_splice($_SESSION['stack']['data'], $j, 1); // Hapus data dari stack
            $_SESSION['stack']['top']--; // Kurangi top stack
            break; // Keluar dari loop
        }
    }
}

function tampilkanQueue() { // Fungsi untuk menampilkan antrian
    global $queue; // Menggunakan variabel global queue
    if (isQueueEmpty()) { // Jika queue kosong
        $_SESSION['flash'][] = "Antrian kosong."; // Tambahkan pesan ke flash session
    } else {
        $_SESSION['flash'][] = "<strong>Daftar Antrian:</strong>"; // Tambahkan judul daftar antrian
        for ($i = $queue['head']; $i <= $queue['tail']; $i++) { // Loop data queue
            $_SESSION['flash'][] = ($i + 1) . ". " . $queue['data'][$i]; // Tambahkan data ke flash session
        }
    }
}

function resetQueue() { // Fungsi untuk mereset antrian
    $_SESSION['queue'] = [ // Set queue ke kondisi awal
        'head' => -1, // Head ke -1
        'tail' => -1, // Tail ke -1
        'data' => [] // Data kosong
    ];
    $_SESSION['flash'][] = "Antrian berhasil direset."; // Tambahkan pesan ke flash session
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Jika request method POST
    $aksi = $_POST['aksi'] ?? ''; // Ambil aksi dari POST
    $tim = $_POST['tim'] ?? ''; // Ambil tim dari POST

    switch ($aksi) { // Switch berdasarkan aksi
        case "Tambah Antrian": // Jika aksi tambah antrian
            if ($tim !== '') enqueue($tim); // Jika tim tidak kosong, tambahkan ke antrian
            else $_SESSION['flash'][] = "Silakan pilih tim."; // Jika kosong, tampilkan pesan
            break;

        case "Panggil Tim": // Jika aksi panggil tim
            dequeue(); // Panggil tim dari antrian
            break;

        case "Tampilkan Antrian": // Jika aksi tampilkan antrian
            tampilkanQueue(); // Tampilkan antrian
            break;

        case "Reset Antrian": // Jika aksi reset antrian
            resetQueue(); // Reset antrian
            break;
    }
    header("Location: index.php"); // Redirect ke index.php
    exit; // Keluar dari script
}
?>
