<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENT INFORMATION | ADMIN</title>

    <link rel="stylesheet" href="/CanoEMS/assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CanoEMS/assets/css/index.css">

    <link rel="icon" href="/CanoEMS/assets/img/icon.png" type="image/gif">
    <link rel="stylesheet" href="/CanoEMS/assets/css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #tbl_filter,
        #tbl_paginate {
            float: right !important;
        }
    </style>
</head>

<body>
    <?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path . "/CanoEMS/methods/sessionChecker.php");
    include_once($path . "/CanoEMS/db/config.php"); // configuration

    if ($_SESSION['user-ems']['UserType'] != 'ADMIN') {
        header("Location: /CanoEMS");
    }

    $event_id = $_GET["id"];

    $resultEventM = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $event_id);
    $resultEventMData = mysqli_fetch_all($resultEventM, MYSQLI_ASSOC);
    $resultEventDetails = mysqli_query($db, "SELECT * FROM `tbleventdetails` where EventId = " . $event_id);

    // $resultEventD = mysqli_query($db, "SELECT * FROM `tblparticipants` where CAST(time_in AS DATE) = '" . $resultEventMData[0]["date"] . "'");

    ?>
    <div class="wrapper">
        <div class="content w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
                <?php include($path . "/CanoEMS/comp/adminNavBar.php") ?>
            </nav>
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id">
                                        <div class="row hide-on-print">
                                            <div class="col-sm-12">
                                                <span class="float-left">
                                                    <small>
                                                        <a class="btn btn-secondary btnBack" href="events.php"><i class='fa fa-arrow-left'></i> Back</a>&nbsp;
                                                        <a class="btn btn-info btnPrint text-white" href="javascript:void(0)"><i class='fa fa-print'></i> Print</a>
                                                        <a class="btn btn-success text-white flaot-right" href="/CanoEMS/eventQR.php?id=<?= $event_id ?>" target="_blank"><i class='fa fa-qrcode'></i> Generate QR</a>
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-3">
                                                            <h2 class="text-center mt-5">EVENT INFORMATION</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h5>EVENT ID:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventId" value="<?php echo $resultEventMData[0]["event_id"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h5>EVENT NAME:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventName" value="<?php echo $resultEventMData[0]["event_name"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h5>VENUE:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventName" value="<?php echo $resultEventMData[0]["venue"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h5>EVENT TITLE:</h5>
                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <input type="text" class="form-control" id="location" value="<?php echo $resultEventMData[0]["event_title"] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>TIME:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventId" value="<?php echo $resultEventMData[0]["time"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>DATE:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventName" value="<?php echo $resultEventMData[0]["date"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr>
                                            <div id="accordion">
                                                <div class="card text-white">
                                                    <div class="card-header  bg-info" id="headingOne">
                                                        <h5 class="mb-0">
                                                            SPEAKERS:
                                                            <button class="btn btnCollapseExpand text-white text-decoration-none float-right" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                <i class='fa fa-minus collapses'></i>
                                                                <i class='fa fa-expand expand d-none'></i>
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="tbl" class="table table-stripe table-hover text-black">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>NAME</th>
                                                                            <th>TITLE</th>
                                                                        </tr>
                                                                   </thead>
                                                                   <tbody>
                                                                    <?php
                                                                            while ($row = $resultEventDetails->fetch_assoc()) {
                                                                                echo "
                                                                            <tr>
                                                                                <td ref='" . $row['SpeakerName'] . "'>" . $row['SpeakerName'] . "</td>
                                                                                <td ref='" . $row['Title'] . "'>" . $row['Title'] . "</td>
                                                                            </tr>";
                                                                            }
                                                                    ?>
                                                                   </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END COLLAPSE -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CARD BODY -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/CanoEMS/assets/js/jquery.min.js"></script>
    <script src="/CanoEMS/assets/js/bootstrap/js/bootstrap.min.js"></script>
    <script src="/CanoEMS/assets/js/datatables.min.js"></script>

    <script type="text/javascript" src="/CanoEMS/assets/js/llqrcode.js"></script>
    <script type="text/javascript" src="/CanoEMS/assets/js/webqr.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="/CanoEMS/assets/js/common.js"></script>

    <script>
        $(document).ready(function() {
            $("#sidebarCollapse").on('click', function() {
                $("#sidebar").toggleClass('active');
            });

            $(".btnCollapseExpand").on("click", function() {
                $(".collapses, .expand").toggleClass("d-none");
            })


            $(document).on("click", ".btnPrint", function() {
                $(".loading").show();
                $(".btnBack, .btnPrint, .hide-on-print").hide();
                $("#sidebar").addClass("active");
                setTimeout(() => {
                    $(".loading").hide();
                    window.print();
                    $(".btnBack, .btnPrint, .hide-on-print").show();
                    $("#sidebar").removeClass("active");
                }, 500);
            })

            $(".loading").hide();
        });
    </script>
</body>

</html>