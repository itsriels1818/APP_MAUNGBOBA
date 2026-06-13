<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';

$filter = $_GET['filter'] ?? 'tahun';

if($filter == 'hari'){

    $where = "DATE(tanggal)=CURDATE()";
    $periode = "Hari Ini";

}elseif($filter == 'minggu'){

    $where = "YEARWEEK(tanggal,1)=YEARWEEK(CURDATE(),1)";
    $periode = "Minggu Ini";

}elseif($filter == 'bulan'){

    $where = "
    MONTH(tanggal)=MONTH(CURDATE())
    AND YEAR(tanggal)=YEAR(CURDATE())
    ";

    $periode = "Bulan Ini";

}else{

    $where = "
    YEAR(tanggal)=YEAR(CURDATE())
    ";

    $periode = "Tahun Ini";

}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Kedai_Maung_Boba.xls");

$query = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE $where
ORDER BY tanggal DESC
");

$total = mysqli_query($conn,"
SELECT SUM(total_harga) as total
FROM pesanan
WHERE $where
");

$totalPendapatan =
mysqli_fetch_assoc($total);
?>

<html>
<head>
<meta charset="UTF-8">
</head>

<body>

<table border="0">

<tr>
<td colspan="6" align="center">
<h2>KEDAI MAUNG BOBA</h2>
</td>
</tr>

<tr>
<td colspan="6" align="center">
Laporan Penjualan <?php echo $periode; ?>
</td>
</tr>

<tr>
<td colspan="6" align="center">
Tanggal Cetak :
<?php echo date('d-m-Y H:i'); ?>
</td>
</tr>

<tr><td colspan="6"></td></tr>

<tr>
<td colspan="4">
<b>Total Pendapatan</b>
</td>

<td colspan="2">
<b>
Rp <?php echo number_format($totalPendapatan['total']); ?>
</b>
</td>
</tr>

<tr><td colspan="6"></td></tr>

</table>

<table border="1">

<tr style="background:#D9EAD3;">

<th>No</th>
<th>ID Pesanan</th>
<th>Nama Pemesan</th>
<th>Tanggal</th>
<th>Total Harga</th>
<th>Status</th>

</tr>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($query)){

?>

<tr>

<td align="center">
<?php echo $no++; ?>
</td>

<td align="center">
#<?php echo $row['id_pesanan']; ?>
</td>

<td>
<?php echo $row['nama_pemesan']; ?>
</td>

<td>
<?php echo date(
'd-m-Y H:i',
strtotime($row['tanggal'])
); ?>
</td>

<td>
Rp <?php echo number_format(
$row['total_harga']
); ?>
</td>

<td align="center">
<?php echo ucfirst(
$row['status_pesanan']
); ?>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>