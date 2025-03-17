<!DOCTYPE html>
<html lang="zxx">

<head>
<?php 
$tentrang = "Đăng Ký"; include('./lib/khaibao/khaibao.php');
?>
</head>

<body>
    <!-- Page Preloder -->

<?php 
include('./lib/header.php');
?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Sign Up</h2>
                        <p>Welcome to the official Anime blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                </div>
				<div class="col-lg-8">
                    <div class="login__form">
						<style>
							.login__form:after {
								width: 0px;
							}
						</style>
                        <h3>Đăng ký</h3>
						<?php 
						if(isset ($_POST['submit'])){
							$tennd = $_POST['ten'];
							$email = $_POST['email'];
							$matkhau = $_POST['matkhau'];

							if(empty($tennd) || empty($email) || empty($matkhau)){
								echo "Dữ liệu không hợp lệ";
							} else {
								include('./lib/ketnoi.php');
								$mand = '';
								$query_last_id = "SELECT MaND FROM nguoidung ORDER BY MaND DESC LIMIT 1";
								$result_last_id = $conn->query($query_last_id);

								if ($result_last_id->num_rows > 0) {
									$row = $result_last_id->fetch_assoc();
									$last_id = $row['MaND'];
									$mand_o = (int) substr($last_id, 3);
									$mand_n = str_pad($mand_o + 1, 4, "0", STR_PAD_LEFT);
									$mand = "NDA".$mand_n;
								} else {
									$mand = "NDA0001";
								}
								//statement
								$stmt = $conn->prepare("INSERT INTO nguoidung (MaND, TenND, AvtND, Email, MatKhau) 
								VALUES (?, ?, 'img/avt/nd0000.jpg', ?, ?)");
								$stmt->bind_param("ssss", $mand, $tennd, $email, $matkhau);

								if ($stmt->execute()) {
									echo'<h5>Bạn đã đăng kí thành công  <a href="./dangnhap.php"> Đăng Nhập!</a></h5>';
								} else {
									echo "Lỗi khi thêm người dùng: " . $stmt->error;
								}
								$stmt->close();
								$conn->close();
							}
						}
						?>

						<form action="dangky.php" method="POST">
							<div class="input__item">
								<input name="email" type="text" placeholder="Email address" required>
								<span class="icon_mail"></span>
							</div>
							<div class="input__item">
								<input name="ten" type="text" placeholder="Your Name" required>
								<span class="icon_profile"></span>
							</div>
							<div class="input__item">
								<input name="matkhau" type="password" placeholder="Password" required>
								<span class="icon_lock"></span>
							</div>
							<button name="submit" class="site-btn">Đăng Ký</button>
						</form>
                        <h5>Bạn đã có tài khoản?  <a href="./dangnhap.php"> Đăng Nhập!</a></h5>
                    </div>
                </div>
				<div class="col-lg-2">
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->
    <?php 
		include('./lib/footer.php');
	?>
      <!-- Search model Begin -->
      <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

<?php
include('./lib/khaibao/khaibaob.php');
?>

</body>

</html>