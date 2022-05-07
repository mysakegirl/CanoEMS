<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>

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

    $result = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $event_id);
    $resultEvent = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $resultParticipant = mysqli_query($db, "SELECT * FROM `tblparticipants` where eventId = " . $event_id);

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
                                <a class="btn btn-secondary btnBack mb-4" href="events.php"><i class='fa fa-arrow-left'></i> Back</a>&nbsp;
                                <h3 class="textUserColor text-center"><i class="fa fa-clock-o"></i>&nbsp;<?php echo $resultEvent[0]["event_title"] ?> ATTENDANCE</h3><br>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <table class="table table-bordered" id="attendanceTbl">
                                                <thead>
                                                    <tr><td colspan="2"><h5 class="text-center">ATTENDANCE</h5></td></tr>
                                                    <tr>
                                                        <td class="text-center">Name</td>
                                                        <td class="text-center">Clock In</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="col-md-5">
                                                <div class="card text-white bg-info mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center"><?= date("D M d, Y ") ?><span class="timer"></span></h5>
                                                        <hr>
                                                        <form id="attendance_form">
                                                            <input type="text" class="form-control text-center" id="participant_id" placeholder="0" readonly>
                                                            <label for="participant_id" class="text-center">Participant Id</label>
                                                            <input type="text" class="form-control text-center" id="pname_autocomplete" placeholder="Search Participant...">
                                                            <label for="pname_autocomplete" class="text-center">Participant Name</label>
                                                            <input type="submit" value="Save Attendance" id="btnSave" class="btn btn-warning mt-2 w-100">
                                                        </form>
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


            function getDateTime() {
            var now = new Date();
            var hour = now.getHours();
            var minute = now.getMinutes();
            var second = now.getSeconds();
            if (hour.toString().length == 1) {
                hour = '0' + hour;
            }
            if (minute.toString().length == 1) {
                minute = '0' + minute;
            }
            if (second.toString().length == 1) {
                second = '0' + second;
            }
            var time = hour + ':' + minute + ':' + second;
            return time;
        }

        // example usage: realtime clock
        setInterval(function() {
            currentTime = getDateTime();
            $(".timer").text(currentTime);
        }, 1000);

        $('#pname_autocomplete').autocomplete({source: function( request, response ) {
        // Fetch data
        $.ajax({
            url: "fetchData.php",
            type: 'post',
            dataType: "json",
            data: {
                search: request.term
            },
            success: function( data ) {
            response( data );
            }
        });
        },select: function (event, ui) {
            // Set selection
            $('#pname_autocomplete').val(ui.item.label); // display the selected text
            // $('#selectuser_id').val(ui.item.value); // save selected id to input
            return false;
        },
        focus: function(event, ui){
            $( "#pname_autocomplete" ).val( ui.item.label );
            // $( "#selectuser_id" ).val( ui.item.value );
            return false;
        },
        });

        $(".loading").hide();
    });
    </script>
</body>

</html>