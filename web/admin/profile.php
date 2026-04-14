<?php
include "dbconfig.php";

if(!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== "yes" || !isset($_SESSION['admin_id']))
{
    echo '<script>alert("Please login first."); window.location="index.php";</script>';
    exit();
}

$adminId = (int)$_SESSION['admin_id'];
$successMessage = "";
$errorMessage = "";
$allowedDepartments = array("sales", "marketing", "operations", "finance", "hr", "it", "procurement");

if(isset($_POST['update_admin_profile']))
{
  $email = trim($_POST['email']);
  $department = trim($_POST['department']);
  $newPassword = trim($_POST['new_password']);

  if($email === '' || $department === '')
  {
    $errorMessage = "Email and department are required.";
  }
  elseif(!in_array(strtolower($department), $allowedDepartments, true))
  {
    $errorMessage = "Please select a valid department.";
  }
  else
  {
    $emailCheck = select("SELECT headid FROM head WHERE email='".addslashes($email)."' AND headid!='".$adminId."' LIMIT 1");
    if($emailCheck && mysqli_num_rows($emailCheck) > 0)
    {
      $errorMessage = "Email is already used by another admin.";
    }
    else
    {
      $updateQuery = "UPDATE head SET "
        . "email='".addslashes($email)."', "
        . "department='".addslashes($department)."'";

      if($newPassword !== '')
      {
        $updateQuery .= ", password='".addslashes($newPassword)."'";
      }

      $updateQuery .= " WHERE headid='".$adminId."'";

      $updateResult = iud($updateQuery);
      if($updateResult >= 0)
      {
        $_SESSION['admin_email'] = $email;
        $successMessage = "Admin profile updated successfully.";
      }
      else
      {
        $errorMessage = "Unable to update admin profile. Please try again.";
      }
    }
  }
}

$query = "SELECT headid, email, department FROM head WHERE headid='".$adminId."' LIMIT 1";
$result = select($query);
$admin = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;

if(!$admin)
{
    echo '<script>alert("Profile not found."); window.location="ticket.php";</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Profile</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
  <div id="wrapper">
    <?php include "sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <h4 class="mb-0">Admin Profile</h4>
        </nav>

        <div class="container-fluid">
          <div class="card shadow mb-4" style="max-width: 760px;">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Profile Details</h6>
            </div>
            <div class="card-body">
              <?php if($successMessage !== "") { ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
              <?php } ?>
              <?php if($errorMessage !== "") { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
              <?php } ?>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 35%;">Admin ID</th>
                    <td><?php echo htmlspecialchars($admin['headid']); ?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                  </tr>
                  <tr>
                    <th>Department</th>
                    <td><?php echo htmlspecialchars($admin['department']); ?></td>
                  </tr>
                </table>
              </div>

              <hr>
              <h6 class="font-weight-bold text-primary">Edit Profile</h6>
              <form method="post" action="">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                </div>
                <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" name="department" required>
                    <?php foreach($allowedDepartments as $dept) { ?>
                      <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo (strtolower($admin['department']) === $dept) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars(ucfirst($dept)); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>New Password (optional)</label>
                  <input type="password" class="form-control" name="new_password" placeholder="Leave blank to keep current password">
                </div>
                <button type="submit" name="update_admin_profile" class="btn btn-success">Update Profile</button>
                <a href="ticket.php" class="btn btn-primary">Back to Dashboard</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
