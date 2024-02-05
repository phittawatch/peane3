<?php 
    session_start();
    include 'connect.php';
    if (!isset($_SESSION['user_id_input'])) {
        $_SESSION['msg'] = "กรุณาล็อกอินก่อน!";
        header('location: login_process.php');
        exit();
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['user_id_input']);
        header('location: login_process.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>แผนกคอมพิวเตอร์และเน็ตเวิร์ค กดส.ฉ.3</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <img src="pealogo-removebg.png" alt="Logo" height="30">
                <div class="sidebar-brand-text mx-3">PEA NE3</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <span>COMPUTER AND NETWORK</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                ตัวเลือก
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="MENU.php" target="_blank">
                        <i class="fas fa-fw fa-cog"></i>
                    <span>Switch Management</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

           
        </ul>
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
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                    // Assuming the user's name and surname are stored in a session variable
                                    session_start();
                                    if (isset($_SESSION['user_name']) && isset($_SESSION['user_surname'])) {
                                        echo '<span class="mr-2 d-none d-lg-inline text-gray-600 small">' . $_SESSION['user_name'] . ' ' . $_SESSION['user_surname'] . '</span>';
                                    } else {
                                        // If not in session, fetch from the database
                                        include 'connect.php';
                                        $user_id_in = $_SESSION['user_id_input'];
                                        $sql_user_info = "SELECT name, surname FROM users_id WHERE user_id_database = '$user_id_in'";
                                        $result_user_info = $conn->query($sql_user_info);
                                        
                                        if ($result_user_info->rowCount() > 0) {
                                            $user_info = $result_user_info->fetch(PDO::FETCH_ASSOC);
                                            echo '<span class="mr-2 d-none d-lg-inline text-gray-600 small">' . $user_info['name'] . ' ' . $user_info['surname'] . '</span>';
                                        } else {
                                            // Default if user info not found
                                            echo '<span class="mr-2 d-none d-lg-inline text-gray-600 small">User</span>';
                                        }
                                    }
                                    ?>
                                    
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">แผนกคอมพิวเตอร์และเครือข่าย</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <?php
$switchTypes = ['dell', 'riujie', 'zerotrust', 'watchguard', 'fortigate'];
foreach ($switchTypes as $switchType) {
    $switchName = ucfirst($switchType); // Capitalize the first letter
    $sql = "SELECT COUNT(DISTINCT {$switchType}_ip) as {$switchType}_count FROM place_ne3 WHERE {$switchType}_name IS NOT NULL";
    $query = $conn->prepare($sql);
    $query->execute();
    $fetch = $query->fetch();

    // Dynamic class based on switch type for original color
    $borderClass = '';
    switch ($switchType) {
        case 'dell':
            $borderClass = 'border-left-primary';
            break;
        case 'riujie':
            $borderClass = 'border-left-success';
            break;
        case 'zerotrust':
            $borderClass = 'border-left-info';
            break;
        case 'watchguard':
            $borderClass = 'border-left-warning';
            break;
        case 'fortigate':
            $borderClass = 'border-left-danger';
            break;
    }
?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card <?= $borderClass ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Switch <?= $switchName ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $fetch["{$switchType}_count"] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-server fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

</div>




                    <!-- Content Row -->

                    <div class="row">
                    <?php
// Assuming the database connection is already established ($conn variable)

// Query to retrieve data with non-NULL IP addresses
$sql = "SELECT name_place_device, device_name, status FROM ping_results WHERE ip_address IS NOT NULL";
$query = $conn->prepare($sql);
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row min-vh-100">
<div class="col-xl-12 mb-4">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Switch Status</h6>
            </div>
            <div class="card-body d-flex flex-column">
                <div class="table-responsive flex-grow-1">
                    <table class="table table-bordered w-100" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>การไฟฟ้า</th>
                                <th>สถานะ</th>
                                <th>ชื่ออุปกรณ์</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?= $row['name_place_device'] ?></td>
                                    <?php if ($row['status'] === 'Up'): ?>
                                    <td style="color: green;"><?= $row['status'] ?></td>
                                    <?php else: ?>
                                    <td style="color: red;"><?= $row['status'] ?></td>
                                    <?php endif; ?>
                                    <td><?= $row['device_name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



                <!-- /.container-fluid -->

                        <!-- Pie Chart -->
                        
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4" style="height: 250px;">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Switch PEA NE3</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                    <?php
                                            // Fetch switch status counts from ping_results table
                                            $statuses = ['Up', 'Down'];

                                            foreach ($statuses as $status) {
                                                $sql = "SELECT COUNT(DISTINCT ip_address) as status_count FROM ping_results WHERE status = :status AND ip_address IS NOT NULL";
                                                $query = $conn->prepare($sql);
                                                $query->bindParam(':status', $status, PDO::PARAM_STR);
                                                $query->execute();
                                                $result = $query->fetch();

                                                // Display switch status count
                                                echo '<div>';
                                                echo '<p style="font-size: 22px; font-weight: bold; color: ' . ($status == 'Up' ? 'green' : 'red') . ';">' . $status . ' switches: ' . $result['status_count'] . '</p>';
                                                echo '</div>';

                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                       
                <!-- /.container-fluid -->

            </div>
        
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อความจากระบบ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">คุณต้องการจะ Logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login_process.php">Logout</a>
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
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>