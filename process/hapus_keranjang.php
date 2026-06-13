<?php
session_start();

/* ======================
VALIDASI ID
====================== */

if(!isset($_GET['id'])){

    header(
    "Location: ../customer/index.php"
    );

    exit;
}

$id = (int)$_GET['id'];

/* ======================
SESSION KERANJANG
====================== */

if(isset($_SESSION['keranjang'])){

    foreach(
    $_SESSION['keranjang']
    as $key => $item
    ){

        if($item['id_menu'] == $id){

            unset(
            $_SESSION['keranjang'][$key]
            );

            break;
        }

    }

    /* ======================
    RESET INDEX ARRAY
    ====================== */

    $_SESSION['keranjang'] =
    array_values(
    $_SESSION['keranjang']
    );

}

/* ======================
REDIRECT
====================== */

header(
"Location: ../customer/index.php#cart-area"
);

exit;
?>