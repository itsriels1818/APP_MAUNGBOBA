<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';



/* SEARCH */

$cari = mysqli_real_escape_string(
$conn,
$_GET['cari'] ?? ''
);
$status =
isset($_GET['status'])
? $_GET['status']
: 'semua';

/* DATA PESANAN */
/* SUMMARY */

$totalSemua = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM pesanan
")
);

$totalMenunggu = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE status_pesanan='menunggu'
")
);

$totalDiproses = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE status_pesanan='diproses'
")
);

$totalSelesai = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE status_pesanan='selesai'
")
);
$where = "
(
nama_pemesan LIKE '%$cari%'
OR id_pesanan LIKE '%$cari%'
)
";

if($status != 'semua'){

$where .= "
AND status_pesanan='$status'
";

}

$pesanan = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE $where
ORDER BY id_pesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Pesanan</title>

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

<h2>Pesanan</h2>

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

<h2>Pesanan</h2>

<p>
Kelola seluruh pesanan pelanggan
</p>

</div>
<div class="summary-grid">

<div class="summary-card">

<p>Total</p>

<h3>

<?php echo $totalSemua; ?>

</h3>

</div>

<div class="summary-card waiting-card">

<p>Menunggu</p>

<h3>

<?php echo $totalMenunggu; ?>

</h3>

</div>

<div class="summary-card process-card">

<p>Diproses</p>

<h3>

<?php echo $totalDiproses; ?>

</h3>

</div>

<div class="summary-card done-card">

<p>Selesai</p>

<h3>

<?php echo $totalSelesai; ?>

</h3>

</div>

</div>
<!-- SEARCH -->

<form method="GET" class="modern-search">

<i class="bi bi-search"></i>

<input
type="text"
name="cari"
placeholder="Cari pelanggan..."
value="<?php echo $cari; ?>">

</form>
<div class="stock-filter-card">

<div class="filter-tabs">

<a
href="?status=semua"
class="<?php echo $status=='semua' ? 'active-filter' : ''; ?>">

Semua

</a>

<a
href="?status=menunggu"
class="<?php echo $status=='menunggu' ? 'active-filter' : ''; ?>">

Menunggu

</a>

<a
href="?status=diproses"
class="<?php echo $status=='diproses' ? 'active-filter' : ''; ?>">

Diproses

</a>

<a
href="?status=selesai"
class="<?php echo $status=='selesai' ? 'active-filter' : ''; ?>">

Selesai

</a>

</div>

</div>
<!-- ORDER -->

<div class="order-list" id="orderList">

<?php
if(mysqli_num_rows($pesanan) == 0){
?>
<div class="empty-order">
<i class="bi bi-inbox"></i>
<h3>Tidak Ada Pesanan</h3>
<p>Belum ada data yang sesuai pencarian</p>
</div>
<?php
}
?>

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

<div class="order-total">

Rp<?php
echo number_format(
$p['total_harga']
);
?>

</div>

<div class="order-detail">

<span>Tanggal</span>

<span>

<?php
echo date(
'd M Y H:i',
strtotime($p['tanggal'])
);
?>

</span>

</div>

<?php

