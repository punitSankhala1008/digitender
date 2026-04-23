<?php
include"dbconfig.php";

$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';
$selectedCategorySql = addslashes($selectedCategory);
$filterSql = "";
if($selectedCategory !== "" && $selectedCategory !== "All")
{
  $filterSql = " AND COALESCE(NULLIF(bidding.category,''), NULLIF(tender.category,''), 'General')='".$selectedCategorySql."'";
}
$query="SELECT 
bidding.bid_id,
bidding.name,
bidding.email,
bidding.mobile,
bidding.charge,
bidding.days,
bidding.category AS bid_category,
bidding.tenderid,
tender.city,
tender.sector_name,
tender.category AS tender_category,
COALESCE(NULLIF(bidding.category,''), NULLIF(tender.category,''), 'General') AS normalized_category
FROM bidding 
INNER JOIN tender ON bidding.tenderid=tender.id 
where bidding.status='1'".$filterSql;
$result=select($query);

$categoryResult = select("SELECT DISTINCT COALESCE(NULLIF(bidding.category,''), NULLIF(tender.category,''), 'General') AS category_name FROM bidding INNER JOIN tender ON bidding.tenderid=tender.id WHERE bidding.status='1' ORDER BY category_name ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Tables</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
   <?php include"sidebar.php";?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
            <h2> Admin Dashboard</h2>


       
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
           <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
              <form method="get" class="form-inline" style="margin-bottom:16px; display:flex; gap:8px; align-items:center;">
                <label for="category" style="font-weight:bold; margin-right:8px;">Category</label>
                <select name="category" id="category" class="form-control" style="max-width:220px;">
                  <option value="All" <?=($selectedCategory === '' || $selectedCategory === 'All') ? 'selected' : ''?>>All</option>
                  <?php while($categoryResult && $catRow=mysqli_fetch_assoc($categoryResult)) { ?>
                    <option value="<?=$catRow['category_name']?>" <?=($selectedCategory === $catRow['category_name']) ? 'selected' : ''?>><?=$catRow['category_name']?></option>
                  <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="confirm_tenders.php" class="btn btn-secondary">Reset</a>
              </form>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Charge</th>
                      <th>Days</th>
                      <th>Category</th>
                      <th>City</th>
                      <th>Tender ID</th>
                      <th>Sector Name</th>
                       
                      <th>close</th>
                      
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
					while($r=mysqli_fetch_array($result))
					{
						extract($r);
					
					?>
                    <tr>
                      <td><?=$r['name']?></td>
                      <td><?=$r['email']?></td>
                      <td><?=$r['mobile']?></td>
                      <td><?=$r['charge']?></td>
                      <td><?=$r['days']?></td>
                      <td><?=$r['normalized_category']?></td>
                      <td><?=$r['city']?></td>
                      <td><?=$r['tenderid']?></td>
                      <td><?=$r['sector_name']?></td>
                        <td><a href="delete_bidding.php?id=<?=$r['bid_id']?>"><button class="btn btn-danger">X</button></td>
                    
                      
                      </tr>
                    <?php
					}
					?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; www.digitender.com 2026</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
