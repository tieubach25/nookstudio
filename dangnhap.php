<?php
session_start();
if (isset($_SESSION['MaND'])) {
    header("Location: ./index.php");
    exit();
}

if(isset ($_POST['submit'])){
    include('./lib/ketnoi.php');
    
    $email = $_POST['Email'];
    $password = $_POST['MatKhau'];

    $query = "SELECT * FROM nguoidung WHERE Email = '$email' AND MatKhau = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['MaND'] = $user['MaND'];

        // Đảm bảo chuyển hướng sau khi đăng nhập thành công
        header("Location: index.php");
        exit();
    } else {
        // Hiển thị thông báo lỗi nếu đăng nhập không thành công
        echo '<script type="text/javascript">
                alert("Email hoặc mật khẩu không đúng!");
              </script>';
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <?php $tentrang = "Đăng Nhập"; include('./lib/khaibao/khaibao.php')?>
</head>

<body>
    <!-- Page Preloder -->
    <style>
        .header__right {
            display: none;
        }					  			
        .user_mobile {
            display: none;
        }
    </style>
    <?php include('./lib/header.php')?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login</h2>
                        <p>Welcome to the official Anime blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Đăng nhập</h3>
                        <form action="dangnhap.php" method="POST">
                            <div class="input__item">
                                <input style="color:black;" value="" name="Email" id="Email" type="email" placeholder="Email">
                                <span><i style="color: #0b0c2a;" class="fa-regular fa-envelope"></i></span>
                            </div>
                            <div class="input__item">
                                <input value="" name="MatKhau" id="MatKhau" type="password" placeholder="Mật khẩu">
                                <span><i style="color: #0b0c2a;" class="fa-solid fa-lock"></i></span>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button name="submit" type="submit" class="site-btn">Đăng nhập</button>
                                </div>
                                <div class="col-lg-6">
                                    <a href="#" class="forget_pass">Quên mật khẩu?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Bạn chưa có tài khoản?</h3>
                        <a href="./dangky.php" class="primary-btn">Đăng kí ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
