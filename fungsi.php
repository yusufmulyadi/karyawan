<?php
require( dirname(__FILE__).'/config.php' );

function simpan_data_karyawan() {
	$salah = array();
	$dir = "photo";
	
	$nama = mysql_real_escape_string( $_POST['nama'] );
	$alamat = mysql_real_escape_string( $_POST['alamat'] );
	$no_hp = mysql_real_escape_string( $_POST['no_hp'] );
	$nik = mysql_real_escape_string( $_POST['nik'] );
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$status = $_POST['status'];
	$divisi = $_POST['divisi'];
	$filename = $_FILES['photo']['name'];
	$tmp_name = $_FILES['photo']['tmp_name'];
	$filesize = $_FILES['photo']['size'];
	$filetype = $_FILES['photo']['type'];
	
	$image_name = strtolower(str_replace(' ', '-', $filename));
	$image_ext = substr($image_name, strrpos($image_name, '.'));
	$image_ext = str_replace('.', '', $image_ext);
	$image_name = preg_replace("/\.[^.\s]{3,4}$/", "", $image_name);
	$new_image_name = $nik.'.'.$image_ext;
	
	if( empty( $nama ) ) {
		$salah[] = '- Lengkapi Data...';
	}
	if( empty( $alamat ) ) {
		$salah[] = '- Lengkapi Data...';
	}
	if( empty( $no_hp ) ) {
		$salah[] = '- Lengkapi Data...';
	}
	if( empty( $nik ) ) {
		$salah[] = '- Lengkapi Data...';
	}
	
	if( !count( $salah ) ) {
		
		if( mysql_num_rows( mysql_query( "SELECT * FROM karyawan WHERE nik='$nik'" ) ) == 0 ) {
			mysql_query( "INSERT INTO karyawan VALUES( '', '$nik', '$nama', '$alamat', '$no_hp', '$jenis_kelamin', '$status', '$divisi', '$new_image_name')" );
			move_uploaded_file($_FILES['photo']['tmp_name'], $dir . "/" . $new_image_name);
		} else {
			$salah[] = '- nik sudah digunakan...';
		}
	}
	
	if( count( $salah ) ) {
		$_SESSION['pesan']['kesalahan-tambah-data'] = implode( '<br>', $salah );
	}
	
	if( count( $salah ) ) {
		header( "Location: ".URL."/?option=tambah-karyawan" );
	} else {
		header( "Location: ".URL."/?option=data-karyawan" );
	}
	exit;
} 

function update_data_karyawan() {
	$salah = array();	
	$dir = "photo";	
	$nama = mysql_real_escape_string( $_POST['nama'] );
	$alamat = mysql_real_escape_string( $_POST['alamat'] );
	$no_hp = mysql_real_escape_string( $_POST['no_hp'] );
	$nik = mysql_real_escape_string( $_POST['nik'] );
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$status = $_POST['status'];
	$divisi = $_POST['divisi'];
	$filename = $_FILES['photo']['name'];
	$tmp_name = $_FILES['photo']['tmp_name'];
	$filesize = $_FILES['photo']['size'];
	$filetype = $_FILES['photo']['type'];	
	$image_name = strtolower(str_replace(' ', '-', $filename));
	$image_ext = substr($image_name, strrpos($image_name, '.'));
	$image_ext = str_replace('.', '', $image_ext);
	$image_name = preg_replace("/\.[^.\s]{3,4}$/", "", $image_name);
	$new_image_name = $nik.'.'.$image_ext;
	if( empty( $nama ) ) {
		$salah[] = '- Lengkapi Data...';
	}
	if( empty( $alamat ) ) {
		$salah[] = '- Lengkapi Data......';
	}
	if( empty( $no_hp ) ) {
		$salah[] = '- Lengkapi Data......';
	}
	if( empty( $nik ) ) {
		$salah[] = '- Lengkapi Data......';
	}
	if( !count( $salah ) ) {		
		$sql = mysql_fetch_array(mysql_query("SELECT * FROM nik WHERE nik='{$nik}'"));
		$jenis_kelamin = ($jenis_kelamin != '') ? $jenis_kelamin : $sql['jenis_kelamin'];
		$divisi = ($divisi != '') ? $divisi : $sql['divisi'];
		$status = ($status != '') ? $status : $sql['status'];
		$new_image_name = ($filename != '') ? $new_image_name : $sql['photo'];
		mysql_query( "UPDATE karyawan SET nik='$nik', nama='$nama', alamat='$alamat', no_hp='$no_hp', jenis_kelamin='$jenis_kelamin', status='$status', divisi='$divisi', photo='$new_image_name' WHERE nik='$nik'" );
		move_uploaded_file($_FILES['photo']['tmp_name'], $dir . "/" . $new_image_name);
	}
	if( count( $salah ) ) {
		$_SESSION['pesan']['kesalahan-ubah-data'] = implode( '<br>', $salah );
	}
	if( count( $salah ) ) {
		header( "Location: ".URL."/?option=edit-karyawan&nik=$nik" );
	} else {
		header( "Location: ".URL."/?option=data-karyawan" );
	}
	exit;
} 

