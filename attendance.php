<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>

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
    // include_once($path . "/CanoEMS/methods/sessionChecker.php");
    include_once($path . "/CanoEMS/db/config.php"); // configuration

    // if ($_SESSION['user-ems']['UserType'] != 'ADMIN') {
    //     header("Location: /CanoEMS");
    // }

    $event_id = $_GET["id"];

    $result = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $event_id);
    $resultEvent = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // $resultParticipant = mysqli_query($db, "SELECT * FROM `tblparticipants` where eventId = " . $event_id);
    // $resultAttendance = mysqli_query($db, "SELECT * FROM `tblparticipantsattendance` tpa INNER JOIN `tblparticipants` tp on tp.participantId = tpa.participantId  where tpa.eventId = " . $event_id);
   
    $resultAttendance = mysqli_query($db, "SELECT * FROM `tblparticipantsattendance` where eventId = " . $event_id);
    ?>
    <div class="wrapper">
        <div class="content w-100 backgroundDarkerColor">
            <nav class="navbar navbar-expand-lg backgroundDarkColor">
                <?php include($path . "/CanoEMS/comp/attendanceNavBar.php") ?>
            </nav>
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                <!-- <a class="btn btn-secondary btnBack mb-4" href="events.php"><i class='fa fa-arrow-left'></i> Back</a>&nbsp; -->
                                <h2 class="textUserColor text-center"><i class="fa fa-clock-o"></i>&nbsp;<?php echo $resultEvent[0]["event_title"] ?> ATTENDANCE</h2><br>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <table class="table table-bordered" id="attendanceTbl">
                                                <thead>
                                                    <tr class="bg-info text-white"><td colspan="3"><h5 class="text-center">ATTENDANCE</h5></td></tr>
                                                    <tr>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Clock In</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                        while ($rowz = $resultAttendance->fetch_assoc()) {
                                                            echo "
                                                        <tr>
                                                            <td ref='" . $rowz['participantName'] . "'>" . $rowz['participantName'] . "</td>
                                                            <td ref='" . $rowz['ClockIn'] . "'>" . $rowz['ClockIn'] . "</td>
                                                        </tr>";
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-5">
                                                <div class="card text-white bg-info mb-3">
                                                    <div class="card-body">
                                                        <input id="attendanceStatusInput" value="<?php echo $resultEvent[0]["attendanceStatus"] ?>" hidden>
                                                        <h5 class="card-title text-center"><span class="dateTdy"><?= date("D M d, Y ") ?></span><span class="timer"></span></h5>
                                                        <hr>
                                                        <div id="attendance_form">
                                                            <div class="form-group">
                                                                <input id="attendanceEventId" value="<?php echo $event_id; ?>" hidden>
                                                               <input type="text" class="form-control text-center" id="inputParticipantName" placeholder="Enter Participant Name...">
                                                            </div>
                                                            <!-- <button id="btnSearch" class="btn btn-warning w-100"><i class="fa fa-search"></i> Search</button> -->
                                                            <button id="btnSubmit" class="btn btn-warning w-100">Submit Attendance</button>
                                                        </div>
                                                        <div class="my-3 text-center" id="attendance_result">
                                                            <h3 class="text-danger">
                                                                The attendance for this event is officially closed. Contact the Administrator for changes.
                                                            </h3>
                                                        </div>
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

            if($('#attendanceStatusInput').val()=="OPEN"){
                // $('#attendance_form').attr('hidden',false);
                $('#attendance_result').attr('hidden',true);
            }else{
                // $('#attendance_form').attr('hidden',true);
                $('#attendance_result').attr('hidden',false);
            }
            
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

        $('#btnSearch').on('click',function(){
            var id = $('#attendanceEventId').val();
            var sContent = $('#pnameOrcode').val();
            $(".loading").show();

            if(sContent.trim() != ""){
                var data = {
                    "searchParticipant": 1,
                    "eventId": id,
                    "pCodeName": sContent.trim()
                };
                $.ajax({
                            url: "/CanoEMS/methods/eventController.php",
                            type: 'POST',
                            data: data,
                            success: function(response) {
                                // alert(response);
                                $('.resultDiv').remove();
                                $('#attendancesearch_result').append(response);
                            }
                        });
            }else{
                alert('Fill up all fields!');
            }

         
        });

        $(document).on("click", "#btnSubmit", function(e) {
            // $id = e.target.closest("tr").getAttribute("row-id");
            // var eventId = $('#attendanceEventId').val();
            var id = $('#attendanceEventId').val();
            var inputPartcipantName = $('#inputParticipantName').val();
            var datetdy = $('.dateTdy').text();
            var getcurrentTime = getDateTime();
            var dateStr = datetdy + getcurrentTime;

            var data = {
                    "participantClockIn": 1,
                    "participantName": inputPartcipantName,
                    "eventId": id,
                    "clockIn": dateStr
                };

            if(inputPartcipantName.trim() != ""){    
               $.ajax({
                    url: "/CanoEMS/methods/eventController.php",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.includes("Successfully")) {
                             Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            // $('.resultDiv').remove();
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000)
                        }
                        else if(response.includes("closed")){
                            Swal.fire({
                                icon: 'warning',
                                title: 'Event Attendance is Closed',
                                text: 'Please contact the administrator to reactivate it.',
                            })
                        } 
                        else {
                            alert(response);
                        }
                    }
                });
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Empty',
                    text: 'Please fill up all fields',
                })
            }
        });
        $(".loading").hide();
    });
    </script>
</body>

</html>