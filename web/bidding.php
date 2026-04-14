<?php
include"dbconfig.php";
if(isset($_SESSION['login']))
{
	
}
else
{
	header("location:login.php");
}

$tenderId = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$tenderCategory = 'General';
$isTenderClosed = false;
$existingBid = null;
$existingBidId = 0;
if($tenderId > 0)
{
	$tenderRes = select("SELECT category, allot FROM tender WHERE id='".$tenderId."' LIMIT 1");
	if($tenderRes && mysqli_num_rows($tenderRes) > 0)
	{
		$tenderRow = mysqli_fetch_assoc($tenderRes);
		$tenderCategory = !empty($tenderRow['category']) ? $tenderRow['category'] : 'General';
		$isTenderClosed = isset($tenderRow['allot']) && (string)$tenderRow['allot'] !== "\0" && (string)$tenderRow['allot'] !== "0";
	}

	if(isset($_SESSION['id']))
	{
		$existingBidRes = select("SELECT bid_id, email, mobile, charge, days FROM bidding WHERE tenderid='".$tenderId."' AND userid='".$_SESSION['id']."' ORDER BY bid_id DESC LIMIT 1");
		if($existingBidRes && mysqli_num_rows($existingBidRes) > 0)
		{
			$existingBid = mysqli_fetch_assoc($existingBidRes);
			$existingBidId = (int)$existingBid['bid_id'];
		}
	}
}

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
</head>
<body>
<!--top nav start here-->
<div class="mother-grid">
	<div class="container">
	  <div class="temp-padd">
		<div class="top-strip">
			<div class="address">
				<ul>
					<li><a href="https://projecttunnel.com/"><span class="link"> </span>www.projecttunnel.com</a></li>
					<li><a href="mailto:example@email.com"><span class="mes"> </span>projecttunnel52@gmail.com</a></li>
					<li><span class="ph"> </span>9993639672</li>
				</ul>
			</div>
			<div class="social-icons">
				<ul>
					<li><a href="https://www.facebook.com/projecttunnel/"> <span class="w-f"> </span></a></li>
                   <li><a href="https://twitter.com/PROJECTTUNNEL1"> <span class="w-tw"> </span></a></li>
                   <li><a href="https://www.linkedin.com/in/project-tunnel-75479a164/"> <span class="w-in"> </span></a></li>
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
			<div class="search">
				<input type="text" placeholder="Tender search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Site search';}"/>
				<input type="submit" value=""/>
			</div>
			<div class="clearfix"> </div>
  </div></br>
<!--header end here-->

<h2 style="text-align:center;background-color:#F35761;color:white;font-weight:bold">BIDDING</h2></br></br>
<div class="container">
<div class="row">
<div class="col-lg-4">
</div>
<div class="col-lg-4">
<div class="chart-area">
<?php
//print_r($_SESSION);
?>
                  <form class="user"  method="post">
                    <div class="form-group">
					Name-
                      <input type="text" class="form-control form-control-user" readonly value="<?=$_SESSION['name']?>" name="name" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Your Name...">
                    </div>
					<div class="form-group">
					Email-
	                      <input type="text" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Your Email..." value="<?=($existingBid && isset($existingBid['email'])) ? $existingBid['email'] : ''?>" <?= $isTenderClosed ? 'readonly' : '' ?>>
                    </div>
					<div class="form-group">
					Mobile-
	                      <input type="text" class="form-control form-control-user" name="mobile" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Your Mobile..." value="<?=($existingBid && isset($existingBid['mobile'])) ? $existingBid['mobile'] : ''?>" <?= $isTenderClosed ? 'readonly' : '' ?>>
                    </div>
                    
					 <div class="form-group">
					Charge-
	                      <input type="text" class="form-control form-control-user" name="charge" id="exampleInputPassword" placeholder="Password" value="<?=($existingBid && isset($existingBid['charge'])) ? $existingBid['charge'] : ''?>" <?= $isTenderClosed ? 'readonly' : '' ?>>
                    </div>
					<div class="form-group">
					Days-
	                      <input type="text" class="form-control form-control-user" name="day" id="exampleInputPassword" placeholder="Password" value="<?=($existingBid && isset($existingBid['days'])) ? $existingBid['days'] : ''?>" <?= $isTenderClosed ? 'readonly' : '' ?>>
                    </div>
					<div class="form-group">
					Category-
					  <input type="text" class="form-control form-control-user" readonly value="<?=$tenderCategory?>" name="category_display">
					  <input type="hidden" name="category" value="<?=$tenderCategory?>">
					</div>
                    
                     <?php if($isTenderClosed) { ?>
					 <div class="alert alert-warning">This tender is closed. You can no longer place or edit bid.</div>
					<?php } else { ?>
	                     <input type="submit"  value="<?= $existingBid ? 'UPDATE BID' : 'BIDDING' ?>" name="bidding" class="btn btn-primary btn-user btn-block">
					<?php } ?>
               
                    <hr>
                    
                  </form>
				  
				  <?php
if(isset($_REQUEST['bidding']))
	{
		if($tenderId <= 0)
		{
			echo"Invalid tender selected";
			exit();
		}

		if($isTenderClosed)
		{
			echo"<script>alert('Tender is closed. Bid cannot be modified.'); window.location='tender.php';</script>";
			exit();
		}

		$name = addslashes(trim($_REQUEST['name']));
		$email = addslashes(trim($_REQUEST['email']));
		$mobile = addslashes(trim($_REQUEST['mobile']));
		$charge = addslashes(trim($_REQUEST['charge']));
		$day = addslashes(trim($_REQUEST['day']));
		$category = isset($_REQUEST['category']) ? addslashes(trim($_REQUEST['category'])) : 'General';
		$userid=$_SESSION['id'];
		
		if($existingBidId > 0)
		{
			$query="UPDATE `bidding` SET 
			`name`='$name',
			`email`='$email',
			`mobile`='$mobile',
			`charge`='$charge',
			`days`='$day',
			`category`='$category'
			WHERE `bid_id`='$existingBidId' AND `userid`='$userid'";
		}
		else
		{
			$query="INSERT INTO `bidding`( `name`, `email`, `mobile`, `charge`, `days`, `category`, `tenderid`, `userid`) VALUES 
			( '$name', '$email', '$mobile', '$charge', '$day', '$category', '$tenderId','$userid')";
		}
		
		$n=iud($query);
	//$n=mysqli_num_rows($login_data);
	if($n>=0)
	{
			$message = $existingBidId > 0 ? "BID UPDATED SUCCESSFULLY" : "BIDDING SUCCESSFUL";
		 echo'<script>alert("'.$message.'");
window.location="tender.php"		 </script>';
	}
	else
	{
		echo"Something Wrong Try Again";
	}
	}
		
	
			  
			  
			  ?>
                  </div>

</div>
<div class="col-lg-4">
</div>
</div>
</div>
<div class="card-body">
                  
                </div>









<!-- Slideshow 4 -->
			   
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
				<p>Developed By  <a href="http://projecttunnel.com/">Projecttunnel </a></p>
			</div>
		</div>
	   </div>
	</div>
  </div>
<!--footer end here-->
</body>
</html>

