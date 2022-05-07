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
                                    <div class="row">
                                   
                                     <div class="col-sm-8">
                                            <h4 class="textUserColor"><i class="fa fa-users"></i>&nbsp;<?php echo $resultEvent[0]["event_title"] ?> PARTICIPANTS</h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-success float-right mb-2" id="addNew"><i class='fa fa-plus'></i> Add Participant</button>
                                        </div>
                                    </div><br>
                                    <div class="table-responsive">
                                        <table id="tbl" class="table table-striped table-condense table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>PARTICIPANT NAME</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                while ($row = $resultParticipant->fetch_assoc()) {
                                                    echo "
                                                    <tr row-id='" . $row['participantId'] . "'>
                                                        <th scope='row'>" . $row['participantId'] . "</th>
                                                        <td ref='" . $row['participantName'] . "'>" . $row['participantName'] . "</td>
                                                        <td>
                                                            <a href='/CanoEMS/users/admin/event.php?id=" . $row['participantId'] . "' class='btn btn-primary m-1 pt-0 pb-0'><i class='fa fa-edit'></i> Edit</a>
                                                            <a href='/CanoEMS/users/admin/participants.php?id=" . $row['participantId'] . "' class='btn btn-danger m-1 pt-0 pb-0'><i class='fa fa-trash'></i> Delete</a>
                                                        </td>
                                                    </tr>";
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

    <div id="modal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalHeder">ADDINGA PARTICIPANT</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="form-group col-sm-12">
                                                                <input type="hidden" name="id" id="id" value='<?php echo $event_id; ?>'>
                                                                <label for="title">PARTICIPANT NAME</label>
                                                                <input type="text" class="form-control" id="participantname" placeholder="Enter Name" autocomplete="off">
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
                                    <button type="button" class="btn btn-success" id="saveParticipant"><i class='fa fa-save'></i> <span class="btnSaveText">Save</span></button>
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


            $("#addNew").on("click", function() {
                $("#participantname").val("");

                $("#modalHeder").html("<h3 class='textUserColor'><i class='fa fa-user'></i>&nbsp;NEW PARTICIPANT</h3>");
                $(".btnSaveText").text("SAVE");

                $('#modal').modal('show');
            })

            
            $("#saveParticipant").on("click", function() {
                var id = $("#id").val();
                var participantName = $("#participantname").val();
                if(participantName.trim() != ""){
                    var data = {};
                        data = {
                                "addParticipant":1,
                                "eventId": id,
                                "participantName": participantName
                            };
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
                }else{
                   alert('Fill up all fields!');
                }
            })
            $(".loading").hide();
        });
    </script>
</body>

</html>