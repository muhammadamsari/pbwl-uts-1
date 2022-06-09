<div class="card" style="padding: 50px; width: 40%; margin: 0 auto; margin-top: 10%;">
	<h3 style="text-align: center;" class="orange-text">Login!</h3>

	<link href="css/css/bootstrap.css" rel="stylesheet">
	<link href="css/css/bootstrap.min.css" rel="stylesheet">



	<!-- Add custom CSS here -->
	<link href="css/css/sb-admin.css" rel="stylesheet">


	<form method="POST">
		<form method="POST">
			<div class="form-group ">
				<input type="text" class="form-control" placeholder="Username" id="username" name="username">

			</div>
			<div class="form-group log-status">
				<input type="password" class="form-control" placeholder="Password" id="password" name="password">

			</div>
			<input type="submit" name="login" value="Login" class="btn orange" style="width: 100%;">
		</form>
</div>
<?php
if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($koneksi, $_POST['username']);
	$password = mysqli_real_escape_string($koneksi, md5($_POST['password']));

	$sql = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE username='$username' AND password='$password' ");
	$cek = mysqli_num_rows($sql);
	$data = mysqli_fetch_assoc($sql);

	$sql2 = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND password='$password' ");
	$cek2 = mysqli_num_rows($sql2);
	$data2 = mysqli_fetch_assoc($sql2);

	if ($cek > 0) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['data'] = $data;
		$_SESSION['level'] = 'masyarakat';
		header('location:masyarakat/');
	} elseif ($cek2 > 0) {
		if ($data2['level'] == "admin") {
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['data'] = $data2;
			header('location:admin/');
		} elseif ($data2['level'] == "petugas") {
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['data'] = $data2;
			header('location:petugas/');
		}
	} else {
		echo "<script>alert('Gagal Login')</script>";
	}
}
?>