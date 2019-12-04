<?php
    include_once "../settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/ui/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/DatabaseHandler.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/Armor.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/dashboard/DashboardHome.php";

    $armor = new Armor();
    $armor->initDashboard();

    $DashboardHome = new DashboardHome();
    $alert = $DashboardHome->checkForAlerts();

    if($alert["bool"]) {
        $alertColour = "danger";
    } else {
        $alertColour = "success";
    }

    $hide = "";

    if(!($DashboardHome->isUserSupervisor())) {
        $hide = "d-none";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo SITE_NAME; ?> | Dashboard</title>
    <!-- Favicon -->
    <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="../assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
    <link href="../assets/js/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="../assets/css/dashboard.css" rel="stylesheet" />
</head>

<body class="">
<!-- Start: Navbar -->
<?php
    $dashboard = new Dashboard();
    $dashboard->getNavigation(0);
?>
<!-- End: Navbar -->
<div class="main-content">
    <!-- Start: Header -->
    <?php
        $dashboard->getHeader();
    ?>
    <!-- End: Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Orders</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo $DashboardHome->getCurrentWeekOrderCount(); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-success mr-2"><i class="fas fa-arrow-right"></i></span>
                                    <span class="text-nowrap">Since last week</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Alerts</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo $alert["count"]; ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-<?php echo $alertColour; ?> text-white rounded-circle shadow">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <?php echo $alert["msg"]; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--7">
        <div class="row <?php echo $hide; ?>">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">Sales value</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales">
                                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block">Month</span>
                                            <span class="d-md-none">M</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-2 mr-md-0">
                                        <a href="" id="download-total-sales" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block"><i class="fa fa-download"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="chart-content" class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-total-sales" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                                <h2 class="mb-0">Total orders</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-total-orders" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; 2019<a href="" class="font-weight-bold ml-1" target="_blank"><?php echo SITE_NAME; ?></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<!--   Chart JS   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<!--   Dashboard JS   -->
<script src="../assets/js/dashboard.min.js"></script>
<script src="../assets/js/modal-rows.js"></script>
<script src="../assets/js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        dashboardModalsJS();
    });
</script>
</body>

</html>