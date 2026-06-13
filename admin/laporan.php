<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';


/* FILTER */

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'tahun';

$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

/* QUERY FILTER */

if(!empty($tgl_awal) && !empty($tgl_akhir)){

    $where = "
    DATE(tanggal)
    BETWEEN '$tgl_awal'
    AND '$tgl_akhir'
    ";

    $label = $tgl_awal.' s/d '.$tgl_akhir;

}
elseif ($filter == 'hari') {

    $where = "DATE(tanggal)=CURDATE()";
    $label = "Hari Ini";

} elseif ($filter == 'minggu') {

    $where = "YEARWEEK(tanggal,1)=YEARWEEK(CURDATE(),1)";
    $label = "Minggu Ini";

} elseif ($filter == 'bulan') {

    $where = "
    MONTH(tanggal)=MONTH(CURDATE())
    AND YEAR(tanggal)=YEAR(CURDATE())
    ";
    $label = "Bulan Ini";

} else {

    $where = "YEAR(tanggal)=YEAR(CURDATE())";
    $label = "Tahun Ini";

}

/* TOTAL PESANAN */

$qPesanan = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE $where
");

$totalPesanan = mysqli_num_rows($qPesanan);

/* TOTAL PENDAPATAN */

$totalPendapatan = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT
COALESCE(SUM(total_harga),0) AS total
FROM pesanan
WHERE status_pesanan='selesai'
AND $where
")
);

/* TOTAL MENU */

$totalMenu = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT
COALESCE(SUM(qty),0) AS total
FROM detail_pesanan dp
JOIN pesanan p
ON dp.id_pesanan = p.id_pesanan
WHERE p.status_pesanan='selesai'
AND $where
")
);

/* RATA RATA */

$rata = 0;

if($totalPesanan > 0){

    $rata =
    $totalPendapatan['total']
    /
    $totalPesanan;

}

/* MENU TERLARIS */
/* SUDAH MENGIKUTI FILTER */

$terlaris = mysqli_query($conn,"
SELECT
menu.nama_menu,
SUM(detail_pesanan.qty) AS total
FROM detail_pesanan
JOIN menu
ON detail_pesanan.id_menu = menu.id_menu
JOIN pesanan
ON detail_pesanan.id_pesanan = pesanan.id_pesanan
WHERE pesanan.status_pesanan='selesai'
AND $where
GROUP BY detail_pesanan.id_menu
ORDER BY total DESC
LIMIT 5
");

/* JAM TERPADAT */
/* SUDAH MENGIKUTI FILTER */

$jamRamai = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT
HOUR(tanggal) AS jam,
COUNT(*) AS total
FROM pesanan
WHERE $where
GROUP BY HOUR(tanggal)
ORDER BY total DESC
LIMIT 1
")
);

/* CHART */