$detail = mysqli_query($conn,"
SELECT *
FROM detail_pesanan dp
JOIN menu m
ON dp.id_menu = m.id_menu
WHERE dp.id_pesanan='".$p['id_pesanan']."'
");

?>
<?php

$totalItem = mysqli_num_rows($detail);

?>

<div class="order-detail">

<span>Jumlah Item</span>

<span>

<?php echo $totalItem; ?> Item

</span>

</div>
<div class="order-items">

<?php while($d = mysqli_fetch_array($detail)){ ?>

<div class="item-row">

<div class="item-left">

<img
src="../assets/img/<?php echo $d['gambar']; ?>"
onerror="this.src='../assets/img/no-image.png'">

<div>

<h6>

<?php
echo $d['nama_menu'];
?>

</h6>

<p>

Qty:
<?php
echo $d['qty'];
?>

</p>

<?php if($d['catatan'] != ''){ ?>

<small>

<?php
echo $d['catatan'];
?>

</small>

<?php } ?>

</div>

</div>

<div class="item-price">

Rp<?php
echo number_format(
$d['harga'] * $d['qty']
);
?>

</div>

</div>

<?php } ?>

</div>

<div class="order-action">

<?php
if($p['status_pesanan'] == 'menunggu'){
?>

<a
href="../process/update_status.php?id=<?php echo $p['id_pesanan']; ?>&status=diproses&filter=<?php echo $status; ?>"
class="btn-process -status">

Diproses

</a>

<?php }elseif($p['status_pesanan'] == 'diproses'){ ?>

<a
href="../process/update_status.php?id=<?php echo $p['id_pesanan']; ?>&status=selesai&filter=<?php echo $status; ?>"
class="btn-done -status">

Selesai

</a>

<?php } ?>

</div>

</div>

<?php } ?>

</div>

</div>

<!-- BOTTOM NAV -->

<div class="bottom-navbar">

<a href="index.php">

<i class="bi bi-house-door"></i>

<span>Dashboard</span>

</a>

<a
href="pesanan.php"
class="active">

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

const Btn =
document.querySelectorAll(
'.-status'
);

Btn.forEach(btn => {

btn.addEventListener(
'click',
function(e){

e.preventDefault();

const link =
this.getAttribute('href');

Swal.fire({
title: 'Ubah Status Pesanan?',
text: 'Status pesanan akan diperbarui',
icon: 'question',
showCancelButton: true,
confirmButtonText: 'Ya, ',
cancelButtonText: 'Batal',
confirmButtonColor: '#8a5536'
}).then((result) => {

if(result.isConfirmed){

Swal.fire({
title:'Memproses...',
text:'Mohon tunggu',
allowOutsideClick:false,
didOpen:()=>{
Swal.showLoading();

setTimeout(()=>{
window.location = link;
},1000);

}
});

}

});

}
);

});

</script>

<?php if(isset($_GET['success'])){ ?>

<script>

Swal.fire({
icon:'success',
title:'Berhasil',
text:'Status pesanan berhasil diperbarui',
confirmButtonColor:'#8a5536'
});

</script>

<?php } ?>
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

<audio id="notifPesanan" preload="auto" loop>
    <source src="../audio/orderan-masuk.mp3" type="audio/mpeg">
</audio>

<script>

let totalPesanan = <?php echo $totalMenunggu; ?>;
let notifAktif = false;

function cekPesananBaru(){

    if(notifAktif){
        return;
    }

    fetch('ajax/cek_pesanan.php?t=' + Date.now())

    .then(response => response.json())

    .then(data => {

        let totalBaru = parseInt(data.total);

        if(totalBaru > totalPesanan){

            notifAktif = true;

            totalPesanan = totalBaru;

            const audio =
            document.getElementById('notifPesanan');

            if(audio){

                audio.pause();
                audio.currentTime = 0;

                audio.play()
                .then(() => {

                    console.log(
                    'Audio notifikasi diputar'
                    );

                })
                .catch(error => {

                    console.log(
                    'Audio gagal diputar:',
                    error
                    );

                });

            }

            Swal.fire({

                title: '🔔 PESANAN BARU',

                html: `
                    <b>Ada pesanan baru masuk!</b>
                    <br><br>
                    Silakan cek dan proses pesanan pelanggan.
                `,

                icon: 'warning',

                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,

                showCancelButton: false,

                confirmButtonText: 'Terima Pesanan',

                confirmButtonColor: '#8a5536'

            }).then((result) => {

                if(result.isConfirmed){

                    if(audio){

                        audio.pause();
                        audio.currentTime = 0;

                    }

                    notifAktif = false;

                    location.reload();

                }

            });

        }

    })

    .catch(error => {

        console.log(
        'Gagal cek pesanan:',
        error
        );

    });

}

setInterval(
    cekPesananBaru,
    3000
);

</script>
</body>
</html>