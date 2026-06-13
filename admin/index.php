<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';


$id_user = $_SESSION['id_user'];

$userLogin = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM users WHERE id_user='$id_user'"
    )
);


/* TOTAL PESANAN */
$totalPesanan = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM pesanan
")
);

/* PENDAPATAN */
$qPendapatan = mysqli_query($conn,"
SELECT COALESCE(SUM(total_harga),0) as total
FROM pesanan
WHERE DATE(tanggal)=CURDATE()
");

$pendapatan = mysqli_fetch_assoc($qPendapatan);


/* TOTAL MENU */
$totalMenu = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM menu
")
);

/* TOTAL PELANGGAN */
$totalPelanggan = mysqli_num_rows(
mysqli_query($conn,"
SELECT DISTINCT nama_pemesan
FROM pesanan
")
);

/* PESANAN TERBARU */
$pesanan = mysqli_query($conn,"
SELECT *
FROM pesanan
ORDER BY id_pesanan DESC
LIMIT 3
");
/* GRAFIK PENJUALAN */

$grafik = mysqli_query($conn,"
SELECT
DATE(tanggal) as hari,
COUNT(id_pesanan) as total
FROM pesanan
GROUP BY DATE(tanggal)
ORDER BY DATE(tanggal) DESC
LIMIT 7
");

$label = [];
$data = [];

while($g = mysqli_fetch_assoc($grafik)){

    $label[] = date(
        'd M',
        strtotime($g['hari'])
    );

    $data[] = $g['total'];

}

$label = array_reverse($label);
$data = array_reverse($data);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Kedai Maung Boba</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>



<!-- MAIN -->

<div class="main-content">
<?php include 'layout/sidebar.php'; ?>

<!-- TOPBAR -->

<div class="mobile-topbar">

<button id="menuToggle">

<i class="bi bi-list"></i>

</button>

<h2>Dashboard</h2>

<div class="notif-icon">

<i class="bi bi-bell"></i>

<?php
$notif = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM pesanan
WHERE status_pesanan='menunggu'
")
);
?>

<span><?php echo $notif; ?></span>

</div>

</div>

<!-- HEADER -->

<div class="welcome-box">

<h2>Dashboard</h2>

<p>
Selamat datang kembali,
<?= $_SESSION['nama_lengkap']; ?>!
</p>

</div>

<!-- CARD -->

<div class="dashboard-cards">

<div class="dashboard-card">

<div>

<p>Total Pesanan</p>

<h3>

<?php echo $totalPesanan; ?>

</h3>

<span>Data pesanan terkini</span>

</div>

<div class="card-icon">

<i class="bi bi-bag"></i>

</div>

</div>

<div class="dashboard-card">

<div>

<p>Pendapatan Hari Ini</p>

<h3>

Rp<?php
echo number_format(
$pendapatan['total']
);
?>

</h3>

<span>Total transaksi</span>

</div>

<div class="card-icon">

<i class="bi bi-graph-up"></i>

</div>

</div>

<div class="dashboard-card">

<div>

<p>Total Menu</p>

<h3>

<?php echo $totalMenu; ?>

</h3>

<span>Menu tersedia</span>

</div>

<div class="card-icon">

<i class="bi bi-cup-hot"></i>

</div>

</div>

<div class="dashboard-card">

<div>

<p>Total Pelanggan</p>

<h3>

<?php echo $totalPelanggan; ?>

</h3>

<span>Pelanggan terdaftar</span>

</div>

<div class="card-icon">

<i class="bi bi-people"></i>

</div>

</div>

</div>

<!-- GRAFIK -->

<div class="chart-card">

<h3>Grafik Pesanan 7 Hari Terakhir</h3>

<canvas id="salesChart"></canvas>

</div>

<!-- PESANAN -->

<div class="section-title">

<h3>Pesanan Terbaru</h3>

<a href="pesanan.php">

Lihat Semua

</a>

</div>

<div class="order-list">

<?php while($p = mysqli_fetch_array($pesanan)){ ?>

<div class="order-card">

<div class="order-top">

<h4>

#ORD00<?php
echo $p['id_pesanan'];
?>

</h4>

<?php

$class = 'waiting';

if($p['status_pesanan'] == 'diproses'){
$class = 'process';
}

if($p['status_pesanan'] == 'selesai'){
$class = 'done';
}

?>

<span class="status <?php echo $class; ?>">

<?php
echo ucfirst(
$p['status_pesanan']
);
?>

</span>

</div>

<h5>

<?php
echo $p['nama_pemesan'];
?>

</h5>

<div class="order-detail">

<span>
Fresh Boba Drink
</span>

<span>

Rp<?php echo number_format($pendapatan['total']); ?>

</span>

</div>

<div class="order-footer">

<p>

<?php
echo date(
'd M Y H:i',
strtotime($p['tanggal'])
);
?>

</p>


</div>

</div>

<?php } ?>

</div>

</div>

<!-- BOTTOM NAV -->

<div class="bottom-navbar">

<a
href="index.php"
class="active">

<i class="bi bi-house-door"></i>

<span>Dashboard</span>

</a>

<a href="pesanan.php">

<i class="bi bi-receipt"></i>

<span>Pesanan</span>

</a>

<a href="menu.php">

<i class="bi bi-cup-straw"></i>

<span>Menu</span>

</a>

<a href="laporan.php">

<i class="bi bi-grid"></i>

<span>Lainnya</span>

</a>

</div>

<script>

const menuToggle =
document.getElementById(
'menuToggle'
);

const sidebar =
document.getElementById(
'sidebar'
);

const closeSidebar =
document.getElementById(
'closeSidebar'
);

menuToggle.onclick = () => {

sidebar.classList.add(
'active'
);

}

closeSidebar.onclick = () => {

sidebar.classList.remove(
'active'
);

}

</script>
</body>
</html>