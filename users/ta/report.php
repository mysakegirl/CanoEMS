<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Attendance</title>

    <link rel="stylesheet" href="/CanoEMS/assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CanoEMS/assets/css/index.css">

    <link rel="icon" href="/CanoEMS/assets/img/mainiconlogo.jpg" type="image/gif">
    <link rel="stylesheet" href="/CanoEMS/assets/css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #tbl_filter,
        #tbl_paginate {
            float: right !important;
        }
        .content-wrapper {
            height: 100vh !important;
        }

        #v {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path . "/CanoEMS/methods/sessionChecker.php");
    include_once($path . "/CanoEMS/db/config.php"); // configuration

    if ($_SESSION['user-ems']['UserType'] != 'TA') {
        header("Location: /CanoEMS");
    }

    $event_id = $_GET["id"];

    $result = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $event_id);
    $resultEvent = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $resultAttendance = mysqli_query($db, "SELECT * FROM `tblparticipantsattendance` tpa INNER JOIN `tblparticipants` tp on tp.participantId = tpa.participantId  where tpa.eventId = " . $event_id);

    ?>
    <div class="wrapper">
        <nav id="sidebar" class="backgroundDarkColor border-right border-dark">
            <?php include($path . "/CanoEMS/comp/taNavBar.php") ?>
        </nav>
        <div class="content w-100">
            <nav class="navbar navbar-expand-lg backgroundDarkColor">
                <?php include($path . "/CanoEMS/comp/taCommonNavBar.php") ?>
            </nav>
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                <a class="btn btn-secondary btnBack mb-4" href="events.php"><i class='fa fa-arrow-left'></i> Back</a>&nbsp;
                                <a class="btn btn-info btnPrint text-white" style="float:right" href="javascript:void(0)"><i class='fa fa-print'></i> Print</a>
                                <h2 class="textUserColor text-center"><?php echo $resultEvent[0]["event_title"] ?> ATTENDANCE REPORT</h2><br>
                                    <div class="container">
                                        <table class="table table-bordered border">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Clock In</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                        $No = 1;
                                                        while ($rowz = $resultAttendance->fetch_assoc()) {
                                                            echo "
                                                        <tr>
                                                            <td ref='" . $No . "'>" . $No . "</td>
                                                            <td ref='" . $rowz['participantName'] . "'>" . $rowz['participantName'] . "</td>
                                                            <td ref='" . $rowz['ClockIn'] . "'>" . $rowz['ClockIn'] . "</td>
                                                        </tr>";
                                                            $No++;
                                                        }
                                                    ?>
                                            </tbody>
                                        </table>
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
    <style>
        table.dataTable td.dataTables_empty {
            text-align: center;    
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#sidebarCollapse").on('click', function() {
                $("#sidebar").toggleClass('active');
            });
            
            var table = $('#tbl').removeAttr('width').DataTable({
                fixedColumns: true
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