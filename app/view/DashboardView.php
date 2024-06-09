<?php
require_once 'app/controllers/DashboardController.php';

$user = DashboardController::fetchDataUser();
$materi = DashboardController::fetchDataMateri();
?>

<section class="page-wrapper">
    <?php
    include "components/loading.php";
    ?>
    <?php
    include "partials/sidebar.php";
    ?>
    <div class="main-container">
        <?php
        include "partials/headerContent.php";
        ?>
        <div class="content-wrapper-scroll">

            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xxl-6 col-sm-6 col-12">
                        <div class="stats-tile">
                            <div class="sale-icon shade-blue">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                            <div class="sale-details">
                                <h3 class="text-blue"><?php echo $user; ?></h3>
                                <p>Total User</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-sm-6 col-12">
                        <div class="stats-tile">
                            <div class="sale-icon shade-yellow">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="sale-details">
                                <h3 class="text-yellow"><?php echo $materi; ?></h3>
                                <p>Total Materi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>