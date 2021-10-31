<?php 
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass ="";
	$database = "dblatihan";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//Jika Tombol simpan di klik
	if (isset($_POST['bsimpan'])) 
	{
		//Pengujian apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan diedit
			$edit = mysqli_query($koneksi, "UPDATE tbl_mhs set
												nim = '$_POST[tnim]',
												namamhs = '$_POST[tnamamhs]',
												jk = '$_POST[tjk]',
												alamat = '$_POST[talamat]',
												kota = '$_POST[tkota]',
												email = '$_POST[temail]',
												foto = '$_POST[tfoto]'
											WHERE id = '$_GET[id]'
											");
			if($edit) //Jika edit sukses
			{
				echo "<script>
					alert('Edit Data Sukses');
					document.location='index2.php';
				</script>";
			}
			else //Jika edit gagal
			{
				echo "<script>
					alert('Edit Data Gagal!!!');
					document.location='index2.php';
				</script>";
			}
		}
		else
		{
			//Data akan disimpan baru
			$simpan = mysqli_query($koneksi, "	INSERT INTO tbl_mhs (nim, namamhs, jk, alamat, kota, email, foto) 
											VALUES 	('$_POST[tnim]', 
													'$_POST[tnamamhs]', 
													'$_POST[tjk]', 
													'$_POST[talamat]', 
													'$_POST[tkota]',
													'$_POST[temail]',
													'$_POST[tfoto]') 
											");
			if($simpan) //Jika simpan sukses
			{
				echo "<script>
					alert('Simpan Data Sukses');
					document.location='index2.php';
				</script>";
			}
			else //Jika simpan gagal
			{
				echo "<script>
					alert('Simpan Data Gagal!!!');
					document.location='index2.php';
				</script>";
			}
		}
	}

	//Pengujian jika tombol Edit atau Hapus diklik
	if (isset($_GET['hal'])) 
	{
		//Pengujian jika edit data
		if ($_GET['hal'] == "edit") 
		{
			//Tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tbl_mhs WHERE id = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if ($data) 
			{
				//Jika data ditemukan, maka data ditampung dulu ke dalam variabel
				$vnim = $data['nim'];
				$vnamamhs = $data['namamhs'];
				$vjk = $data['jk'];
				$valamat = $data['alamat'];
				$vkota = $data['kota'];
				$vemail = $data['email'];
				$vfoto = $data['foto'];
			}
		}
		else if ($_GET['hal'] == hapus)
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tbl_mhs WHERE id = '$_GET[id]' ");
			if($hapus)
			{
				echo "<script>
					alert('Hapus data sukses');
					document.location='index2.php';
				</script>";
			}
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD 2021 PHP & My SQL + Bootstrap 4</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

	<h1 class="text-center">CRUD 2021 PHP & My SQL + Bootstrap 4</h1>
	<h2 class="text-center">@AdiDutaSaputra</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Mahasiswa
	  </div>
	  <div class="card-body">
	    <form method="post" action="">

	    	<div class="form-group">
	    		<label>Nim</label>
	    		<input type="text" name="tnim" value ="<?=@$vnim?>" class="form-control" placeholder="Input NIM anda disini" required="Harap Isi Kolom Ini">
	    	</div>

	    	<div class="form-group">
	    		<label>Nama</label>
	    		<input type="text" name="tnamamhs" value ="<?=@$vnamamhs?>" class="form-control" placeholder="Input Nama anda disini" required="Harap Isi Kolom Ini">
	    	</div>

	    	<div class="form-group">
	    		<label>Jenis Kelamin</label>
	    		<select class="form-control" name="tjk">
	    			<option value="<?=@$vjk?>"><?=@$vjk?></option>
	    			<option value="L">L</option>
	    			<option value="P">P</option>
	    		</select>
	    	</div>

	    	<div class="form-group">
	    		<label>Alamat</label>
	    		<textarea class="form-control" name="talamat" placeholder="Input alamat anda disini"><?=@$valamat?></textarea>
	    	</div>

	    	<div class="form-group">
	    		<label>Kota</label>
	    		<textarea class="form-control" name="tkota" placeholder="Input kota anda disini"><?=@$vkota?></textarea>
	    	</div>

	    	<div class="form-group">
	    		<label>Email</label>
	    		<textarea class="form-control" name="temail" placeholder="Input email anda disini"><?=@$vemail?></textarea>
	    	</div>

	    	<div class="form-group">
	    		<label>Foto</label>
	    		<input class="form-control" type="file" name="tfoto" placeholder="Input email anda disini"><?=@$vemail?>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Mahasiswa
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nim</th>
	    		<th>Nama</th>
	    		<th>Jenis Kelamin</th>
	    		<th>Alamat</th>
	    		<th>Kota</th>
	    		<th>Email</th>
	    		<th>Foto</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php 
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from tbl_mhs order by id desc");
	    		while ($data = mysqli_fetch_array($tampil)) :
	    	 ?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data ['nim'];?></td>
	    		<td><?=$data ['namamhs'];?></td>
	    		<td><?=$data ['jk'];?></td>
	    		<td><?=$data ['alamat'];?></td>
	    		<td><?=$data ['kota'];?></td>
	    		<td><?=$data ['email'];?></td>
	    		<td><?=$data ['foto'];?></td>
	    		<td>
	    			<a href="index2.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
	    			<a href="index2.php?hal=hapus&id=<?=$data['id']?>" 
	    				onclick="return confirm('Apakah yakin ingin menghapus?')" class="btn btn-danger">Hapus</a>
	    		</td>
	    	</tr>
	    	<?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->

</div>



<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>