function hapus_data_karyawan() {
	$dir = "photo";
	$nik = isset( $_GET['nik'] ) ? $_GET['nik'] : '';
	$sql = mysql_fetch_array(mysql_query("SELECT * FROM karyawan WHERE nik='{$nik}'"));
	$ext = substr($sql['photo'], strrpos($sql['photo'], '.'));	
	$ext = str_replace('.', '', $ext);
	if(file_exists("{$dir}/{$nik}.{$ext}")){
		unlink("{$dir}/{$nik}.{$ext}");
	}
	mysql_query( "DELETE FROM karyawan WHERE nik='$nik'" );
	header( "Location: ".URL."/?option=data-karyawan" );
	exit;
}

function cari_terbesar( $nik ) {
	$query = mysql_fetch_array(mysql_query( "SELECT MAX(nik) AS terbesar FROM karyawan" ) );
	$nik = $query['terbesar'];
	if( $nik ) {
		$terbesar = substr( $query['terbesar'], 0, 7 );
		$terbesar++;
	} else {
		$terbesar = 'NIK0001';
	}
	return $terbesar;
}

function tambah_data_karyawan() {
	echo "<div class=\"box\">\n";
	echo "<h1>TAMBAH DATA KARYAWAN</h1>";
	
	if( isset( $_SESSION['pesan']['kesalahan-tambah-data'] ) ) {
		echo "<p class=\"err\"><b>Pesan Kesalahan :</b><br>".$_SESSION['pesan']['kesalahan-tambah-data']."</p>";
		unset( $_SESSION['pesan']['kesalahan-tambah-data'] );
	}
	$nik = cari_terbesar('nik');
	echo "	<form method=\"post\" action=\"\" autocomplete=\"off\" enctype=\"multipart/form-data\">\n";
	echo "		Nik Karyawan:<br><input type=\"text\" name=\"nik\" value=\"{$nik}\"><br>\n";
	echo "		Nama Karyawan:<br><input type=\"text\" name=\"nama\" placeholder=\"Isi nama lengkap karyawan...\"><br>\n";
	echo "		Alamat Karyawan:<br><input type=\"text\" name=\"alamat\" placeholder=\"Isi alamat lengkap karyawan...\"><br>\n";
	echo "		No HP Karyawan:<br><input type=\"text\" name=\"no_hp\" placeholder=\"Isi no hp karyawan...\"><br>\n";
	echo "		Jenis Kelamin:<br><select name=\"jenis_kelamin\"><option value=\"0\" selected\">Pilih jenis kelamin</option>\n";
	echo "			<option value=\"Laki-Laki\">Laki-Laki</option><option value=\"Perempuan\">Perempuan</option>\n";
	echo "		</select><br>\n";
	echo "		Status Menikah:<br><select name=\"status\"><option value=\"0\" selected\">Pilih status pernikahan</option>\n";
	echo "			<option value=\"Menikah\">Menikah</option><option value=\"Lajang\">Lajang</option><option value=\"Bercerai\">Bercerai</option>\n";
	echo "		</select><br>\n";
	echo "		Divisi:<br><select name=\"divisi\"><option value=\"0\" selected\">Pilih divisi</option>\n";
	echo "			<option value=\"SDM\">SDM</option><option value=\"Akuntan\">Akuntan</option><option value=\"Marketing\">Marketing</option><option value=\"HRD\">HRD</option><option value=\"IT\">IT</option>\n";
	echo "		</select><br>\n";
	echo "		Photo Karyawan: &nbsp; <input type=\"file\" name=\"photo\" size=\"90\"><br><br>\n";
	echo "		<input type=\"submit\" name=\"action\" value=\"Simpan Data Karyawan\"><br>\n";
	echo "	</form>\n";
	echo "</div>\n";
}

