<?php

if (!isset($conn)) {
    require_once __DIR__ . '/../../config/koneksi.php';
}

$id_user = $_SESSION['id_user'];

$userLogin = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM users WHERE id_user='$id_user'"
    )
);

?>

<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/../../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$userLogin = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM users WHERE id_user='$id_user'"
    )
);
?>

<div class="sidebar" id="sidebar">

    <div class="sidebar-top">

 

        <div class="close-sidebar" id="closeSidebar">
            <i class="bi bi-x-lg"></i>
        </div>

    </div>

   <div class="sidebar-profile">

<div class="profile-image">

    <?php if(!empty($userLogin['foto'])){ ?>

        <img
            src="../assets/uploads/profil/<?= $userLogin['foto']; ?>"
            alt="Foto Profil"
            style="
                width:100%;
                height:100%;
                object-fit:cover;
                border-radius:50%;
            "
        >

    <?php } else { ?>

        <i class="bi bi-person-fill"></i>

    <?php } ?>

</div>

<div class="profile-info">
    <h4><?= $userLogin['nama_lengkap']; ?></h4>
    <p><?= ucfirst($userLogin['role']); ?></p>
</div>

</div>

    <ul class="sidebar-menu">

        <li>
            <a href="index.php">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="pesanan.php">
                <i class="bi bi-receipt"></i>
                Pesanan
            </a>
        </li>

        <li>
            <a href="menu.php">
                <i class="bi bi-cup-straw"></i>
                Menu
            </a>
        </li>

        <li>
            <a href="stok.php">
                <i class="bi bi-box-seam"></i>
                Stok
            </a>
        </li>

        <li>
            <a href="laporan.php">
                <i class="bi bi-bar-chart"></i>
                Laporan
            </a>
        </li>

        <li>
            <a href="pengaturan.php">
                <i class="bi bi-gear-fill"></i>
                Pengaturan
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">

        <a href="logout.php" class="logout-btn" id="btnLogout">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>

    </div>

</div>