if(!empty($tgl_awal) && !empty($tgl_akhir)){

    $chart = mysqli_query($conn,"
    SELECT
    DATE(tanggal) AS label_chart,
    SUM(total_harga) AS total
    FROM pesanan
    WHERE status_pesanan='selesai'
    AND DATE(tanggal)
    BETWEEN '$tgl_awal'
    AND '$tgl_akhir'
    GROUP BY DATE(tanggal)
    ORDER BY DATE(tanggal)
    ");

}
elseif($filter == 'hari'){

    $chart = mysqli_query($conn,"
    SELECT
    HOUR(tanggal) AS label_chart,
    SUM(total_harga) AS total
    FROM pesanan
    WHERE status_pesanan='selesai'
    AND DATE(tanggal)=CURDATE()
    GROUP BY HOUR(tanggal)
    ORDER BY HOUR(tanggal)
    ");

}
elseif($filter == 'minggu'){

    $chart = mysqli_query($conn,"
    SELECT
    DAYNAME(tanggal) AS label_chart,
    SUM(total_harga) AS total
    FROM pesanan
    WHERE status_pesanan='selesai'
    AND YEARWEEK(tanggal,1)=YEARWEEK(CURDATE(),1)
    GROUP BY DAY(tanggal)
    ORDER BY DAY(tanggal)
    ");

}
elseif($filter == 'bulan'){

    $chart = mysqli_query($conn,"
    SELECT
    DAY(tanggal) AS label_chart,
    SUM(total_harga) AS total
    FROM pesanan
    WHERE status_pesanan='selesai'
    AND MONTH(tanggal)=MONTH(CURDATE())
    AND YEAR(tanggal)=YEAR(CURDATE())
    GROUP BY DAY(tanggal)
    ORDER BY DAY(tanggal)
    ");

}
else{

    $chart = mysqli_query($conn,"
    SELECT
    MONTH(tanggal) AS label_chart,
    SUM(total_harga) AS total
    FROM pesanan
    WHERE status_pesanan='selesai'
    AND YEAR(tanggal)=YEAR(CURDATE())
    GROUP BY MONTH(tanggal)
    ORDER BY MONTH(tanggal)
    ");

}

$jamData = [];
$totalData = [];

$detailLaporan = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE $where
ORDER BY tanggal DESC
");

while($c = mysqli_fetch_assoc($chart)){

    $jamData[] = $c['label_chart'];
    $totalData[] = $c['total'];

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Laporan</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="../assets/css/admin.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<!-- MAIN -->

<div class="main-content">
<?php include 'layout/sidebar.php'; ?>
<!-- MOBILE TOPBAR -->

<div class="mobile-topbar">

<button id="menuToggle">

<i class="bi bi-list"></i>

</button>

<h2>Laporan</h2>

<div class="notif-icon">

<i class="bi bi-bell"></i>

</div>

</div>

<!-- HEADER -->

<div class="welcome-box">

<h2>Laporan Penjualan</h2>

<p>
Ringkasan laporan kedai Maung Boba
</p>

</div>

<!-- STATUS -->

<div class="business-status">

<div class="status-dot"></div>

<p>

Kedai berjalan normal dan penjualan stabil hari ini

</p>

</div>
<form method="GET" class="filter-form">

<div class="date-group">

<input
type="date"
name="tgl_awal"
value="<?php echo $_GET['tgl_awal'] ?? ''; ?>">

<input
type="date"
name="tgl_akhir"
value="<?php echo $_GET['tgl_akhir'] ?? ''; ?>">

</div>

<div class="filter-action">

<button
type="button"
onclick="cekTanggal()"
class="btn-filter">

<i class="bi bi-search"></i>
Tampilkan Laporan

</button>

<a
href="laporan_pdf.php?filter=<?php echo $filter; ?>"
class="btn-pdf">

<i class="bi bi-file-earmark-pdf"></i>
PDF

</a>

<a
href="laporan_excel.php?filter=<?php echo $filter; ?>"
class="btn-excel">

<i class="bi bi-file-earmark-excel"></i>
Excel

</a>

</div>

</form>
<!-- FILTER -->

<div class="report-topbar">

<div class="filter-tabs">

<a
href="?filter=hari"
class="<?php
echo $filter == 'hari'
? 'active-filter'
: '';
?>">

Hari Ini

</a>

<a
href="?filter=minggu"
class="<?php
echo $filter == 'minggu'
? 'active-filter'
: '';
?>">

Minggu Ini

</a>

<a
href="?filter=bulan"
class="<?php
echo $filter == 'bulan'
? 'active-filter'
: '';
?>">

Bulan Ini

</a>

<a
href="?filter=tahun"
class="<?php
echo $filter == 'tahun'
? 'active-filter'
: '';
?>">

Tahun Ini

</a>

</div>

</div>

<!-- SUMMARY -->

<div class="summary-grid">

<div class="summary-card">

<p>Total Penjualan</p>

<h3>

Rp<?php echo number_format($totalPendapatan['total'] ?? 0); ?>

</h3>

</div>

<div class="summary-card">

<p>Total Pesanan</p>

<h3>

<?php echo $totalPesanan; ?>

</h3>

</div>

<div class="summary-card">

<p>Total Menu Terjual</p>

<h3>

<?php
echo $totalMenu['total'] ?? 0;
?>

</h3>

</div>

<div class="summary-card">

<p>Rata-rata Pesanan</p>

<h3>

Rp<?php echo number_format($rata); ?>

</h3>

</div>

<div class="summary-card waiting-card">

<p>Jam Terpadat</p>

<h3>

<?php
echo isset($jamRamai['jam'])
? $jamRamai['jam'].':00'
: '-';
?>

</h3>

</div>

</div>

<!-- MENU TERLARIS -->

<div class="best-menu-card">

<div class="section-title">

<h3>Menu Terlaris</h3>

</div>

<?php while($m = mysqli_fetch_array($terlaris)){ ?>

<div class="best-menu-item">

<div>

<h4>

<?php echo $m['nama_menu']; ?>

</h4>

<p>
Menu favorit pelanggan
</p>

</div>

<span>

<?php echo $m['total']; ?>x

</span>

</div>

<?php } ?>

</div>

<!-- CHART -->

<div class="report-chart-card">

<div class="chart-header">

<div>

<h3>Grafik Penjualan</h3>

<p>

<?php echo $label; ?>

</p>

</div>

</div>

<canvas id="salesChart"></canvas>

</div>

<div style="height:24px;"></div>

<div class="report-chart-card">

<div class="section-title">
<h3>Detail Transaksi</h3>

</div>

<div class="table-wrapper">
<table class="report-table">

<tr>

<th>ID</th>

<th>Pemesan</th>

<th>Tanggal</th>

<th>Total</th>

<th>Status</th>

</tr>

<?php while($d = mysqli_fetch_array($detailLaporan)){ ?>

<tr>

<td>
#<?php echo $d['id_pesanan']; ?>
</td>

<td>
<?php echo $d['nama_pemesan']; ?>
</td>

<td>
<?php
echo date(
'd-m-Y H:i',
strtotime($d['tanggal'])
);
?>
</td>

<td>
Rp<?php echo number_format($d['total_harga']); ?>
</td>

<td>

<span class="status-selesai">

<?php echo ucfirst($d['status_pesanan']); ?>

</span>

</td>

</tr>

<?php } ?>
</table>
</div>

</div>

</div>

<!-- BOTTOM NAV -->


<div class="bottom-navbar">

<a href="index.php">

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

<a
href="laporan.php"
class="active">

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

/* CHART */

const ctx =
document.getElementById(
'salesChart'
);

new Chart(ctx,{

type:'line',

data:{

labels:
<?php
echo json_encode(
$jamData
);
?>,

datasets:[{

data:
<?php
echo json_encode(
$totalData
);
?>,

borderColor:'#8a5536',

backgroundColor:'rgba(138,85,54,.08)',

hoverBorderWidth:5,

tension:.45,

fill:true,

hoverBackgroundColor:'rgba(138,85,54,.15)',

pointRadius:5,

pointHoverRadius:7,

pointBackgroundColor:'#8a5536',

pointBorderColor:'#fff',

pointBorderWidth:3

}]

},

options:{

responsive:true,

plugins:{

legend:{
display:false
},

tooltip:{

backgroundColor:'#111827',

titleColor:'#fff',

bodyColor:'#fff',

padding:14,

displayColors:false

}

},

scales:{

y:{

beginAtZero:true,

ticks:{
stepSize:5000
},

grid:{
color:'rgba(0,0,0,.05)'
}

},

x:{

grid:{
display:false
}

}

}

}

});

</script>
<script>

function cekTanggal(){

let awal =
document.querySelector(
'input[name="tgl_awal"]'
).value;

let akhir =
document.querySelector(
'input[name="tgl_akhir"]'
).value;

if(
awal == '' ||
akhir == ''
){

Swal.fire({
icon:'warning',
title:'Tanggal Belum Dipilih',
text:'Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu'
});

return;
}

document.querySelector(
'.filter-form'
).submit();

}

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.getElementById('btnLogout').addEventListener('click', function(e){

    e.preventDefault();

    Swal.fire({
        title: 'Logout?',
        text: 'Apakah Anda yakin ingin keluar dari sistem?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#111827',
        cancelButtonColor: '#dc2626',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if(result.isConfirmed){

            window.location.href = 'logout.php';

        }

    });

});

</script>
</body>
</html>