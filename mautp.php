<head>
	<?php
		session_start();
		if (!isset($_SESSION['MaND'])) {
			header("Location: ../dangnhap.php");
			exit();
		}

		$MaND = $_SESSION['MaND'];
		include('./lib/ketnoi.php');
		$query = "SELECT * FROM nguoidung WHERE MaND = '$MaND'";
		$result = mysqli_query($conn, $query);
		$mandkey = $MaND;
		include('./lib/ketnoi.php');

		$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

		$query = "SELECT MaTp, TenTp
		FROM tacpham
		WHERE REPLACE(REPLACE(REPLACE(LOWER(TenTp), ' ', '-'), ':', '-'), 'đ', 'd') = LOWER(REPLACE(REPLACE('$slug', ' ', '-'), ':', '-'));
		";
		$result = $conn->query($query);

		if($result->num_rows > 0){
			while($rows = $result->fetch_assoc()){
				$dkmatp = $rows["MaTp"];
				$tentp = $rows["TenTp"];
				$tentrang = $tentp;
			}
		} else {
			echo "Không tìm thấy truyện";
		}
		$conn->close();
		include('./lib/khaibao/khaibao2.php');
	?>
</head>

<body>    

	<?php include('./lib/header2.php')?>
	<?php include('./lib/tacpham.php');?>
    <?php include('./lib/footer2.php');?>

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
		include('./lib/khaibao/khaibaob2.php');
	?>
</body>