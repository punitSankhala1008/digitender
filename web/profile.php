<?php
include "dbconfig.php";

if(!isset($_SESSION['login']) || $_SESSION['login'] !== "yes" || !isset($_SESSION['id']))
{
    echo '<script>alert("Please login first."); window.location="login.php";</script>';
    exit();
}

$userId = (int)$_SESSION['id'];
$successMessage = "";
$errorMessage = "";

if(isset($_POST['update_profile']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    if($name === '' || $email === '' || $mobile === '')
    {
        $errorMessage = "All fields are required.";
    }
    else
    {
        $emailCheck = select("SELECT id FROM registration WHERE email='".addslashes($email)."' AND id!='".$userId."' LIMIT 1");
        $mobileCheck = select("SELECT id FROM registration WHERE mobile='".addslashes($mobile)."' AND id!='".$userId."' LIMIT 1");

        if($emailCheck && mysqli_num_rows($emailCheck) > 0)
        {
            $errorMessage = "Email is already registered with another account.";
        }
        elseif($mobileCheck && mysqli_num_rows($mobileCheck) > 0)
        {
            $errorMessage = "Mobile number is already registered with another account.";
        }
        else
        {
            $updateQuery = "UPDATE registration SET "
                . "name='".addslashes($name)."', "
                . "email='".addslashes($email)."', "
                . "mobile='".addslashes($mobile)."' "
                . "WHERE id='".$userId."'";

            $updateResult = iud($updateQuery);
            if($updateResult >= 0)
            {
                $_SESSION['name'] = $name;
                $_SESSION['user'] = $name;
                $successMessage = "Profile updated successfully.";
            }
            else
            {
                $errorMessage = "Unable to update profile. Please try again.";
            }
        }
    }
}

$query = "SELECT id, name, email, mobile, aadhaar FROM registration WHERE id='".$userId."' LIMIT 1";
$result = select($query);
$user = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;

if(!$user)
{
    echo '<script>alert("Profile not found."); window.location="index.php";</script>';
    exit();
}

$maskedAadhaar = "N/A";
if(isset($user['aadhaar']) && $user['aadhaar'] !== '')
{
    $aadhaar = $user['aadhaar'];
    $len = strlen($aadhaar);
    if($len > 4)
    {
        $maskedAadhaar = str_repeat('X', $len - 4) . substr($aadhaar, -4);
    }
    else
    {
        $maskedAadhaar = $aadhaar;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
        <title>My Profile | DigiTender</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
        <script src="js/jquery.min.js"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="mother-grid">
    <div class="container">
        <div class="temp-padd">
            <div class="top-strip">
                <div class="address">
                    <ul>
                        <li><a href="https://projecttunnel.com/"><span class="link"> </span>www.projecttunnel.com</a></li>
                        <li><a href="mailto:projecttunnel52@gmail.com"><span class="mes"> </span>projecttunnel52@gmail.com</a></li>
                        <li><span class="ph"> </span>9993639672</li>
                    </ul>
                </div>
                <div class="social-icons">
                    <ul>
                        <li><a href="https://www.facebook.com/projecttunnel/"><span class="w-f"> </span></a></li>
                        <li><a href="https://twitter.com/PROJECTTUNNEL1"><span class="w-tw"> </span></a></li>
                        <li><a href="https://www.linkedin.com/in/project-tunnel-75479a164/"><span class="w-in"> </span></a></li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
      </div>

            <div class="title-main">
                <a href="index.php"><h1>DigiTender</h1></a>
      </div>

            <div class="header">
                <div class="navg">
                    <span class="menu"> </span>
                    <?php include "nav.php"; ?>
                    <script>
                        $("span.menu").click(function() {
                            $("ul.res").slideToggle("slow");
                        });
                    </script>
        </div>
                <form method="post" action="search.php">
                    <div class="search">
                        <input type="text" name="tender" placeholder="Tender search" />
                        <input type="submit" name="search" value=""/>
                    </div>
                </form>
                <div class="clearfix"> </div>
            </div>

            <div style="padding: 25px 20px 35px; background: #fff; border: 1px solid #ddd; border-top: 0;">
                <div class="panel panel-default" style="max-width: 760px; margin: 0 auto;">
                    <div class="panel-heading"><h3 class="panel-title">My Profile</h3></div>
                    <div class="panel-body">
                        <?php if($successMessage !== "") { ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php } ?>
                        <?php if($errorMessage !== "") { ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
                        <?php } ?>

                        <table class="table table-striped table-bordered">
                            <tr>
                                <th style="width: 30%;">Name</th>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td><?php echo htmlspecialchars($user['mobile']); ?></td>
                            </tr>
                            <tr>
                                <th>Aadhaar</th>
                                <td><?php echo htmlspecialchars($maskedAadhaar); ?></td>
                            </tr>
                        </table>

                        <hr />
                        <h4>Edit Profile</h4>
                        <form method="post" action="">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required />
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-success">Update Profile</button>
                            |
                            <a href="index.php" class="btn btn-primary">Back to Home</a>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
</div>
</body>
</html>
