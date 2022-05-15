<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants</title>

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

    $resultParticipant = mysqli_query($db, "SELECT * FROM `tblparticipants` where isDeleted = '0' AND eventId = " . $event_id);

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
                                                    <th>PARTICIPANT CODE</th>
                                                    <th>PARTICIPANT NAME</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                while ($row = $resultParticipant->fetch_assoc()) {
                                                    echo "
                                                    <tr row-name='" . $row['participantName'] . "' row-id='" . $row['participantId'] . "'>
                                                        <th scope='row'>" . $row['participantId'] . "</th>
                                                        <td  ref='" . $row['participantCode'] . "'>" . $row['participantCode'] . "</td>
                                                        <td  ref='" . $row['participantName'] . "'>" . $row['participantName'] . "</td>
                                                        <td>
                                                            <button class='btn btn-primary m-1 pt-0 pb-0 btnEditParticipant'><i class='fa fa-edit'></i> Edit</button>
                                                            <button class='btn btn-danger m-1 pt-0 pb-0 btnDeleteParticipant'><i class='fa fa-trash'></i> Delete</button>
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

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title textUserColor"><i class="fa fa-edit"> Edit Participant</i></h3>
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
                                                                <input type="hidden" name="id" id="editid">
                                                                <label for="title">PARTICIPANT NAME</label>
                                                                <input type="text" class="form-control" id="editparticipantname" placeholder="Enter Name" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fa fa-ban'></i> Cancel</button>
                                    <button type="button" class="btn btn-info" id="editParticipant"><i class='fa fa-save'></i> <span class="btnSaveText">Edit</span></button>
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
            });

            $(document).on("click", ".btnEditParticipant", function(e) {
                $("#editModal").modal("show");
                var id = e.target.closest("tr").getAttribute("row-id");
                var name = e.target.closest("tr").getAttribute("row-name");
                $('#editid').val(id);
                $('#editparticipantname').val(name);
            })

            $('#editParticipant').on('click', function(){
                var id = $("#editid").val();
                var participantName = $("#editparticipantname").val();
                if(participantName.trim() != ""){
                    var data = {};
                        data = {
                                "editParticipant":1,
                                "editparticipantId": id,
                                "editparticipantName": participantName
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
                                    Swal.fire('No changes has been done');
                                }
                            }
                        });
                }else{
                    alert('Fill up all fields!');
                }
            });

            $(document).on("click", ".btnDeleteParticipant", function(e) {
                var id = e.target.closest("tr").getAttribute("row-id");
                var name = e.target.closest("tr").getAttribute("row-name");
                var data = {};
                        data = {
                                "deleteParticipant":1,
                                "deleteparticipantId": id,
                            };
                Swal.fire({
                    title: 'Are you sure to delete '+name+'?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
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
                                    Swal.fire('No changes has been done');
                                }
                            }
                        });
                    }
                    });
            })

            $(".loading").hide();
        });
    </script>
</body>

</html>