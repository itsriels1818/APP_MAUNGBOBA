<?php

session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/../config/koneksi.php';

/* ======================
AMBIL NAMA
====================== */

$nama = isset($_POST['nama'])
? trim($_POST['nama'])
: '';

$nama = mysqli_real_escape_string(
$conn,
$nama
);

/* ======================
VALIDASI NAMA
====================== */

if($nama == ''){

    echo json_encode([
        "status" => "error",
        "message" => "Nama wajib diisi"
    ]);

    exit;
}

/* ======================
VALIDASI KERANJANG
====================== */

if(
!isset($_SESSION['keranjang'])
|| count($_SESSION['keranjang']) == 0
){

    echo json_encode([
        "status" => "kosong"
    ]);

    exit;
}

/* ======================
TOTAL
====================== */

$total = 0;

foreach($_SESSION['keranjang'] as $item){

    $subtotal =
    $item['harga'] * $item['qty'];

    $total += $subtotal;
}

/* ======================
NOMOR ANTRIAN SEMENTARA
====================== */

$antrian = 0;

/* ======================
KODE PESANAN
====================== */

$kode =
"ORD" . date("YmdHis");

/* ======================
TRANSACTION
====================== */

mysqli_begin_transaction($conn);

try{

    /* INSERT PESANAN */

    $insertPesanan = mysqli_query($conn,"
    INSERT INTO pesanan(
    kode_pesanan,
    tanggal,
    nama_pemesan,
    total_harga,
    status_pesanan,
    nomor_antrian
    )

    VALUES(
    '$kode',
    NOW(),
    '$nama',
    '$total',
    'menunggu',
    '$antrian'
    )
    ");

    if(!$insertPesanan){

        throw new Exception(
        "Gagal insert pesanan"
        );
    }

    $id_pesanan =
    mysqli_insert_id($conn);

    /* ======================
NOMOR ANTRIAN = ID PESANAN
====================== */

$antrian = $id_pesanan;

mysqli_query($conn,"
UPDATE pesanan
SET nomor_antrian='$antrian'
WHERE id_pesanan='$id_pesanan'
");

    /* DETAIL PESANAN */

    foreach($_SESSION['keranjang'] as $item){

        $id_menu =
        (int)$item['id_menu'];

        $qty =
        (int)$item['qty'];

        $subtotal =
        $item['harga'] * $qty;

        $catatan =
        mysqli_real_escape_string(
        $conn,
        $item['catatan']
        );

        /* CEK STOK */

$cekStok = mysqli_query($conn,"
SELECT stok
FROM menu
WHERE id_menu='$id_menu'
FOR UPDATE
");

        $dataStok =
        mysqli_fetch_assoc($cekStok);

        if($dataStok['stok'] < $qty){

            throw new Exception(
            "Stok tidak cukup"
            );

        }

        /* INSERT DETAIL */

        $insertDetail = mysqli_query($conn,"
        INSERT INTO detail_pesanan(
        id_pesanan,
        id_menu,
        qty,
        subtotal,
        catatan
        )

        VALUES(
        '$id_pesanan',
        '$id_menu',
        '$qty',
        '$subtotal',
        '$catatan'
        )
        ");

        if(!$insertDetail){

            throw new Exception(
            "Gagal insert detail"
            );
        }

        /* KURANGI STOK */

        #UPDATE menu
       # SET stok = stok - $qty
        #WHERE id_menu = '$id_menu'
        #");

    }

    mysqli_commit($conn);

    /* SIMPAN NAMA */

    $_SESSION['nama_pemesan'] =
    $nama;

    /* SESSION ANTRIAN */

    $_SESSION['antrian'] = [

        "nomor" => $antrian,
        "nama" => $nama,
        "total" => $total,
        "status" => "Menunggu",
        "items" => $_SESSION['keranjang']

    ];

    /* HAPUS KERANJANG */

    unset($_SESSION['keranjang']);

    echo json_encode([

        "status" => "success",
        "antrian" => $antrian,
        "total" => $total

    ]);

}catch(Exception $e){

    mysqli_rollback($conn);

    echo json_encode([

        "status" => "error",
        "message" => $e->getMessage()

    ]);

}
?>