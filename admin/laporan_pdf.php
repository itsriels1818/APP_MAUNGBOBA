<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';
require('../library/fpdf/fpdf.php');

$filter = $_GET['filter'] ?? 'hari';

if($filter == 'hari'){

    $where = "DATE(tanggal)=CURDATE()";
    $judul = "Laporan Hari Ini";

}elseif($filter == 'minggu'){

    $where = "YEARWEEK(tanggal,1)=YEARWEEK(CURDATE(),1)";
    $judul = "Laporan Minggu Ini";

}elseif($filter == 'bulan'){

    $where = "
    MONTH(tanggal)=MONTH(CURDATE())
    AND YEAR(tanggal)=YEAR(CURDATE())
    ";

    $judul = "Laporan Bulan Ini";

}else{

    $where = "
    YEAR(tanggal)=YEAR(CURDATE())
    ";

    $judul = "Laporan Tahun Ini";

}

$query = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE $where
ORDER BY tanggal DESC
");

$totalQuery = mysqli_query($conn,"
SELECT SUM(total_harga) as total
FROM pesanan
WHERE $where
");

$totalData = mysqli_fetch_assoc($totalQuery);

$pdf = new FPDF('L','mm','A4');

$pdf->AddPage();

/* HEADER */

$pdf->SetFont('Arial','B',18);

$pdf->Cell(
0,
10,
'KEDAI MAUNG BOBA',
0,
1,
'C'
);

$pdf->SetFont('Arial','',12);

$pdf->Cell(
0,
8,
$judul,
0,
1,
'C'
);

$pdf->Cell(
0,
8,
'Tanggal Cetak : '.date('d-m-Y H:i:s'),
0,
1,
'C'
);

$pdf->Ln(5);

/* TOTAL */

$pdf->SetFont('Arial','B',11);

$pdf->Cell(
0,
8,
'Total Pendapatan : Rp '.number_format($totalData['total']),
0,
1
);

$pdf->Ln(3);

/* HEADER TABEL */

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,8,'No',1,0,'C');
$pdf->Cell(25,8,'ID',1,0,'C');
$pdf->Cell(60,8,'Nama Pemesan',1,0,'C');
$pdf->Cell(55,8,'Tanggal',1,0,'C');
$pdf->Cell(45,8,'Total Harga',1,0,'C');
$pdf->Cell(45,8,'Status',1,1,'C');

/* DATA */

$pdf->SetFont('Arial','',10);

$no = 1;

while($row = mysqli_fetch_assoc($query)){

    $pdf->Cell(
        15,
        8,
        $no++,
        1,
        0,
        'C'
    );

    $pdf->Cell(
        25,
        8,
        '#'.$row['id_pesanan'],
        1
    );

    $pdf->Cell(
        60,
        8,
        $row['nama_pemesan'],
        1
    );

    $pdf->Cell(
        55,
        8,
        date(
            'd-m-Y H:i',
            strtotime($row['tanggal'])
        ),
        1
    );

    $pdf->Cell(
        45,
        8,
        'Rp '.number_format(
            $row['total_harga']
        ),
        1,
        0,
        'R'
    );

    $pdf->Cell(
        45,
        8,
        ucfirst(
            $row['status_pesanan']
        ),
        1,
        1,
        'C'
    );

}

/*
DOWNLOAD LANGSUNG
*/

$pdf->Output(
'D',
'Laporan_Kedai_Maung_Boba.pdf'
);

exit;

