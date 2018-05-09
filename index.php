<?php
error_reporting(0);
session_start();

require( dirname(__FILE__).'/fungsi.php' );

if( $action == 'Simpan Data Karyawan' ) { simpan_data_karyawan();} 
elseif( $action == 'Ubah Data Karyawan' ) { update_data_karyawan(); }
elseif( $option == 'delete-karyawan' ) { hapus_data_karyawan(); }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
APLIKASI DATA KARYAWAN
</title>
<script type="text/javascript">
function hapus(id){
	konfirmasi = confirm('Apakah Anda yakin ingin menghapus data karyawan dengan NIK: '+id+' ?' );
	if( konfirmasi == true ) return true;
	else return false;
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/gaya.css" media="all" />
</head>

<body>
<div class="atas">
	<div class="logo">Aplikasi Data Karyawan</div>
</div>

<div class="bungkus">
	<div class="kiri">
		<div class="box">
			<h1>Menu Utama</h1>
			<ul id="urut">
				<?php
				if($option == '') { echo "<li><a href=\"".URL."/\" class=\"active\">Beranda</a></li>\n"; }
				else { echo "<li><a href=\"".URL."/\">Beranda</a></li>\n"; }
				if($option == 'tambah-karyawan') { echo "<li><a href=\"".URL."/?option=tambah-karyawan\" class=\"active\">Tambah Data Karyawan</a></li>\n"; }
				else{ echo "<li><a href=\"".URL."/?option=tambah-karyawan\">Tambah Data Karyawan</a></li>\n"; }
				if($option == 'data-karyawan' || $option == 'detail-karyawan' || $option == 'edit-karyawan') { echo "<li><a href=\"".URL."/?option=data-karyawan\" class=\"active\">Data Karyawan</a></li>\n"; }
				else{ echo "<li><a href=\"".URL."/?option=data-karyawan\">Data Karyawan</a></li>\n"; }
				if($option == '') { echo "<li><a href=\"".URL."/login.php\" class=\"active\">Login</a></li>\n"; }
				else{ echo "<li><a href=\"".URL."/login.php\">Login</a></li>\n"; }
				
				?>
			</ul>
		</div>
	</div>	
	
	<div class="kanan">
		<?php
		$nik = isset($_GET['nik']) ? $_GET['nik'] : '';
		if( $option == 'tambah-karyawan' ) { tambah_data_karyawan(); }
		elseif( $option == 'data-karyawan' ) { tampilkan_karyawan(); }
		elseif( $option == 'edit-karyawan' ) { ubah_data_karyawan(); }
		elseif( $option == 'detail-karyawan') { detail_karyawan($nik); }
		else {
			echo "<div class=\"box\">\n";
			echo "<h1>APLIKASI DATA KARYAWAN </h1>";
			echo "<p>Selamat datang di Aplikasi Data Karyawan</p>";
			echo "<p>YUSUF MULYADI</p>";
			echo "<p>12152192</p>";
			echo "<p><img src=\"".URL."/gambar.jpg\" align=\"left\" width=\"120\" height=\"150\" class=\"img\">Aplikasi ini dibuat untuk memenuhi salah satu tugas <b> Web Programming 2 </b>.</p>";
			echo "<p class=\"footer\">All Rights Reserved | Copyrights &trade; - ".date("Y")." | View more on: <a href=\"http://blizze.wordpress.com\">Blizze@Wordpress</a></p>";
			echo "</div>\n";
		}
		
		?>
	</div>
	<div class="clear"></div>

</div>

</body>
</html>
