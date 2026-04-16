<?php
include"dbconfig.php";

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Tender A Corporate category Flat bootstrap Responsive  Website Template | Home :: w3layouts</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }>
</script>
<meta name="keywords" content="Tender Responsive web template, Bootstrap Web Templates, Flat Web Templates, AndriodCompatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<!--Google Fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
	</script>
<!-- //end-smoth-scrolling -->
<style>
/* Home hero fallback styles (kept here to avoid broken UI when shared CSS is overridden) */
.home-admin-btn { display:inline-block; padding:6px 12px; margin-right:10px; border-radius:999px; background:rgba(255,255,255,.18); color:#fff !important; font-size:12px; font-weight:700; text-decoration:none; border:1px solid rgba(255,255,255,.35); }
.home-admin-btn:hover { background:#fff; color:#ef476f !important; }
.home-hero { width:100%; min-height:360px; background:linear-gradient(130deg, rgba(15,39,68,.85), rgba(36,59,85,.78)), url(images/banner.jpg) center/cover no-repeat; border-radius:14px; padding:30px; display:flex; align-items:center; justify-content:center; margin-top:10px; }
.hero-card { max-width:780px; background:rgba(255,255,255,.94); border:1px solid rgba(255,255,255,.7); border-radius:16px; padding:26px; box-shadow:0 22px 38px rgba(19,29,49,.24); text-align:center; }
.hero-tag { display:inline-block; margin-bottom:10px; padding:6px 12px; border-radius:999px; background:#fbe3eb; color:#d93a60; font-size:12px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; }
.home-hero h2 { margin:0; color:#1e2c42; font-size:34px; line-height:1.2; font-family:'Space Grotesk',sans-serif; }
.home-hero h3 { margin:12px 0 0; color:#4e5f77; font-size:17px; font-weight:600; }
.hero-actions { margin-top:20px; display:flex; flex-wrap:wrap; justify-content:center; gap:10px; }
.hero-btn { display:inline-block; padding:11px 16px; border-radius:10px; background:linear-gradient(90deg,#ef476f,#ff5f87); color:#fff !important; text-decoration:none; font-weight:700; box-shadow:0 10px 18px rgba(239,71,111,.24); }
.hero-btn-light { background:#fff; color:#1e2c42 !important; border:1px solid #d5ddeb; box-shadow:none; }
.hero-btn-admin { background:linear-gradient(90deg,#4656e7,#5f7aff); }
@media (max-width:768px){ .home-hero{padding:16px; min-height:300px;} .hero-card{padding:18px;} .home-hero h2{font-size:26px;} .home-hero h3{font-size:15px;} }
</style>
</head>
<body>
<!--top nav start here-->
<div class="mother-grid">
	<div class="container">
	  <div class="temp-padd">
		<div class="top-strip">
			<div class="address">
				<ul>
					<li><a href="http://localhost:8080/"><span class="link"> </span>www.tender.com</a></li>
					<li><a href="mailto:example@email.com"><span class="mes"> </span>punitsankhala@gmail.com</a></li>
					<li><span class="ph"> </span>9589879629</li>
				</ul>
			</div>
			<div class="social-icons">
				<ul>
					<li><a href="admin/index.php" class="home-admin-btn">Admin Login</a></li>
					<li><a href="https://www.facebook.com/"> <span class="w-f"> </span></a></li>
                   <li><a href="https://twitter.com/"> <span class="w-tw"> </span></a></li>
                   <li><a href="https://www.linkedin.com/in/"> <span class="w-in"> </span></a></li>
				</ul>
			</div>
		  <div class="clearfix"> </div>
   </div>
<!--top nav end here-->	
<!--title start here-->
<div class="title-main">
			<a href="index.php"><h1>Tender</h1></a>
		
</div>
<!--title end here-->
<!--header start here-->
<div class="header">
			<div class="navg">
				<span class="menu" > </span>
				<?php include"nav.php";?>
				
				<script>
                  $( "span.menu").click(function() {
                    $(  "ul.res" ).slideToggle("slow", function() {
                     // Animation complete.
                     });
                     });
		       </script>
			</div>
			<form method="post" action="search.php">
		
			<div class="search">
				<input type="text"  name="tender" placeholder="Tender search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Site search';}"/>
			<input type="submit" name="search" value=""/>
			
      	</div></form>
			<div class="clearfix"> </div>
  </div>
<!--header end here-->
<!--banner start here-->
 <div class="banner home-hero"  >
		<div class="hero-card">
			<p class="hero-tag">Digital Tender Management</p>
			<h2>Find, Compare, and Win Government Tenders Faster</h2>
			<h3>One clean portal for tender discovery, bid tracking, and allocation workflows.</h3>
			<div class="hero-actions">
				<a href="tender.php" class="hero-btn">Explore Tenders</a>
				<a href="register.php" class="hero-btn hero-btn-light">Create Account</a>
				<a href="admin/index.php" class="hero-btn hero-btn-admin">Admin Login</a>
			</div>
		</div>
</div>
<!--banner end here-->
<!--nunc dig start here-->
  
<!--nunc dig end here-->
<!--molli start here-->
<script src="js/responsiveslides.min.js"></script>
			 <script>
			    // You can also use "$(window).load(function() {"
			    $(function () {
			      // Slideshow 4
			      $("#slider4").responsiveSlides({
			        auto: true,
			        pager: true,
			        nav: true,
			        speed: 500,
			        namespace: "callbacks",
			        before: function () {
			          $('.events').append("<li>before event fired.</li>");
			        },
			        after: function () {
			          $('.events').append("<li>after event fired.</li>");
			        }
			      });
			
			    });
			  </script>
<!----//End-slider-script---->
<!-- Slideshow 4 -->
			    <div  id="top" class="callbacks_container">
			    <div class="molli">
			    	<div class="molli-top">
			    		<span class="line-x"> </span>
			    		<span class="line-y"> </span>
	                     <h3>Tender's Works</h3>
	                       </div>
			      <ul  id="slider4">
			        <li>
			          <div class="molli-grids" style="height:200px">
						<img src="images/road.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Tante etvuputa</h4>
						</div>
					  </div>
					  <div class="molli-grids" style="height:200px">
						<img src="images/pipe.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Phasellus pede</h4>
						</div>
					</div>
					<div class="molli-grids" style="height:200px">
						<img src="images/dam.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Morbi interdum</h4>
						</div>
					</div>
					<div class="molli-grids" style="height:200px" >
						<img src="images/park.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Suspendisse mauris</h4>
						</div>
					</div>
			        </li>
			        <li>
					  <div class="molli-grids" style="height:200px">
						<img src="images/pat.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Phasellus pede</h4>
						</div>
					</div>
					<div class="molli-grids" style="height:200px">
						<img src="images/tank.jpg" style="height:200px"  alt=""/>
						<div class="molli-text">
							<h4>Morbi interdum</h4>
						</div>
					</div>
					<div class="molli-grids" style="height:200px" >
						<img src="images/hospital.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Suspendisse mauris</h4>
						</div>
					</div>
					 <div class="molli-grids" style="height:200px"> 
						<img src="images/tank.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Tante etvuputa</h4>
						</div>
					  </div>
			        </li>
			        <li>
					<div class="molli-grids" style="height:200px">
						<img src="images/multi.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Morbi interdum</h4>
						</div>
					</div>
					<div class="molli-grids" style="height:200px">
						<img src="images/road.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Suspendisse mauris</h4>
						</div>
					</div>
					 <div class="molli-grids" style="height:200px">
						<img src="images/pipe.jpg" style="height:200px" alt=""/>
						<div class="molli-text">
							<h4>Tante etvuputa</h4>
						</div>
					  </div>
					  <div class="molli-grids" style="height:20px"> 
						<img src="images/dam.jpg"  alt=""/>
						<div class="molli-text">
							<h4>Phasellus pede</h4>
						</div>
					</div>
			        </li>
			      </ul>
			  </div>
			    <div class="clearfix"> </div>
	</div>
	<div class="clearfix"> </div>
<!--molli end here-->
<!--information-grid start here-->
 
</div>
<!--information grid end here-->
<!--footer start here-->
 <div class="footer">
		<div class="footer-main">
			<div class="footer-top">
				<div class="col-md-4 footer-grid">
					<a href="https://www.facebook.com/projecttunnel/"><img src="images/ftr-fa.png" alt=""/></a>
				</div>
				<div class="col-md-4 footer-grid">
					<a href="https://twitter.com/PROJECTTUNNEL1"><img src="images/tw.png" alt=""/></a>
					
				</div>
				<div class="col-md-4 footer-grid">
					<a href="http://projecttunnel.com/"><img src="images/drib.png" alt=""/></a>
					
				</div>
			  <div class="clearfix"> </div>
			</div>
			<div class="footer-bottom">
				<p>Developed By  <a href="http://localhost:8080/">Punit </a></p>
			</div>
		</div>
	   </div>
	</div>
  </div>
<!--footer end here-->
</body>
</html>

