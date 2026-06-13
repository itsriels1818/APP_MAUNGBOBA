<?php
session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/../config/koneksi.php';

/* ======================
VALIDASI ID
====================== */

if(!isset($_POST['id'])){

    echo json_encode([
        "status" => "error",
        "message" => "ID menu tidak ditemukan"
    ]);

    exit;
}

$id = (int)$_POST['id'];

/* ======================
VALIDASI QTY
====================== */

$qty = isset($_POST['qty'])
? (int)$_POST['qty']
: 1;

if($qty < 1){

    $qty = 1;
}

if($qty > 99){

    $qty = 99;
}

/* ======================
CATATAN
====================== */

$catatan = isset($_POST['catatan'])
? trim($_POST['catatan'])
: '';

$catatan =
mysqli_real_escape_string(
$conn,
$catatan
);

/* ======================
CEK MENU
====================== */

$query = mysqli_query($conn,"
SELECT *
FROM menu
WHERE id_menu='$id'
");

$data = mysqli_fetch_assoc($query);

if(!$data){

    echo json_encode([
        "status" => "error",
        "message" => "Menu tidak ditemukan"
    ]);

    exit;
}

/* ======================
ITEM
====================== */

$item = [

    "id_menu"   => (int)$data['id_menu'],
    "nama_menu" => $data['nama_menu'],
    "harga"     => (int)$data['harga'],
    "gambar"    => $data['gambar'],
    "qty"       => $qty,
    "catatan"   => $catatan

];

/* ======================
SESSION KERANJANG
====================== */

if(!isset($_SESSION['keranjang'])){

    $_SESSION['keranjang'] = [];

}

/* ======================
CEK DUPLIKAT
====================== */

$found = false;

foreach($_SESSION['keranjang'] as $key => $value){

    if(

        $value['id_menu'] == $id
        &&
        trim($value['catatan'])
        == trim($catatan)

    ){

        $_SESSION['keranjang'][$key]['qty']
        += $qty;

        /* MAX 99 */

        if(
        $_SESSION['keranjang'][$key]['qty']
        > 99
        ){

            $_SESSION['keranjang'][$key]['qty']
            = 99;
        }

        $found = true;

    }

}

/* ======================
TAMBAH BARU
====================== */

if(!$found){

    $_SESSION['keranjang'][] = $item;

}

/* ======================
SUCCESS
====================== */

echo json_encode([

    "status" => "success"

]);

exit;
?>