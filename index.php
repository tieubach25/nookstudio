<?php include('./lib/nguoidung.php')?>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<?php $tentrang = "Trang Chủ"; include('./lib/khaibao/khaibao.php')?>
</head>

<body>
    <!-- Page Preloder -->
   

	<?php include('./lib/header.php')?>

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
				<?php 
					include('./lib/ketnoi.php');
					$query = "SELECT tacpham.MaTp, TenTp, TacGia, MoTa, TenTL, BiaTp, `tacpham_ttp`.Url
					FROM `tacpham` LEFT JOIN theloai on tacpham.MaTL = theloai.MaTL 
					LEFT JOIN `tacpham_ttp` on `tacpham_ttp`.MaTp = tacpham.MaTp  
					GROUP BY tacpham.MaTp ORDER BY RAND() LIMIT 3;";
					$result = $conn->query($query);

					if($result->num_rows > 0){
						while($rows = $result->fetch_assoc()){
							$matp = $rows["MaTp"];
							$tentp = $rows["TenTp"];
							$tacgia = $rows["TacGia"];
							$tacgia = $rows["TacGia"];
							$mota = $rows["MoTa"];
							$tentl = $rows["TenTL"];
							$biatp = $rows["BiaTp"];
							$url = $rows["Url"];
							echo '
								<div class="hero__items set-bg" data-setbg="'.$biatp.'">
									<div class="row">
										<div class="col-lg-6">
											<div class="hero__text">
												<div class="label">'.$tentl.'</div>
												<h2 class="tp">'.$tentp.'</h2>
												<p class="mota">'.$mota.'</p>
												<a href="'.$url.'"><span>Xem ngay</span> <i class="fa fa-angle-right"></i></a>
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
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Truyện Nổi Bật</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<?php 
								include('./lib/ketnoi.php');
								$query = "SELECT tacpham.MaTp, TenTp, TenTL, BiaTp, `tacpham_ttp`.Url, Luot, 
								ROUND(AVG(`tacpham_danhgia`.`DanhGia`),1) as DanhGia, COUNT(DISTINCT BinhLuan) as SLBinhLuan 
								FROM `tacpham` LEFT JOIN theloai on tacpham.MaTL = theloai.MaTL 
								LEFT JOIN `tacpham_ttp` on `tacpham_ttp`.MaTp = tacpham.MaTp 
								LEFT JOIN `tacpham_danhgia` on `tacpham_danhgia`.MaTp = tacpham.MaTp 
								LEFT JOIN `tacpham_binhluan` on `tacpham_binhluan`.MaTp = tacpham.MaTp 
								GROUP BY tacpham.MaTp ORDER BY Luot DESC LIMIT 6;";
								$result = $conn->query($query);

								if($result->num_rows > 0){
									while($rows = $result->fetch_assoc()){
										$matp = $rows["MaTp"];
										$tentp = $rows["TenTp"];
										$theloai = $rows["TenTL"];
										$biatp = $rows["BiaTp"];
										$url = $rows["Url"];
										$luot = $rows["Luot"];
										$danhgia = $rows["DanhGia"];
										$slbinhluan = $rows["SLBinhLuan"];
										echo '
											<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="product__item">
													<div class="product__item__pic set-bg" data-setbg="'.$biatp.'">
														<div class="ep">'.$danhgia.' / 10</div>
														<div class="comment"><i class="fa fa-comments"></i> '.$slbinhluan.'</div>
														<div class="view"><i class="fa fa-eye"></i> '.$luot.'</div>
													</div>
													<div class="product__item__text">
														<ul>
															<li>'.$theloai.'</li>
														</ul>
														<h5><a href="'.$url.'">'.$tentp.'</a></h5>
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
                        </div>
                    </div>
                    <div class="new__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Truyện Mới Cập Nhật</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<?php 
								include('./lib/ketnoi.php');
								$query = "SELECT tacpham.MaTp, TenTp, TenTL, BiaTp, `tacpham_ttp`.Url, Luot, TenChuong, lateshChuong.NgayCN, 
								ROUND(AVG(DanhGia), 1) AS DanhGia, COUNT(DISTINCT BinhLuan) AS SLBinhLuan 
									FROM `tacpham` LEFT JOIN theloai on tacpham.MaTL = theloai.MaTL 
									LEFT JOIN `tacpham_ttp` on `tacpham_ttp`.MaTp = tacpham.MaTp 
									LEFT JOIN `tacpham_danhgia` on `tacpham_danhgia`.MaTp = tacpham.MaTp 
									LEFT JOIN `tacpham_binhluan` on `tacpham_binhluan`.MaTp = tacpham.MaTp 
									LEFT JOIN `chuong` on `chuong`.MaTp = tacpham.MaTp
									LEFT JOIN (
										SELECT MaTp, MAX(NgayCN) AS NgayCN 
										FROM chuong 
										GROUP BY MaTp
									) AS lateshChuong ON chuong.MaTp = lateshChuong.MaTp AND chuong.NgayCN = lateshChuong.NgayCN
									GROUP BY tacpham.MaTp
									ORDER BY lateshChuong.NgayCN DESC 
									LIMIT 6;";
								$result = $conn->query($query);

								if($result->num_rows > 0){
									while($rows = $result->fetch_assoc()){
										$matp = $rows["MaTp"];
										$tentp = $rows["TenTp"];
										$theloai = $rows["TenTL"];
										$biatp = $rows["BiaTp"];
										$url = $rows["Url"];
										$luot = $rows["Luot"];
										$danhgia = $rows["DanhGia"];
										$slbinhluan = $rows["SLBinhLuan"];
										echo '
											<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="product__item">
													<div class="product__item__pic set-bg" data-setbg="'.$biatp.'">
														<div class="ep">'.$danhgia.' / 10</div>
														<div class="comment"><i class="fa fa-comments"></i> '.$slbinhluan.'</div>
														<div class="view"><i class="fa fa-eye"></i> '.$luot.'</div>
													</div>
													<div class="product__item__text">
														<ul>
															<li>'.$theloai.'</li>
														</ul>
														<h5><a href="'.$url.'">'.$tentp.'</a></h5>
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
                        </div>
                    </div>
                    </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
						<div class="product__sidebar__theloai">
								<div class="section-title">
									<h5>Thể loại</h5>
								</div>
								<div class="product__sidebar__theloai__item">
									<div class="product__sidebar__theloai__item__pic">
										<img src="img/sidebar/theloai-1.jpg" alt="">
									</div>
									<div class="product__sidebar__theloai__item__text">
										<ul>
											<?php 
												include('./lib/ketnoi.php');;
												$query = "SELECT * FROM theloai;";
												$result = $conn->query($query);

												if($result->num_rows > 0){
													while($rows = $result->fetch_assoc()){
														$matl = $rows["MaTL"];
														$tentl = $rows["TenTL"];
														$url = $rows["Url"];
														echo '<li><a href="'.$url.'">'.$tentl.'</a></li><p>';
													}
												}
												else{
													echo "Không có dữ liệu";
												}
												$conn->close();
											?>
										</ul>
									</div>
								</div>
							</div>
							<div class="product__sidebar__view">
								<div class="section-title">
									<h5>Lượt xem hàng đầu</h5>
								</div>
								<div class="filter__gallery">
								<?php 
									include('./lib/ketnoi.php');
									$dkmatp = "TRA001";
									$query = "SELECT tacpham.MaTp, TenTp, TenTL, BiaTp, `tacpham_ttp`.Url, Luot, 
									ROUND(AVG(`tacpham_danhgia`.`DanhGia`),1) as DanhGia, COUNT(DISTINCT BinhLuan) as SLBinhLuan 
									FROM `tacpham` LEFT JOIN theloai on tacpham.MaTL = theloai.MaTL 
									LEFT JOIN `tacpham_ttp` on `tacpham_ttp`.MaTp = tacpham.MaTp 
									LEFT JOIN `tacpham_danhgia` on `tacpham_danhgia`.MaTp = tacpham.MaTp 
									LEFT JOIN `tacpham_binhluan` on `tacpham_binhluan`.MaTp = tacpham.MaTp 
									GROUP BY tacpham.MaTp ORDER BY Luot DESC LIMIT 6;";
									$result = $conn->query($query);

									if($result->num_rows > 0){
										while($rows = $result->fetch_assoc()){
											$matp = $rows["MaTp"];
											$tentp = $rows["TenTp"];
											$theloai = $rows["TenTL"];
											$biatp = $rows["BiaTp"];
											$url = $rows["Url"];
											$luot = $rows["Luot"];
											$danhgia = $rows["DanhGia"];
											$slbinhluan = $rows["SLBinhLuan"];
											$tentrang = $tentp;
											echo '<div class="product__sidebar__view__item set-bg mix day years"
													data-setbg="'.$biatp.'">
													<div class="ep">'.$danhgia.' / 10</div>
													<div class="view"><i class="fa fa-eye"></i> '.$luot.'</div>
													<h5 style="background-color: rgba(0, 0, 0, 0.8);"><a href="'.$url.'">'.$tentp.'</a></h5></div>';
										}
									}
									else{
										echo "Không có dữ liệu menu";
									}
									$conn->close();
									?>
							</div>
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
		</div>
	</section>
<!-- Product Section End -->

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