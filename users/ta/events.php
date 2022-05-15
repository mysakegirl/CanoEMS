<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANAGE EVENT | TA</title>

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
            height: 110vh !important;
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

    $result = mysqli_query($db, "SELECT * FROM `tblevent`");

    ?>
    <div class="wrapper">
        <nav id="sidebar" class="backgroundDarkColor border-right border-dark">
            <?php include($path . "/CanoEMS/comp/taNavBar.php") ?>
        </nav>
        <div class="content w-100 backgroundDarkerColor">
            <nav class="navbar navbar-expand-lg backgroundDarkColor">
                <?php include($path . "/CanoEMS/comp/taCommonNavBar.php") ?>
            </nav>
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h4 class="textUserColor"><i class="fa fa-tasks"></i>&nbsp; MANAGE EVENTS</h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- <button class="btn btn-success float-right mb-2" id="addNew"><i class='fa fa-plus'></i> Add New Event</button> -->
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tbl" class="table table-stripe table-condense table-hover">
                                            <thead>
                                                <tr>
                                                    <th>EVENT ID</th>
                                                    <th>EVENT NAME</th>
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>VENUE</th>
                                                    <th>EVENT TITLE</th>
                                                    <th>ATTENDANCE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                while ($row = $result->fetch_assoc()) {
                                                    $attendanceS = '';
                                                    if($row['attendanceStatus'] == "OPEN"){
                                                        $attendanceS = '<div class="alert alert-success  m-1 pt-0 pb-0 text-center" role="alert">
                                                        OPEN
                                                        </div>';
                                                    }else{
                                                        $attendanceS = '<div class="alert alert-danger  m-1 pt-0 pb-0 text-center" role="alert">
                                                        CLOSED
                                                      </div>';
                                                    }

                                                    echo "
                                                    <tr row-id='" . $row['event_id'] . "'>
                                                    <th scope='row'>" . $row['event_id'] . "</th>
                                                    <td ref='" . $row['event_name'] . "'>" . $row['event_name'] . "</td>
                                                    <td ref='" . $row['date'] . "'>" . $row['date'] . "</td>
                                                    <td ref='" . $row['time'] . "'>" . $row['time'] . "</td>
                                                    <td ref='" . $row['venue'] . "'>" . $row['venue'] . "</td>
                                                    <td ref='" . $row['event_title'] . "'>" . $row['event_title'] . "</td>
                                                    <td ref='" . $row['attendanceStatus'] . "'>" . $attendanceS . "</td>
                                                    <td>
                                                        <a href='/CanoEMS/attendance.php?id=" . $row['event_id'] . "' class='btn btn-primary m-1 pt-0 pb-0' target='_blank'><i class='fa fa-clock-o'></i> Attendance</a>
                                                    </td>
                                                </tr>";
                                                }

                                                ?>
                                                        <!-- <a href='/CanoEMS/users/ta/report.php?id=" . $row['event_id'] . "' class='btn btn-warning text-white m-1 pt-0 pb-0'><i class='fa fa-bar-chart'></i> Report</a> -->
                                                        <!-- <a href='/CanoEMS/users/ta/participants.php?id=" . $row['event_id'] . "' class='btn btn-primary m-1 pt-0 pb-0'><i class='fa fa-users'></i> Participants</a> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalHeder">ADDING EVENT</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
                                                <div class="row">
                                                    <input type="hidden" name="id" id="id">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="form-group col-sm-4">
                                                                <label for="title">EVENT NAME</label>
                                                                <input type="text" class="form-control" id="eventname" placeholder="Enter Event Name">
                                                            </div>
                                                            <div class="form-group col-sm-4">
                                                                <label for="location">VENUE</label>
                                                                <input type="text" class="form-control" id="venue" placeholder="Enter Venue">
                                                            </div>
                                                            <div class="form-group col-sm-4">
                                                                <label for="guest">EVENT TITLE</label>
                                                                <input type="text" class="form-control" id="eventtitle" placeholder="Enter Event Title">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <hr>
                                                        <div class="row">
                                                            <h4 class="col-sm-12">EVENT SCHEDULE</h4>
                                                            <div class="form-group col-sm-6">
                                                                <label for="date">DATE</label>
                                                                <input type="date" class="form-control" id="date">
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="time">TIME</label>
                                                                <input type="time" class="form-control" id="time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <hr>
                                                        <div class="row">
                                                            <h4 class="col-sm-6">SPEAKER(S)</h4>
                                                            <div class="col-sm-6">
                                                                <button type="button" class="btn btn-info float-right mb-2" id="addNewSpeaker"><i class='fa fa-plus'></i> Additional Speaker</button>
                                                            </div>
                                                            <div class="col-sm-12">
                                                            <table width="100%" id="speakerTable">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <label for="title">SPEAKER NAME</label>
                                                                                <input type="text" class="form-control" id="speakername1" placeholder="Enter Speaker Name">
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <label for="title">TITLE</label>
                                                                                <input type="text" class="form-control" id="title1" placeholder="Enter Title">
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fa fa-ban'></i> Close</button>
                                    <button type="button" class="btn btn-success" id="saveRecord"><i class='fa fa-save'></i> <span class="btnSaveText">Save</span></button>
                                </div>
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

            $("#addNew").on("click", function() {
                $("#id").val("");
                $("#eventtitle").val("");
                $("#venue").val("");
                $("#date").val("");
                $("#time").val("");
                $("#eventname").val("");
                $("#speakername1").val("");
                $("#title1").val("");

                $("#modalHeder").html("<h3 class='textUserColor'><i class='fa fa-plus'></i>&nbsp;ADD EVENT</h3>");
                $(".btnSaveText").text("SAVE");

                $('#modal').modal('show');
            })

            $('#addNewSpeaker').on("click",function(){
                var rowCount = $('#speakerTable tr').length + 1;
                var app = '<tr><td><div class="form-group"><label for="title">SPEAKER NAME</label><input type="text" class="form-control" id="speakername'+rowCount+'" placeholder="Enter Speaker Name">'+
                            '</div></td><td></td><td><div class="form-group"><label for="title">TITLE</label><input type="text" class="form-control" id="title'+rowCount+'" placeholder="Enter Title">'+
                             '</div></td></tr>';
                $('#speakerTable').append(app);
            });

            var table = $('#tbl').removeAttr('width').DataTable({
                columnDefs: [{
                    width: 200,
                    targets: 2
                }],
                fixedColumns: true
            });

            $("#saveRecord").on("click", function() {
                var id = $("#id").val();
                var event_title = $("#eventtitle").val();
                var venue = $("#venue").val();
                var date = $("#date").val();
                var time = $("#time").val();
                var event_name = $("#eventname").val();
                var arr = [];
                var tableLength = $('#speakerTable tr').length;
                for(var i = 1; i <= tableLength; i++){
                    var objArr = { speakerName:  $('#speakername'+i).val() , title: $('#title'+i).val()};
                    arr.push(objArr);
                }

                var data = {};
                if (id == "") {
                    data = {
                        "save": 1,
                        "eventtitle": event_title,
                        "venue": venue,
                        "date": date,
                        "time": time,
                        "eventname": event_name,
                        "speakerArr":arr
                    };
                } else {
                    data = {
                        "update": 1,
                        "event_id": id,
                        "title": title,
                        "location": location,
                        "date": date,
                        "time": time,
                        "guest": guest
                    };
                }

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
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000)
                        } else {
                            alert(response);
                        }
                    }
                });
            })

            //when the modal closes remove all added speakers
            $('#modal').on('hidden.bs.modal', function () {
                var tableLength = $('#speakerTable tr').length;
                for(var i = tableLength - 1; i > 0; i--){
                    document.getElementById('speakerTable').deleteRow(i);
                }
            });

            // $('#testBtn').on('click',function(){
            //     var tableLength = $('#speakerTable tr').length;
            //     var tbl = document.getElementById('speakerTable');
            //     for(var i = 1; i <= tableLength; i++){
            //         console.log($('#speakername'+i).val());
            //         console.log($('#title'+i).val());
            //     }
            // });

            $(document).on("click", ".btnEdit", function(e) {
                $id = e.target.closest("tr").getAttribute("row-id");
                $title = e.target.closest("tr").children[1].getAttribute("ref");
                $time = e.target.closest("tr").children[2].getAttribute("ref");
                $date = e.target.closest("tr").children[3].getAttribute("ref");
                $location = e.target.closest("tr").children[4].getAttribute("ref");
                $guest = e.target.closest("tr").children[5].getAttribute("ref");

                $("#id").val($id);
                $("#title").val($title);
                $("#location").val($location);
                $("#date").val($date);
                $("#time").val($time);
                $("#guest").val($guest);

                $("#modalHeder").text("UPDATE EVENT");
                $(".btnSaveText").text("UPDATE");

                $('#modal').modal('show');
            })


            $(".loading").hide();
        });
    </script>
</body>

</html>