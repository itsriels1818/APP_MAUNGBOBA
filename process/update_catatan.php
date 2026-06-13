<?php
session_start();

/* ======================
VALIDASI INPUT
====================== */

if(
!isset($_POST['id'])
||
!isset($_POST['catatan'])
){

    header(
    "Location: ../customer/index.php"
    );

    exit;
}

$id = (int)$_POST['id'];

$catatan =
trim($_POST['catatan']);

/* ======================
BATASI PANJANG CATATAN
====================== */

if(strlen($catatan) > 200){

    $catatan =
    substr($catatan,0,200);
}

/* ======================
SESSION KERANJANG
====================== */

if(isset($_SESSION['keranjang'])){

    foreach(
    $_SESSION['keranjang']
    as $key => $item
    ){

        if($item['id_menu'] == $id){

            $_SESSION['keranjang'][$key]['catatan']
            = $catatan;

            break;
        }

    }

}

/* ======================
REDIRECT
====================== */

header(
"Location: ../customer/index.php#cart-area"
);

exit;
?>