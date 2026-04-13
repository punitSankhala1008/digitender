<?php
include"dbconfig.php";
$n=iud("DELETE FROM `bidding` WHERE bid_id='".$_REQUEST['id']."'");
if($n==1)
{
	echo'<script>alert("tender closed");
	window.location="tables.php";
	</script>';
}
?>