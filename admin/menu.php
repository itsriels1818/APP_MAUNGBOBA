<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';



/* FILTER */

$kategori =
mysqli_real_escape_string(
$conn,
$_GET['kategori'] ?? 'semua'
);

/* QUERY */

$where = "1";

if($kategori != 'semua'){

$where .= "
AND nama_kategori='$kategori'
";

}

$menu = mysqli_query($conn,"
SELECT *
FROM menu
JOIN kategori
ON menu.id_kategori = kategori.id_kategori
WHERE $where
ORDER BY id_menu DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Kelola Menu</title>

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
<!-- MOBILE TOPBAR -->

<div class="mobile-topbar">

<button id="menuToggle">

<i class="bi bi-list"></i>

</button>

<h2>Menu</h2>

<div class="notif-icon">

<i class="bi bi-cup-hot"></i>

</div>

</div>

<!-- HEADER -->

<div class="welcome-box">

<h2>Kelola Menu</h2>

<p>
Daftar menu kedai Maung Boba
</p>

</div>
<!-- INFO MENU -->

<div class="menu-info-bar">

<div class="menu-total">

<h3>
<?php echo mysqli_num_rows($menu); ?>
</h3>

<p>Total Menu</p>

</div>

<div class="menu-search">

<i class="bi bi-cup-straw"></i>

<input
type="text"
id="searchMenu"
placeholder="Cari menu...">

</div>

</div>

<!-- BUTTON -->

<div class="menu-top-action">

<a
href="tambah_menu.php"
class="add-menu-btn">

<i class="bi bi-plus-lg"></i>

Tambah Menu

</a>

</div>

<!-- FILTER -->

<div class="stock-filter-card">

<div class="filter-tabs">

<a
href="?kategori=semua"
class="<?php
echo $kategori == 'semua'
? 'active-filter'
: '';
?>">

Semua

</a>

<a
href="?kategori=Minuman"
class="<?php
echo $kategori == 'Minuman'
? 'active-filter'
: '';
?>">

Minuman

</a>

<a
href="?kategori=Makanan"
class="<?php
echo $kategori == 'Makanan'
? 'active-filter'
: '';
?>">

Makanan

</a>

<a
href="?kategori=Promo"
class="<?php
echo $kategori == 'Promo'
? 'active-filter'
: '';
?>">

Promo

</a>

</div>
</div>

<!-- MENU GRID -->

<div class="menu-grid" id="menuGrid">
    <!-- MENU NOT FOUND -->



<div

id="menuNotFound"

class="empty-menu"

style="display:none;">



<i class="bi bi-search"></i>



<h3>Menu Tidak Ditemukan</h3>



<p>

Tidak ada menu yang sesuai pencarian

</p>



</div>

<?php if(mysqli_num_rows($menu) > 0){ ?>

<?php while($m = mysqli_fetch_array($menu)){ ?>

<div
class="menu-card menu-item"
data-name="<?php echo strtolower($m['nama_menu']); ?>">

<div class="menu-image">

<img
src="../assets/img/<?php echo $m['gambar']; ?>"
alt="<?php echo $m['nama_menu']; ?>"
onerror="this.src='../assets/img/no-image.png'">

<div class="menu-overlay"></div>

<?php if($m['stok'] <= 0){ ?>

<div class="menu-alert out">

<i class="bi bi-x-circle-fill"></i>

Stok Habis

</div>

<?php }elseif($m['stok'] <= 5){ ?>

<div class="menu-alert low">

<i class="bi bi-exclamation-triangle-fill"></i>

Stok Menipis

</div>

<?php } ?>

</div>

<div class="menu-body">

<div class="menu-header">

<div>

<h4>
<?php echo $m['nama_menu']; ?>
</h4>

<span class="menu-category-badge">
<?php echo $m['nama_kategori']; ?>
</span>

</div>
<div class="menu-price">

Rp<?php
echo number_format($m['harga']);
?>

</div>

</div>

<p class="menu-desc">

Menu favorit pelanggan Kedai Maung Boba

</p>

<div class="menu-stock-row">

<div class="stock-info">

<i class="bi bi-box-seam"></i>

<span>
Stok:
<b><?php echo $m['stok']; ?></b>
</span>

</div>

<div class="menu-id">

#<?php echo $m['id_menu']; ?>

</div>

</div>

<div class="menu-action">

<a
href="edit_menu.php?id=<?php echo $m['id_menu']; ?>"
class="btn-edit-menu">

<i class="bi bi-pencil-square"></i>

Edit

</a>

<a
href="../process/hapus_menu.php?id=<?php echo $m['id_menu']; ?>"
class="btn-delete-menu btn-hapus">

<i class="bi bi-trash3"></i>

Hapus

</a>

</div>

</div>

</div>

<?php } ?>

<?php }else{ ?>

<div class="empty-menu">

<i class="bi bi-cup-hot"></i>

<h3>Belum Ada Menu</h3>

<p>
Silakan tambah menu baru
</p>

<a
href="tambah_menu.php"
class="add-menu-btn">

Tambah Menu

</a>

</div>

<?php } ?>

</div>
</div>
<!-- END MAIN CONTENT -->

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

<a
href="menu.php"
class="active">

<i class="bi bi-cup-straw"></i>

<span>Menu</span>

</a>

<a href="laporan.php">

<i class="bi bi-grid"></i>

<span>Laporan</span>

</a>

</div>

<!-- SIDEBAR MOBILE -->

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

<!-- SWEET ALERT -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SUCCESS EDIT -->

<?php if(isset($_GET['success'])){ ?>

<script>

Swal.fire({

icon:'success',

title:'Berhasil',

text:'Data menu berhasil diperbarui',

confirmButtonColor:'#111827',

timer:2000,

showConfirmButton:false

});

</script>

<?php } ?>

<!-- SUCCESS TAMBAH -->

<?php if(isset($_GET['tambah'])){ ?>

<script>

Swal.fire({

icon:'success',

title:'Menu Ditambahkan',

text:'Menu baru berhasil ditambahkan',

confirmButtonColor:'#111827',

timer:2000,

showConfirmButton:false

});

</script>

<?php } ?>

<!-- SUCCESS HAPUS -->

<?php if(isset($_GET['hapus'])){ ?>

<script>

Swal.fire({

icon:'success',

title:'Menu Dihapus',

text:'Data menu berhasil dihapus',

confirmButtonColor:'#111827',

timer:2000,

showConfirmButton:false

});

</script>

<?php } ?>

<script>

const btnHapus =
document.querySelectorAll(
'.btn-hapus'
);

btnHapus.forEach(btn => {

btn.addEventListener(
'click',
function(e){

e.preventDefault();

const link =
this.getAttribute('href');

const namaMenu =
this.closest('.menu-card')
.querySelector('h4')
.innerText;

Swal.fire({

title:'Hapus Menu?',

text: namaMenu + ' akan dihapus',

icon:'warning',

showCancelButton:true,

confirmButtonColor:'#111827',

cancelButtonColor:'#dc2626',

confirmButtonText:'Ya, Hapus',

cancelButtonText:'Batal'

}).then((result)=>{

if(result.isConfirmed){

window.location = link;

}

});

}

);

});

</script>

<!-- SEARCH MENU -->

<script>

const searchInput =
document.getElementById(
'searchMenu'
);

if(searchInput){

searchInput.addEventListener(
'keyup',
function(){

const keyword =
this.value.toLowerCase();

const items =
document.querySelectorAll(
'.menu-item'
);

const notFound =
document.getElementById(
'menuNotFound'
);

let visible = 0;

items.forEach(item=>{

const nama =
item.dataset.name;

if(nama.includes(keyword)){

item.style.display='';

visible++;

}else{

item.style.display='none';

}   

});

if(visible === 0){

notFound.style.display =
'block';

}else{

notFound.style.display =
'none';

}

}

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