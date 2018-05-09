
<?php
include 'mysql_lib.php';
$host     = 'localhost';
$database = 'db_karyawan';
$username = 'root';
$password = '';

mysql_connect( $host, $username, $password ) or die("Koneksi Gagal !" . mysql_error());
mysql_select_db( 'db_karyawan' ) or die("Database tidak ada !" . mysql_error());


define( 'URL', 'http://localhost/karyawan' );

$option = isset( $_GET['option'] ) ? $_GET['option'] : '';
$action = isset( $_POST['action'] ) ? $_POST['action'] : '';

?>