<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';


/* FILTER */

$kategori =
isset($_GET['kategori'])
? $_GET['kategori']
: 'semua';

/* QUERY */

$where = "1";

if($kategori != 'semua'){

$where .= "
AND nama_kategori='$kategori'
";

}

$stok = mysqli_query($conn,"
SELECT *
FROM menu
JOIN kategori
ON menu.id_kategori = kategori.id_kategori
WHERE $where
ORDER BY stok ASC
");

$totalHabis = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM menu
WHERE stok <= 0
")
);

$totalMenipis = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM menu
WHERE stok > 0
AND stok <= 5
")
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Kelola Stok</title>

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

<div class="mobile-topbar">

<button id="menuToggle">

<i class="bi bi-list"></i>

</button>

<h2>Stok</h2>

<div class="notif-icon">

<i class="bi bi-box-seam"></i>

</div>

</div>

<div class="welcome-box">

<h2>Kelola Stok</h2>

<p>
Pantau stok menu kedai
</p>

</div>

<div class="dashboard-cards">

<div class="dashboard-card">

<div>

<p>Stok Habis</p>

<h3>

<?php echo $totalHabis; ?>

</h3>

<span>Menu perlu diisi ulang</span>

</div>

<div class="card-icon">

<i class="bi bi-x-circle"></i>

</div>

</div>

<div class="dashboard-card">

<div>

<p>Stok Menipis</p>

<h3>

<?php echo $totalMenipis; ?>

</h3>

<span>Segera lakukan restok</span>

</div>

<div class="card-icon">

<i class="bi bi-exclamation-triangle"></i>

</div>

</div>

</div>
<!-- FILTER -->

<div class="stock-filter-card">

<div class="filter-tabs">

<a
href="?kategori=semua"
class="<?php echo $kategori=='semua' ? 'active-filter' : ''; ?>">
Semua
</a>

<a
href="?kategori=Minuman"
class="<?php echo $kategori=='Minuman' ? 'active-filter' : ''; ?>">
Minuman
</a>

<a
href="?kategori=Makanan"
class="<?php echo $kategori=='Makanan' ? 'active-filter' : ''; ?>">
Makanan
</a>

</div>

</div>


<!-- STOCK GRID -->

<div class="stock-grid">    

<?php if(mysqli_num_rows($stok) == 0){ ?>

<div class="empty-menu">

<i class="bi bi-box-seam"></i>

<h3>Tidak Ada Data Stok</h3>

<p>
Belum ada menu pada kategori ini
</p>

</div>

<?php } ?>

<?php while($s = mysqli_fetch_array($stok)){ ?>

<div class="stock-card">

<div class="stock-image">

<img
src="../assets/img/<?php echo $s['gambar']; ?>"
onerror="this.src='../assets/img/no-image.png'">

</div>

<div class="stock-body">

<div class="stock-top">

<h4>

<?php
echo $s['nama_menu'];
?>

</h4>

<span>

<?php
echo $s['nama_kategori'];
?>

</span>

</div>

<?php

if($s['stok'] <= 0){

?>

<div class="stock-status out">

Stok Habis

</div>

<?php

}elseif($s['stok'] <= 5){

?>

<div class="stock-status low">

Stok Menipis

</div>

<?php }else{ ?>

<div class="stock-status ready">

Stok Aman

</div>

<?php } ?>

<div class="stock-footer">

<h3>

<?php
echo $s['stok'];
?>

</h3>

<a
href="edit_menu.php?id=<?php echo $s['id_menu']; ?>">

Update

</a>

</div>

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

<a href="pesanan.php">

<i class="bi bi-receipt"></i>

<span>Pesanan</span>

</a>

<a href="menu.php">

<i class="bi bi-cup-straw"></i>

<span>Menu</span>

</a>

<a
href="stok.php"
class="active">

<i class="bi bi-grid"></i>

<span>Stok</span>

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