function ubah_data_karyawan() {
	$nik = isset( $_GET['nik'] ) ? $_GET['nik'] : '';
	$sql = mysql_fetch_array(mysql_query( "SELECT * FROM karyawan WHERE nik='$nik'" ) );

	echo "<div class=\"box\">\n";
	echo "<h1>Ubah Data Karyawan</h1>";
	if( isset( $_SESSION['pesan']['kesalahan-ubah-data'] ) ) {
		echo "<p class=\"err\"><b>Pesan Kesalahan :</b><br>".$_SESSION['pesan']['kesalahan-ubah-data']."</p>";
		unset( $_SESSION['pesan']['kesalahan-ubah-data'] );
	}

	echo "	<form method=\"post\" action=\"\" autocomplete=\"off\" enctype=\"multipart/form-data\">\n";
	echo "		Nik Karyawan:<br><input type=\"text\" name=\"nik\" value=\"{$nik}\"><br>\n";
	echo "		Nama Karyawan:<br><input type=\"text\" name=\"nama\" placeholder=\"Isi nama lengkap karyawan...\"><br>\n";
	echo "		Alamat Karyawan:<br><input type=\"text\" name=\"alamat\" placeholder=\"Isi alamat lengkap karyawan...\"><br>\n";
	echo "		No HP Karyawan:<br><input type=\"text\" name=\"no_hp\" placeholder=\"Isi no hp karyawan...\"><br>\n";
	echo "		Jenis Kelamin:<br><select name=\"jenis_kelamin\"><option value=\"0\" selected\">Pilih jenis kelamin</option>\n";
	echo "			<option value=\"Laki-Laki\">Laki-Laki</option><option value=\"Perempuan\">Perempuan</option>\n";
	echo "		</select><br>\n";
	echo "		Status Menikah:<br><select name=\"status\"><option value=\"0\" selected\">Pilih status pernikahan</option>\n";
	echo "			<option value=\"Menikah\">Menikah</option><option value=\"Lajang\">Lajang</option><option value=\"Bercerai\">Bercerai</option>\n";
	echo "		</select><br>\n";
	echo "		Divisi:<br><select name=\"divisi\"><option value=\"0\" selected\">Pilih divisi</option>\n";
	echo "			<option value=\"SDM\">SDM</option><option value=\"Akuntan\">Akuntan</option><option value=\"Marketing\">Marketing</option><option value=\"HRD\">HRD</option><option value=\"IT\">IT</option>\n";
	echo "		</select><br>\n";
	echo "		<div class=\"edit_photo_box\">\n";
	echo "			<div class=\"photo_box\">\n";
	if(file_exists("photo/{$sql['photo']}")){
		$photo = "<img src=\"".URL."/photo/{$sql['photo']}\" class=\"photo\" alt=\"{$sql['photo']}\">";
	} else {
		$photo = "<img src=\"".URL."/photo/noname.jpg\" class=\"photo\">";
	}
	echo "				{$photo}\n";
	echo "			</div>\n";
	echo "			<div class=\"photo_input\">Photo Karyawan:<br><input type=\"file\" name=\"photo\" size=\"90\"></div>\n";
	echo "			<div class=\"clear\"></div>\n";
	echo "		</div>\n";
	echo "		<input type=\"submit\" name=\"action\" value=\"Ubah Data Karyawan\"><br>\n";
	echo "	</form>\n";
	echo "</div>\n";
}

