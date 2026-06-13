<?php

session_start();

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

require_once __DIR__ . '/../config/koneksi.php';

$search = isset($_GET['search'])
? mysqli_real_escape_string(
$conn,
$_GET['search']
)
: '';

$minuman = mysqli_query($conn,"
SELECT * FROM menu
JOIN kategori
ON menu.id_kategori = kategori.id_kategori
WHERE nama_kategori='Minuman'
AND status='tersedia'
AND nama_menu LIKE '%".$search."%'
");

$jumlah_minuman = mysqli_num_rows($minuman);

$makanan = mysqli_query($conn,"
SELECT * FROM menu
JOIN kategori
ON menu.id_kategori = kategori.id_kategori
WHERE nama_kategori='Makanan'
AND status='tersedia'
AND nama_menu LIKE '%".$search."%'
");

$jumlah_makanan = mysqli_num_rows($makanan);

$jumlah_keranjang = isset($_SESSION['keranjang'])
? count($_SESSION['keranjang'])
: 0;

$total_produk =
$jumlah_minuman + $jumlah_makanan;
$statusPesanan = '';

if(isset($_SESSION['antrian'])){

$nomor =
$_SESSION['antrian']['nomor'];

$qStatus = mysqli_query($conn,"
SELECT status_pesanan
FROM pesanan
WHERE nomor_antrian='$nomor'
");

$dataStatus =
mysqli_fetch_array($qStatus);

$statusPesanan =
$dataStatus['status_pesanan']
?? 'menunggu';
if($statusPesanan == 'selesai'){

    unset($_SESSION['antrian']);

}

}
require_once __DIR__ . '/header.php';
?>


<div class="mobile-navbar d-lg-none">

<div class="mobile-logo">

<i class="bi bi-cup-hot-fill"></i>

<h5>Kedai Boba</h5>

</div>

<button
class="mobile-cart"
onclick="
document.getElementById('cart-area')
.scrollIntoView({
behavior:'smooth'
});
">

<i class="bi bi-cart3"></i>

<span>
<?php echo $jumlah_keranjang; ?>
</span>

</button>

</div>

<div class="sidebar">

<div>

<div class="brand-box">

<div class="brand-icon">

<i class="bi bi-cup-hot-fill"></i>

</div>

<div>

<h4>Kedai</h4>

<p>Maung Boba</p>

</div>

</div>

<ul class="sidebar-menu">

<li class="active-menu">

<a href="#semua" class="category-link">

<i class="bi bi-grid-fill"></i>
<span>Beranda</span>

</a>

</li>

<li>

<a href="#minuman" class="category-link">

<i class="bi bi-cup-straw"></i>
<span>Minuman</span>

</a>

</li>

<li>

<a href="#makanan" class="category-link">

<i class="bi bi-egg-fried"></i>
<span>Makanan</span>

</a>

</li>

</ul>

<div class="sidebar-footer">

<div class="support-card">

<div class="support-icon">

<i class="bi bi-headset"></i>

</div>

<h6>Butuh Bantuan?</h6>

<p>Hubungi staff cafe</p>

<button
class="btn btn-support"
onclick="
showAlert('Staff kedai akan segera menghampiri')
">

Panggil Staff

</button>

</div>

</div>

</div>

</div>

<div class="main-wrapper">

<div class="content-area">

<div class="topbar">

<div>

<h3>Selamat Datang</h3>

<p>
Nikmati menu favorit terbaik hari ini
</p>

</div>

<div class="top-actions">

<form method="GET">

<div class="search-box">

<i class="bi bi-search"></i>

<input
type="text"
name="search"
id="searchInput"
placeholder="Cari menu"
value="<?php echo $search; ?>">

<button
type="button"
id="searchBtn"
class="search-btn">

Cari

</button>

</div>

</form>

<button
class="cart-button"
onclick="
document.getElementById('cart-area')
.scrollIntoView({
behavior:'smooth'
});
">

<i class="bi bi-cart3"></i>

<span>
<?php echo $jumlah_keranjang; ?>
</span>

</button>

</div>

</div>

<div class="hero-banner"
id="semua">

<div class="hero-overlay"></div>

<div class="hero-content">

<h1>
Fresh Boba Drink
</h1>

<p>
Pesan langsung dari meja Anda tanpa antre.
</p>

</div>

</div>

<div class="section-header mt-5"
id="minuman">

<h4>Menu Minuman</h4>

</div>

<div class="row g-4">

<?php while($d = mysqli_fetch_array($minuman)){ ?>

<div class="col-xl-3 col-lg-4 col-md-6 col-6">

<div class="product-card">

<div class="product-image">

<img src="../assets/img/<?php echo htmlspecialchars($d['gambar']); ?>">

</div>

<div class="product-body">

<h6>
<?php echo $d['nama_menu']; ?>
</h6>

<p class="product-desc">
Fresh premium drink
</p>

<div class="product-footer-area">

<h5>
Rp <?php echo number_format($d['harga']); ?>
</h5>
<?php

$bolehPesan = true;

if(isset($_SESSION['antrian'])){

    if(
        $statusPesanan == 'menunggu'
        || $statusPesanan == 'diproses'
    ){
        $bolehPesan = false;
    }

}

if($d['stok'] > 0 && $bolehPesan){

?>

<small class="text-success d-block mb-2">
Stok: <?php echo $d['stok']; ?>
</small>

<button
class="add-btn"
data-bs-toggle="modal"
data-bs-target="#cartModal<?php echo $d['id_menu']; ?>">
<i class="bi bi-plus-lg"></i>
</button>

<?php } else { ?>

<small class="text-danger fw-bold d-block mb-2">

<?php
if(!$bolehPesan){
echo "Pesanan Belum Selesai";
}else{
echo "Stok Habis";
}
?>

</small>

<button
class="add-btn disabled-btn"
disabled>
<i class="bi bi-lock-fill"></i>
</button>

<?php } ?>




</div>

</div>

</div>

</div>

<?php } ?>

</div>
<div class="section-header mt-5"
id="makanan">

<h4>Menu Makanan</h4>

</div>

<div class="row g-4">

<?php while($m = mysqli_fetch_array($makanan)){ ?>

<div class="col-xl-3 col-lg-4 col-md-6 col-6">

<div class="product-card">

<div class="product-image">
<img
src="../assets/img/<?php echo htmlspecialchars($m['gambar']); ?>">

</div>

<div class="product-body">

<h6>
<?php echo $m['nama_menu']; ?>
</h6>

<p class="product-desc">
Best seller menu
</p>

<div class="product-footer-area">

<h5>
Rp <?php echo number_format($m['harga']); ?>
</h5>

<?php
$bolehPesanMakanan = true;

if(isset($_SESSION['antrian'])){

    if(
        $statusPesanan == 'menunggu'
        || $statusPesanan == 'diproses'
    ){
        $bolehPesanMakanan = false;
    }

}

if($m['stok'] > 0 && $bolehPesanMakanan){
?>

<small class="text-success d-block mb-2">

Stok:
<?php echo $m['stok']; ?>

</small>

<button
class="add-btn"
data-bs-toggle="modal"
data-bs-target="#foodModal<?php echo $m['id_menu']; ?>">

<i class="bi bi-plus-lg"></i>

</button>

<?php } else { ?>

<small class="text-danger fw-bold d-block mb-2">

<?php
if(!$bolehPesanMakanan){
echo "Pesanan Belum Selesai";
}else{
echo "Stok Habis";
}
?>

</small>

<button
class="add-btn disabled-btn"
disabled>

<i class="bi bi-lock-fill"></i>

</button>

<?php } ?>



</div>

</div>

</div>

</div>

<?php } ?>

</div>

<footer class="footer-area">

<div>

<h6>Kedai Maung Boba</h6>

<p>Sistem QR Ordering</p>

</div>

</footer>

</div>

<div class="rightbar">
<!-- QUEUE -->

<div class="queue-card">

<div class="queue-head">

<p>Nomor Antrian</p>

<span class="queue-status">

<?php
echo isset($_SESSION['antrian'])
? ucfirst($statusPesanan)
: 'Belum Checkout';
?>

</span>

</div>

<h1 class="queue-number">

<?php
echo isset($_SESSION['antrian'])
? sprintf('%03d',$_SESSION['antrian']['nomor'])
: '---';
?>

</h1>

<p class="queue-text">

<?php if(isset($_SESSION['antrian'])){ ?>

Pesanan atas nama

<b>

<?php
echo $_SESSION['antrian']['nama'];
?>

</b>

sedang diproses

<?php } else { ?>

Silahkan checkout untuk mendapatkan nomor antrian.

<?php } ?>

</p>

<!-- <button
class="btn btn-sm btn-dark mt-3 w-100"
id="detailBtn"
data-bs-toggle="modal"
data-bs-target="#detailModal"
style="
display:
<?php
echo isset($_SESSION['antrian'])
? 'block'
: 'none';
?>;
">

<i class="bi bi-receipt"></i>

Lihat Detail Pesanan

</button> -->

</div>

<div class="cart-card"
id="cart-area">

<div class="cart-head">

<h5>Keranjang</h5>

<span>
<?php echo $jumlah_keranjang; ?>
</span>

</div>

<?php
if(isset($_SESSION['keranjang'])
&& count($_SESSION['keranjang']) > 0){
?>

<div class="cart-items">

<?php

$total = 0;

foreach($_SESSION['keranjang'] as $item){

$subtotal =
$item['harga'] * $item['qty'];

$total += $subtotal;
?>

<div class="cart-item">

<img
src="../assets/img/<?php echo htmlspecialchars($item['gambar']); ?>">

<div class="cart-info">

<h6>
<?php echo $item['nama_menu']; ?>
</h6>

<p>
Rp <?php echo number_format($item['harga']); ?>
</p>
<?php if(!empty($item['catatan'])){ ?>

<small class="text-secondary d-block mt-1">

Catatan:
<?php echo htmlspecialchars($item['catatan']); ?>

</small>

<?php } ?>

<button
class="btn btn-sm btn-light mt-2"
data-bs-toggle="modal"
data-bs-target="#editNoteModal<?php echo $item['id_menu']; ?>">

<i class="bi bi-pencil-square"></i>

Edit Catatan

</button>
<div class="cart-action">

<button
class="cart-qty-btn qty-update"
data-id="<?php echo $item['id_menu']; ?>"
data-aksi="minus">

-

</button>

<span class="cart-qty">

<?php echo $item['qty']; ?>

</span>

<button
class="cart-qty-btn qty-update"
data-id="<?php echo $item['id_menu']; ?>"
data-aksi="plus">

+

</button>

<a
href="../process/hapus_keranjang.php?id=<?php echo $item['id_menu']; ?>"
class="delete-cart">

<i class="bi bi-trash3"></i>

</a>

</div>

</div>

</div>

<?php } ?>

</div>

<?php
$totalItem = 0;

foreach($_SESSION['keranjang'] as $item){
    $totalItem += $item['qty'];
}
?>

<div class="subtotal-box">

<p>
<?php echo $totalItem; ?> Item
</p>

<h5>
Rp <?php echo number_format($total); ?>
</h5>

</div>

<div class="mb-3 mt-3">

<input
type="text"
id="nama_pemesan"
class="form-control"
placeholder="Nama Pemesan"
value="<?php echo isset($_SESSION['nama_pemesan']) ? $_SESSION['nama_pemesan'] : ''; ?>">

</div>
<?php
if(
isset($_SESSION['antrian'])
&& $statusPesanan != 'selesai'
){
?>

<div class="alert alert-warning text-center mb-3">

Pesanan Anda masih
<b><?php echo ucfirst($statusPesanan); ?></b>

Silakan tunggu hingga selesai untuk memesan kembali.

</div>

<?php } ?>
<?php
if(
isset($_SESSION['antrian'])
&& $statusPesanan != 'selesai'
){
?>

<button
class="btn checkout-btn disabled w-100"
disabled>

Pesanan Masih Diproses

</button>

<?php }else{ ?>

<button
class="btn checkout-btn active"
id="checkoutBtn">

Checkout

</button>

<?php } ?>

<?php } else { ?>

<div class="empty-cart">

<div class="empty-cart-icon">

<i class="bi bi-bag"></i>

</div>

<h6>Keranjang Kosong</h6>

<p>
Tambahkan menu favoritmu
</p>

</div>

<?php } ?>

</div>

</div>

</div>
<?php mysqli_data_seek($minuman,0); ?>

<?php while($d = mysqli_fetch_array($minuman)){ ?>

<div class="modal fade"
id="cartModal<?php echo $d['id_menu']; ?>"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content custom-modal">

<div class="modal-body p-0">

<button
type="button"
class="custom-close"
data-bs-dismiss="modal">

<i class="bi bi-x-lg"></i>

</button>

<div class="row g-0">

<div class="col-lg-5">

<div class="modal-image">

<img
src="../assets/img/<?php echo $d['gambar']; ?>">

</div>

</div>

<div class="col-lg-7">

<div class="modal-detail">

<h3>
<?php echo $d['nama_menu']; ?>
</h3>

<p class="modal-desc">
Fresh premium drink
</p>

<h4>
Rp <?php echo number_format($d['harga']); ?>
</h4>

<form
action="../process/tambah_keranjang.php"
method="POST"
class="add-cart-form">

<input
type="hidden"
name="id"
value="<?php echo $d['id_menu']; ?>">

<label class="mb-2">
Jumlah
</label>

<div class="qty-wrapper">

<button
type="button"
class="qty-btn minus">

-

</button>

<input
type="number"
name="qty"
value="1"
min="1"
class="qty-input">

<button
type="button"
class="qty-btn plus">

+

</button>

</div>

<textarea
name="catatan"
class="form-control custom-note"
placeholder="Catatan"></textarea>

<button
type="submit"
class="btn modal-cart-btn">

Tambah ke Keranjang

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php } ?>


<?php mysqli_data_seek($makanan,0); ?>

<?php while($m = mysqli_fetch_array($makanan)){ ?>

<div class="modal fade"
id="foodModal<?php echo $m['id_menu']; ?>"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content custom-modal">

<div class="modal-body p-0">

<button
type="button"
class="btn-close custom-close"
data-bs-dismiss="modal">
</button>

<div class="row g-0">

<div class="col-lg-5">

<div class="modal-image">

<img
src="../assets/img/<?php echo $m['gambar']; ?>">

</div>

</div>

<div class="col-lg-7">

<div class="modal-detail">

<h3>
<?php echo $m['nama_menu']; ?>
</h3>

<p class="modal-desc">
Best seller menu
</p>

<h4>
Rp <?php echo number_format($m['harga']); ?>
</h4>

<form
action="../process/tambah_keranjang.php"
method="POST"
class="add-cart-form">

<input
type="hidden"
name="id"
value="<?php echo $m['id_menu']; ?>">

<label class="mb-2">
Jumlah
</label>

<div class="qty-wrapper">

<button
type="button"
class="qty-btn minus">

-

</button>

<input
type="number"
name="qty"
value="1"
min="1"
class="qty-input">

<button
type="button"
class="qty-btn plus">

+

</button>

</div>

<textarea
name="catatan"
class="form-control custom-note"
placeholder="Catatan"></textarea>

<button
type="submit"
class="btn modal-cart-btn">

Tambah ke Keranjang

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php } ?>
	

<?php
if($search != '' && $total_produk == 0){
?>

<div class="modal fade"
id="searchModal"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content border-0 rounded-4">

<div class="modal-body text-center p-5">

<i class="bi bi-search"
style="
font-size:60px;
color:#7b4f32;
"></i>

<h4 class="mt-3">
Menu Tidak Ditemukan
</h4>

<p class="text-secondary">

Menu
<b><?php echo $search; ?></b>
tidak tersedia

</p>

<button
class="btn btn-dark px-4 rounded-4"
onclick="
window.location.href='index.php'
">

Kembali

</button>

</div>

</div>

</div>

</div>



<?php } ?>


<?php if(isset($_SESSION['alert'])){ ?>

<div class="custom-alert">

<i class="bi bi-check-circle-fill"></i>

<?php
echo $_SESSION['alert'];
unset($_SESSION['alert']);
?>

</div>

<?php } ?>

<div class="modal fade" id="detailModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">

                <h5 class="modal-title">
                    Detail Pesanan
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div id="detailPesanan">

                <?php if(isset($_SESSION['antrian'])){ ?>

                    <div class="mb-3">

                        <b>Nama Pemesan</b>
                        <br>

                        <?php
                        echo $_SESSION['antrian']['nama'];
                        ?>

                    </div>

                    <div class="mb-3">

                        <b>Nomor Antrian</b>
                        <br>

                        <?php
                        echo $_SESSION['antrian']['nomor'];
                        ?>

                    </div>

                    <div class="mb-3">

                        <b>Status</b>
                        <br>

                        <span id="statusDetail">
                            <?= ucfirst($statusPesanan); ?>
                        </span>

                    </div>

                    <hr>

                    <?php
                    if(isset($_SESSION['antrian']['items'])){

                        foreach($_SESSION['antrian']['items'] as $item){
                    ?>

                    <div class="detail-item">

                        <div class="detail-left">

                            <img
                                src="../assets/img/<?php echo htmlspecialchars($item['gambar']); ?>"
                                style="
                                width:55px;
                                height:55px;
                                object-fit:cover;
                                border-radius:12px;
                                ">

                            <div class="detail-info">

                                <b>
                                    <?php
                                    echo $item['nama_menu'];
                                    ?>
                                </b>

                                <br>

                                <small>
                                    Qty:
                                    <?php echo $item['qty']; ?>
                                </small>

                                <?php if(!empty($item['catatan'])){ ?>

                                    <br>

                                    <small class="text-secondary">

                                        Catatan:
                                        <?php
                                        echo htmlspecialchars(
                                            $item['catatan']
                                        );
                                        ?>

                                    </small>

                                <?php } ?>

                            </div>

                        </div>

                        <div class="detail-price">

                            Rp
                            <?php
                            echo number_format(
                                $item['harga'] * $item['qty']
                            );
                            ?>

                        </div>

                    </div>

                    <?php
                        }
                    }
                    ?>

                    <hr>

                    <div class="detail-total">

                        <span>Total Pesanan</span>

                        <h5>

                            Rp

                            <?php
                            echo number_format(
                                $_SESSION['antrian']['total']
                            );
                            ?>

                        </h5>

                    </div>

                <?php }else{ ?>

                    <div class="text-center">

                        Belum ada pesanan

                    </div>

                <?php } ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php if(isset($_SESSION['antrian'])){ ?>

<button
    class="btn btn-dark position-fixed"
    style="
    bottom:20px;
    right:20px;
    z-index:1000;
    border-radius:16px;
    padding:12px 18px;
    "
    data-bs-toggle="modal"
    data-bs-target="#detailModal">

    <i class="bi bi-receipt"></i>
    Detail Pesanan

</button>

<?php } ?>


<?php
if(isset($_SESSION['keranjang'])):

foreach($_SESSION['keranjang'] as $item):
?>

<div class="modal fade"
id="editNoteModal<?php echo $item['id_menu']; ?>"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content custom-modal border-0">

<div class="modal-body p-4">

<h5 class="mb-3">

Edit Catatan

</h5>

<form
action="../process/update_catatan.php"
method="POST">

<input
type="hidden"
name="id"
value="<?php echo $item['id_menu']; ?>">

<textarea
name="catatan"
class="form-control custom-note"><?php
echo htmlspecialchars(
$item['catatan']
);
?></textarea>

<button
class="btn modal-cart-btn mt-3">

Simpan Catatan

</button>

</form>

</div>

</div>

</div>

</div>

<?php
endforeach;
endif;
?>
<?php
if($search != '' && $total_produk == 0){
?>



<?php } ?>


<?php if(isset($_SESSION['alert'])){ ?>



<?php
unset($_SESSION['alert']);
} ?>
<script>
const menuLinks =
document.querySelectorAll(
'.sidebar-menu .category-link'
);

menuLinks.forEach(link => {

    link.addEventListener(
    'click',
    function(){

        document
        .querySelectorAll(
        '.sidebar-menu li'
        )
        .forEach(li => {

            li.classList.remove(
            'active-menu'
            );

        });

        this.parentElement
        .classList.add(
        'active-menu'
        );

    });

});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<audio id="notifSelesai" preload="auto">
    <source src="../audio/pesanan-siap.mp3" type="audio/mpeg">
</audio>

<script>

let statusSebelumnya = null;

// Minta izin notifikasi browser
if ("Notification" in window) {

    Notification.requestPermission();

}

// Notifikasi Browser
function showNotif(title, body){

    if(!("Notification" in window)){
        return;
    }

    if(Notification.permission === "granted"){

        new Notification(title,{
            body: body,
            icon: "../assets/img/logo.png"
        });

    }

}

// Update tampilan status
function updateStatusUI(status){

    // Status di kartu antrian
    const queueStatus =
    document.querySelector('.queue-status');

    if(queueStatus){

        queueStatus.innerText =
        status.toUpperCase();

    }

    // Status di modal detail
    const detailStatus =
    document.getElementById('statusDetail');

    if(detailStatus){

        detailStatus.innerText =
        status.charAt(0).toUpperCase() +
        status.slice(1);

    }

}

// Cek status realtime
function cekStatusPesanan(){

    fetch('ajax/cek_status.php?t=' + Date.now())

    .then(res => res.json())

    .then(data => {

        let status = data.status;

        console.log(
            'Status Lama:',
            statusSebelumnya,
            '| Status Baru:',
            status
        );

        if(status === 'tidak_ada'){
            return;
        }

        // Pertama kali load
        if(statusSebelumnya === null){

            statusSebelumnya = status;

            updateStatusUI(status);

            return;

        }

        // MENUNGGU -> DIPROSES
        if(
            statusSebelumnya === 'menunggu'
            &&
            status === 'diproses'
        ){

            Swal.fire({
                icon:'info',
                title:'👨‍🍳 Pesanan Diproses',
                text:'Pesanan kamu sedang dibuat.'
            });

            showNotif(
                '👨‍🍳 Pesanan Diproses',
                'Pesanan kamu sedang dibuat'
            );

        }

        // DIPROSES -> SELESAI
        if(
            statusSebelumnya === 'diproses'
            &&
            status === 'selesai'
        ){

            const audio =
            document.getElementById('notifSelesai');

            if(audio){

                audio.currentTime = 0;

                audio.play()
                .catch(()=>{});

            }

            showNotif(
                '🎉 Pesanan Siap!',
                'Silakan ambil pesanan di kasir'
            );

            Swal.fire({
                icon:'success',
                title:'🎉 Pesanan Siap!',
                html:`
                Pesanan kamu sudah selesai dibuat.<br><br>
                <b>Silakan ambil pesanan di kasir.</b>
                `,
                confirmButtonText:'Oke',
                confirmButtonColor:'#8b5a34',
                allowOutsideClick:false
            })

            .then(() => {

                const detail =
                document.getElementById('detailPesanan');

                if(detail){

                    detail.innerHTML = `
                    <div class="text-center py-4">

                        <h4 class="text-success">
                            🎉 Pesanan Selesai
                        </h4>

                        <p>
                            Terima kasih telah memesan.
                        </p>

                        <p>
                            Silakan membuat pesanan baru.
                        </p>

                    </div>
                    `;

                }

                setTimeout(() => {

                    location.reload();

                }, 1000);

            });

        }

        updateStatusUI(status);

        statusSebelumnya = status;

    })

    .catch(err => {

        console.log(err);

    });

}

// Jalankan pertama kali
cekStatusPesanan();

// Jalankan tiap 3 detik
setInterval(
    cekStatusPesanan,
    3000
);

</script>

<?php include 'footer.php'; ?>

