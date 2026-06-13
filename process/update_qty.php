<?php
session_start();

/* ======================
VALIDASI PARAMETER
====================== */

if(
!isset($_GET['id'])
||
!isset($_GET['aksi'])
){

    header(
    "Location: ../customer/index.php"
    );

    exit;
}

$id = (int)$_GET['id'];

$aksi = $_GET['aksi'];

/* ======================
VALIDASI AKSI
====================== */

if(
$aksi != 'plus'
&&
$aksi != 'minus'
){

    header(
    "Location: ../customer/index.php"
    );

    exit;
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

            /* ======================
            PLUS
            ====================== */

            if($aksi == 'plus'){

                $_SESSION['keranjang'][$key]['qty']++;

                /* MAX 99 */

                if(
                $_SESSION['keranjang'][$key]['qty']
                > 99
                ){

                    $_SESSION['keranjang'][$key]['qty']
                    = 99;
                }

            }

            /* ======================
            MINUS
            ====================== */

            if($aksi == 'minus'){

                if(
                $_SESSION['keranjang'][$key]['qty']
                > 1
                ){

                    $_SESSION['keranjang'][$key]['qty']--;

                }

            }

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