function tampilkan_karyawan() {
	$jumlah_data_per_halaman = 7;
	if(isset($_GET['page'])){ $nomor_halaman = $_GET['page'];} 
	else { $nomor_halaman = 1; }
	$offset = ($nomor_halaman - 1) * $jumlah_data_per_halaman;		
	$sql = mysql_query( "SELECT * FROM karyawan ORDER BY nik ASC LIMIT $offset,$jumlah_data_per_halaman" );
	$jumlah_data_karyawan = mysql_num_rows(mysql_query("SELECT * FROM karyawan"));	
	echo "<div class=\"box\">\n";
	echo "<h1>Daftar Karyawan</h1>";
	echo "<table border=\"0\">";
	echo "<tr class=\"top_tr\">";
	echo "	<td width=\"40\">Photo</td>\n";
	echo "	<td width=\"150\">Nama</td>\n";
	echo "	<td width=\"150\">Alamat</td>\n";
	echo "	<td width=\"100\">No HP</td>\n";
	echo "	<td width=\"100\">Status</td>\n";
	echo "	<td width=\"100\">Divisi</td>\n";
	echo "	<td width=\"70\">Jenis Kelamin</td>\n";
	echo "	<td width=\"50\">Aksi</td>\n";
	echo "</tr>";	
	if( mysql_num_rows( $sql ) == 0 ) {
		echo "<tr style=\"height:150px; border-bottom:1px dotted #CC780C;\">";
		echo "	<td colspan=\"8\" align=\"center\" style=\"color:#FF0000; \">Belum ada data karyawan saat ini. Silahkan isi data karyawan.<br><a href=\"".URL."/?option=tambah-karyawan\">Klik disini untuk menambah data karyawan</a></td>";
		echo "</tr>";
	} else {
		$a = 0;
		while( $row = mysql_fetch_array( $sql ) ) {
			if( $a == 0 ) { $bg = "#FCFADE"; $a = 1; }
			else{ $bg = "#FCF7AB"; $a = 0; }
			
			if(file_exists("photo/{$row['photo']}")){
				$photo = "<img src=\"".URL."/photo/{$row['photo']}\" class=\"photo\" alt=\"{$row['photo']}\">";
			} else {
				$photo = "<img src=\"".URL."/photo/noname.jpg\" class=\"photo\">";
			}
			echo "<tr bgcolor=\"$bg\" onmouseover=\"bgColor='#FFFF55'\" onmouseout=\"bgColor='$bg'\">";
			echo "	<td align=\"center\">{$photo}</td>";
			echo "	<td><span style=\"font-size:12px; \">NIK: <a href=\"".URL."/?option=detail-karyawan&nik={$row['nik']}\">{$row['nik']}</a></span><br>{$row['nama']}</td>";
			echo "	<td>{$row['alamat']}</td>";
			echo "	<td>{$row['no_hp']}</td>";
			echo "	<td>{$row['status']}</td>";
			echo "	<td>{$row['divisi']}</td>";
			echo "	<td>{$row['jenis_kelamin']}</td>";
			echo "	<td><a href=\"".URL."/?option=edit-karyawan&nik={$row['nik']}\" title=\"Klik untuk mengubah data karyawan\"><img src=\"".URL."/b_edit.png\" alt=\"\"> &nbsp; <a href=\"".URL."/?option=delete-karyawan&nik={$row['nik']}\" onclick=\"return hapus('".$row['nik']."')\" title=\"Klik untuk menghapus data karyawan\"><img src=\"".URL."/b_drop.png\"></a></td>";
			echo "</tr>";
		}		
	}
	echo "</table>";	
	$jumlah_data = mysql_fetch_array( mysql_query("SELECT COUNT(*) AS jumlah FROM karyawan") );
	$total_halaman = ceil($jumlah_data['jumlah'] / $jumlah_data_per_halaman);
	
	echo "<p class=\"paging\">\n";
	echo "Halaman: &nbsp; ";
	$showpage = 0;
	if($nomor_halaman > 1){ echo "<a href=\"".URL."/?option=data-karyawan&page=".($nomor_halaman-1)."\">&larr; Prev</a>\n"; }
	for($page = 1; $page <= $total_halaman; $page++){
		if((($page >= $nomor_halaman - 3) && ($page <= $nomor_halaman + 3)) || ($page == 1) || ($page == $total_halaman)){
			if(($showpage == 1) && ($page != 2)) echo "...";
			if(($showpage != ($total_halaman-1)) && ($page == $total_halaman)) echo "...";
			if($page == $nomor_halaman) echo "<span class=\"current\">{$page}</span>";
			else echo "<a href=\"".URL."/?option=data-karyawan&page={$page}\">{$page}</a>";
			$showpage = $page;
		}
	}
	if($nomor_halaman < $total_halaman){ echo "<a href=\"".URL."/?option=data-karyawan&page=".($nomor_halaman+1)."\">&rarr; Next</a>\n"; }
	echo "</p>\n";
	
	echo "</div>\n";
}

function detail_karyawan($nik){
	$sql = mysql_fetch_array(mysql_query("SELECT * FROM karyawan WHERE nik='{$nik}'"));
	echo "<div class=\"box\">\n";
	echo "	<h1>Karyawan: {$sql['nama']} - {$sql['nik']}</h1>\n";
	echo "	<div class=\"box_info\">\n";
	echo "		<table class=\"tinfo\">\n";
	echo "		<tr class=\"t\"><td width=\"150\">Nama Lengkap</td><td width=\"300\"> : &nbsp; {$sql['nama']}</td></tr>\n";
	echo "		<tr class=\"b\"><td>NIK Karyawan</td><td> : &nbsp; {$sql['nik']}</td></tr>\n";
	echo "		<tr class=\"t\"><td>Alamat Lengkap</td><td> : &nbsp; {$sql['alamat']}</td></tr>\n";
	echo "		<tr class=\"b\"><td>No HP</td><td> : &nbsp; {$sql['no_hp']}</td></tr>\n";
	echo "		<tr class=\"t\"><td>Jenis Kelamin</td><td> : &nbsp; {$sql['jenis_kelamin']}</td></tr>\n";
	echo "		<tr class=\"b\"><td>Divisi</td><td> : &nbsp; {$sql['divisi']}</td></tr>\n";
	echo "		<tr class=\"t\"><td>Status Pernikahan</td><td> : &nbsp; {$sql['status']}</td></tr>\n";
	echo "		</table>\n";
	echo "	</div>\n";
	echo "	<div class=\"box_photo\">\n";
	if(file_exists("photo/{$sql['photo']}")){
		$photo = "<img src=\"".URL."/photo/{$sql['photo']}\" alt=\"{$sql['photo']}\">";
	} else {
		$photo = "<img src=\"".URL."/photo/noname.jpg\">";
	}
	echo "{$photo}";
	
	echo "	</div>\n";
	echo "	<div class=\"clear\"></div>\n";
	echo "</div>\n";
}

?>