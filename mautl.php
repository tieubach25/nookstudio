<head>
	<?php
		include('./lib/nguoidung.php');
		include('./lib/ketnoi.php');

		$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

		$query = "SELECT MaTL, TenTL FROM theloai
		WHERE REPLACE(REPLACE(REPLACE(LOWER(TenTL), ' ', '-'), ':', '-'), 'đ', 'd') = LOWER(REPLACE(REPLACE('$slug', ' ', '-'), ':', '-'));";
		$result = $conn->query($query);

		if($result->num_rows > 0){
			while($rows = $result->fetch_assoc()){
				$dkmatl = $rows["MaTL"];
				$tentl = $rows["TenTL"];
				$tentrang = $tentl;
			}
		} else {
			echo "Không tìm thấy truyện";
		}
		$conn->close();
		include('./lib/khaibao/khaibao2.php');
	?>
</head>

<body>
    <!-- Page Preloder -->
   
	<?php include('./lib/header2.php')?>
	
	<?php 
		include('./lib/ketnoi.php');
		$query = "SELECT MaTL, TenTL FROM theloai WHERE theloai.MaTL ='$dkmatl';";
		$result = $conn->query($query);

		if($result->num_rows > 0){
			while($rows = $result->fetch_assoc()){
				$matl = $rows["MaTL"];
				$theloai = $rows["TenTL"];
				echo '
				<div class="breadcrumb-option">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="breadcrumb__links">
									<a href="../index.php"><i class="fa fa-home"></i> Trang chủ</a>
									<span>'.$theloai.'</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}
		}
		else{
			echo "Không có dữ liệu";
		}
		$conn->close();
	?>

	<?php 
		include('./lib/ketnoi.php');
		$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$items_per_page = 6;

		$offset = ($current_page - 1) * $items_per_page;

		$query_total = "SELECT COUNT(*) as total FROM theloai 
						LEFT JOIN tacpham ON tacpham.MaTL = theloai.MaTL 
						WHERE theloai.MaTL = '$dkmatl'";
		$result_total = $conn->query($query_total);
		$row_total = $result_total->fetch_assoc();
		$total_items = $row_total['total'];

		$total_pages = ceil($total_items / $items_per_page);
		$query = "SELECT tacpham.MaTp, TenTp, TenTL, `tacpham_ttp`.Url, BiaTp, Luot, 
					ROUND(AVG(`tacpham_danhgia`.`DanhGia`),1) as DanhGia, COUNT(DISTINCT BinhLuan) as SLBinhLuan
					FROM theloai LEFT JOIN `tacpham` on tacpham.MaTL = theloai.MaTL 
					LEFT JOIN `tacpham_ttp` on `tacpham_ttp`.MaTp = tacpham.MaTp 
					LEFT JOIN `tacpham_danhgia` on `tacpham_danhgia`.MaTp = tacpham.MaTp 
					LEFT JOIN `tacpham_binhluan` on `tacpham_binhluan`.MaTp = tacpham.MaTp 
					WHERE theloai.MaTL = '$dkmatl' GROUP BY tacpham.MaTp LIMIT $offset, $items_per_page";
		$result = $conn->query($query);

		if($result->num_rows > 0){
			while($rows = $result->fetch_assoc()){
				$matp = $rows["MaTp"];
				$tentp = $rows["TenTp"];
				$theloai = $rows["TenTL"];
				$url = $rows["Url"];
				$biatp = $rows["BiaTp"];
				$luot = $rows["Luot"];
				$danhgia = $rows["DanhGia"];
				$slbinhluan = $rows["SLBinhLuan"];
				echo '
					<section class="product-page spad">
						<div class="container">
							<div class="row">
								<div class="col-lg-8">
									<div class="product__page__content">
										<div class="product__page__title">
											<div class="section-title">
												<h4>'.$theloai.'</h4>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="product__item">
													<div class="product__item__pic set-bg" data-setbg=".'.$biatp.'">
														<div class="ep">'.$danhgia.' / 10</div>
														<div class="comment"><i class="fa fa-comments"></i> '.$slbinhluan.'</div>
														<div class="view"><i class="fa fa-eye"></i> '.$luot.'</div>
													</div>
													<div class="product__item__text">
														<ul>
															<li>'.$theloai.'</li>
														</ul>
														<h5><a href=".'.$url.'">'.$tentp.'</a></h5>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="product__pagination">';
									for ($i = 1; $i <= $total_pages; $i++) {
										if ($i == $current_page) {
											echo '<a href="?page=' . $i . '" class="current-page">' . $i . '</a>';
										} 
										else {
											echo '<a href="?page=' . $i . '">' . $i . '</a>';
										}
									}

									if ($current_page < $total_pages) {
										echo '<a href="?page=' . ($current_page + 1) . '"><i class="fa fa-angle-double-right"></i></a>';
									}
									echo'
									</div>
								</div>';
			}
		}
		else{
			echo "Không có dữ liệu";
		}
		$conn->close();
	?>
	<?php 
		include('./lib/ketnoi.php');
		$queryr = "SELECT tacpham.MaTp, TenTp, Url, BiaTp, Luot, 
					ROUND(AVG(`tacpham_danhgia`.`DanhGia`),1) as DanhGia
					FROM tacpham LEFT JOIN `tacpham_ttp` on `tacpham_ttp`.MaTp = tacpham.MaTp 
					LEFT JOIN `tacpham_danhgia` on `tacpham_danhgia`.MaTp = tacpham.MaTp 
					LEFT JOIN `tacpham_binhluan` on `tacpham_binhluan`.MaTp = tacpham.MaTp 
					GROUP BY tacpham.MaTp ORDER BY RAND() LIMIT 2";
		$resultr = $conn->query($queryr);

		if($resultr->num_rows > 0){
			echo'<div class="col-lg-4 col-md-6 col-sm-8">
						<div class="product__sidebar">
							<div class="product__sidebar__view">
								<div class="section-title">
									<h5>Bạn có thể thích</h5>
								</div>
								<div class="filter__gallery">';
			while($rows = $resultr->fetch_assoc()){
				$matp = $rows["MaTp"];
				$tentp = $rows["TenTp"];
				$url = $rows["Url"];
				$biatp = $rows["BiaTp"];
				$luot = $rows["Luot"];
				$danhgia = $rows["DanhGia"];
				echo'
					<div class="product__sidebar__view__item set-bg mix day" data-setbg=".'.$biatp.'">
						<div class="ep">'.$danhgia.' / 10</div>
						<div class="view"><i class="fa fa-eye"></i> '.$luot.'</div>
						<h5 style="background-color: rgba(0, 0, 0, 0.8);"><a href=".'.$url.'">'.$tentp.'</a></h5>
					</div>';
			}
			echo'</div></div>
							<div class="product__sidebar__comment">
								<div class="section-title">
									<h5>New Comment</h5>
								</div>
								<div class="product__sidebar__comment__item">
									<div class="product__sidebar__comment__item__pic">
										<img src="img/sidebar/comment-1.jpg" alt="">
									</div>
									<div class="product__sidebar__comment__item__text">
										<ul>
											<li>Active</li>
											<li>Movie</li>
										</ul>
										<h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
										<span><i class="fa fa-eye"></i> 19.141 Viewes</span>
									</div>
								</div>
							</div>
						</div>
								</div>
							</div>
						</div>
					</section>';
		}
		else{
			echo "Không có dữ liệu";
		}
		$conn->close();
	?>

	<?php include('./lib/footer2.php');?>

	<div class="search-model">
		<div class="h-100 d-flex align-items-center justify-content-center">
			<div class="search-close-switch"><i class="icon_close"></i></div>
			<form class="search-model-form">
				<input type="text" id="search-input" placeholder="Search here.....">
			</form>
		</div>
	</div>
	
	<?php include('./lib/khaibao/khaibaob2.php');?>
</body>