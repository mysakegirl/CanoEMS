<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS | ADMIN</title>

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

        .w-24 {
            width: 24%;
        }

        .swal2-html-container {
            overflow: hidden !important;
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

    if ($_SESSION['user-ems']['UserType'] != 'ADMIN') {
        header("Location: /CanoEMS");
    }

    $resultMedical = mysqli_query($db, "SELECT * FROM `tblusers` where UserID != " . $_SESSION['user-ems']['UserID']);

    $resultUserQuery = mysqli_query($db, "SELECT COUNT(*) FROM `tblusers`");
    $rowx = mysqli_fetch_array($resultUserQuery);
    $userCount = $rowx[0] + 1;

    ?>
    <div class="wrapper">
        <nav id="sidebar" class="backgroundDarkColor border-right border-dark">
            <?php include($path . "/CanoEMS/comp/adminNavBar.php") ?>
        </nav>
        <div class="content w-100 backgroundDarkerColor">
            <nav class="navbar navbar-expand-lg backgroundDarkColor">
                <?php include($path . "/CanoEMS/comp/commonNavBar.php") ?>
            </nav>
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                           <h3 class="textUserColor"> <i class="fa fa-users"></i> USERS MANAGEMENT</h3><br>
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-success float-right mb-2" id="addNewUser"><i class='fa fa-plus'></i> Add New User</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tbl" class="table table-stripe">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th class="w-24" scope="col">NAME</th>
                                                    <th class="w-12" scope="col">USERNAME</th>
                                                    <th class="w-24" scope="col">TYPE</th>
                                                    <th class="w-12" scope="col">STATUS</th>
                                                    <th scope="col">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                while ($row = $resultMedical->fetch_assoc()) {

                                                    $action_element = "";
                                                    if ($row['Status'] == "FOR APPROVAL") {
                                                        $action_element = "<div class='col-sm-7 pr-1 pl-1'><button class='btn btn-info w-100 btnApprove p-1'><i class='fa fa-thumbs-up'></i> APPROVE</button></div>";
                                                    } else if ($row['Status'] == "ACTIVE") {
                                                        $action_element = "<div class='col-sm-7 pr-1 pl-1'><button class='btn btn-danger w-100 btnDeactivate p-1'><i class='fa fa-ban'></i> DEACTIVATE</button></div>";
                                                    } else {
                                                        $action_element = "<div class='col-sm-7 pr-1 pl-1'><button class='btn btn-success w-100 btnActivate p-1'><i class='fa fa-toggle-on'></i> ACTIVATE</button></div>";
                                                    }
                                                    echo "
                                                    <tr row-id='" . $row['UserID'] . "'>
                                                        <th scope='row'>" . $row['UserID'] . "</th>
                                                        <td ref='" . $row['Name'] . "'>" . $row['Name'] . "</td>
                                                        <td ref='" . $row['Username'] . "'>" . $row['Username'] . "</td>
                                                        <td ref='" . $row['UserType'] . "'>" . (($row['UserType'] == 'TA') ? 'TECHNICAL ASSISTANT' : $row['UserType']) . "</td>
                                                        <td ref='" . $row['Status'] . "'>" . $row['Status'] . "</td>
                                                        <td><div class='row'>" .
                                                        $action_element .
                                                        "</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">-</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="approveMessage d-none">
                                    <label for="confirmAccountType">Select Account type</label>
                                    <select class="form-control" id="confirmAccountType">
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="TA">TECHNICAL ASSISTANT</option>
                                    </select>
                                </div>
                                <div class="activateMessage d-none">
                                    <div class="alert alert-danger" role="alert">
                                        Account will be Activated! <b>Continue activate?</b>
                                    </div>
                                </div>
                                <div class="deactivateMessage d-none">
                                    <div class="alert alert-danger" role="alert">
                                        Account will be deactivated! <b>Continue deactivate?</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="btnConfirmApprove" class="btn btn-success d-none">Approve</button>
                            <button type="button" id="btnConfirmActivate" class="btn btn-success d-none">Activate</button>
                            <button type="button" id="btnConfirmDeactivate" class="btn btn-danger d-none">Deactivate</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Update User -->
            <div class="modal fade" id="modalUpdateUser" tabindex="-1" role="dialog" aria-labelledby="modalUpdateUserTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title textUserColor" id="modalUpdateUserTitle"><i class="fa fa-pencil-square-o"></i>&nbsp; UPDATE USER DETAILS</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="singnupFrom">
                                <input type="hidden" name="user_id" id="user_id">
                                <div class="form-group">
                                    <label class="font-weight-bold">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="flname" id="flname" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="usernameS" id="usernameS" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Password <span class="text-danger">*</span> <input type="checkbox" name="passwordCheck" id="passwordCheck"> <small><i>Check this box to edit password</i></small></label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required disabled>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Security Question<span class="text-danger">*</span></label>
                                    <select class="form-control" name="s_question" id="s_question" require>
                                        <option value="In what city were you born?">In what city were you born?</option>
                                        <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                        <option value="What high school did you attend?">What high school did you attend?</option>
                                        <option value="What is the name of your first school?">What is the name of your first school?</option>
                                        <option value="What was your favorite food as a child?">What was your favorite food as a child?</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Answer<span class="text-danger">*</span></label>
                                    <input type="text" name="s_answer" id="s_answer" class="form-control" placeholder="Answer" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fa fa-ban'></i> Cancel</button>
                            <button type="button" id="btnUpdate" class="btn btn-success"><i class='fa fa-save'></i> Update</button>
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
                                                            <div class="form-group col-sm-6">
                                                                <label for="title">Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="flName" placeholder="Enter Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <hr>
                                                        <div class="row">
                                                            <h4 class="col-sm-12">ACCOUNT INFORMATION</h4>
                                                            <div class="form-group col-sm-6">
                                                                <label for="usernameSave">Username</label>
                                                                <input type="text" class="form-control" id="usernameSave" readonly>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="passwordSave">Password</label>
                                                                <input type="password" class="form-control" id="passwordSave" readonly>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="time">User Type<span class="text-danger">*</span></label>
                                                                <select class="form-control" id="usertype">
                                                                    <option value="" selected>-- Select User Type --</option>
                                                                    <option value="ADMIN">Admin</option>
                                                                    <option value="TA">Technical Assistant</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="time">Status<span class="text-danger">*</span></label>
                                                                <select class="form-control" id="status">
                                                                    <option value="" selected>-- Select Status --</option>
                                                                    <option value="FORAPPROVAL">FOR APPROVAL</option>
                                                                    <option value="ACTIVE">ACTIVE</option>
                                                                </select>
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
                                    <button type="button" class="btn btn-success" id="saveUser"><i class='fa fa-save'></i> <span class="btnSaveText">Save</span></button>
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
    <!-- <div class='col-sm-5 pr-1 pl-1'><button class='btn btn-secondary w-100 btnModify p-1'><i class='fa fa-edit'></i>&nbsp;Modify</button></div></div> -->
    <script>
        $(".loading").show();
        $(document).ready(function() {
            $("#addNewUser").on("click", function() {
                $("#flName").val("");
                $("#usernameSave").val('<?php echo 'user'.$userCount ?>');
                $("#passwordSave").val('<?php echo 'user'.$userCount ?>');
                $("#usertype").val("");
                $("#status").val("");
              
                $("#modalHeder").html("<h3 class='textUserColor'><i class='fa fa-plus'></i>&nbsp;ADD USER</h3>");
                $(".btnSaveText").text("SAVE");

                $('#modal').modal('show');
            })

            $(".loading").hide();

            var table = $('#tbl').removeAttr('width').DataTable();

            var data = {};

            $(document).on("click", ".btnApprove", function(e) {
                $("#exampleModalLongTitle").text("Approve Account");
                $(".approveMessage, #btnConfirmApprove").removeClass("d-none");
                $(".activateMessage, #btnConfirmActivate").addClass("d-none");
                $(".deactivateMessage, #btnConfirmDeactivate").addClass("d-none");
                $("#exampleModalCenter").modal("show");

                var id = e.target.closest("tr").getAttribute("row-id");
                var is_active = e.target.closest("tr").children[3].getAttribute("ref");
                var type = e.target.closest("tr").children[4].getAttribute("ref");

                data = {
                    "approve": 1,
                    "user_id": id,
                    "type_of_user": ""
                }
            })

            $("#btnConfirmApprove").on("click", function() {
                data.type_of_user = $("#confirmAccountType").val();

                $.ajax({
                    url: "/CanoEMS/methods/authController.php",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response.includes("success")) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Account Approved successfully.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500)
                        } else {
                            alert("ERROR");
                            setTimeout(function() {
                                window.location.reload();
                            }, 500)
                        }
                    }
                });
            })

            $(document).on("click", ".btnActivate", function(e) {
                $("#exampleModalLongTitle").text("Account Activation");
                $(".approveMessage, #btnConfirmApprove").addClass("d-none");
                $(".activateMessage, #btnConfirmActivate").removeClass("d-none");
                $(".deactivateMessage, #btnConfirmDeactivate").addClass("d-none");
                $("#exampleModalCenter").modal("show");

                var id = e.target.closest("tr").getAttribute("row-id");

                data = {
                    "activate": 1,
                    "user_id": id,
                }
            })

            $("#btnConfirmActivate").on("click", function() {
                $.ajax({
                    url: "/CanoEMS/methods/authController.php",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response.includes("success")) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Account Activated successfully.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500)
                        } else {
                            alert("ERROR");
                            setTimeout(function() {
                                window.location.reload();
                            }, 500)
                        }
                    }
                });
            })

            $(document).on("click", ".btnDeactivate", function(e) {
                $("#exampleModalLongTitle").text("Deactivate Account");
                $(".approveMessage, #btnConfirmApprove").addClass("d-none");
                $(".activateMessage, #btnConfirmActivate").addClass("d-none");
                $(".deactivateMessage, #btnConfirmDeactivate").removeClass("d-none");
                $("#exampleModalCenter").modal("show");

                var id = e.target.closest("tr").getAttribute("row-id");

                data = {
                    "deactivate": 1,
                    "user_id": id,
                }
            })

            $("#btnConfirmDeactivate").on("click", function() {
                $.ajax({
                    url: "/CanoEMS/methods/authController.php",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response.includes("success")) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Account Deactivated successfully.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500)
                        } else {
                            alert("ERROR");
                            setTimeout(function() {
                                window.location.reload();
                            }, 500)
                        }
                    }
                });
            })

            $(document).on("click", ".btnModify", function(e) {
                $id = e.target.closest("tr").getAttribute("row-id");

                $.ajax({
                    url: "/CanoEMS/methods/authController.php",
                    type: 'POST',
                    data: {
                        "getuser": 1,
                        "user_id": $id
                    },
                    success: function(response) {
                        if (response.includes("error")) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed Retrieving Data',
                                text: response
                            })
                        } else {

                            response = JSON.parse(response);
                            $("#user_id").val($id);
                            $("#flname").val(response.Name);
                            $("#usernameS").val(response.Username);
                            $("#s_question").val(response.SQuestion).trigger("change");
                            $("#s_answer").val(response.SAnswer);
                            $('#modalUpdateUser').modal('show');
                        }
                    }
                });
            })

            $("#passwordCheck").change(function() {
                if ($(this).is(':checked')) {
                    $("#password").removeAttr("disabled");
                    $("#password").focus();
                } else {
                    $("#password").val("");
                    $("#password").attr("disabled", "");
                }
            })

            $("#btnUpdate").on("click", function() {
                var user_id = $("#user_id").val();
                var flname = $("#flname").val();
                var username = $("#usernameS").val();
                var password = ($("#passwordCheck").is(':checked')) ? $("#password").val() : null;
                var s_question = $("#s_question").val();
                var s_answer = $("#s_answer").val();

                if (flname == "" || username == "" || s_question == "" || s_answer == "" || (password == "" && $("#passwordCheck").is(':checked'))) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Field/s Detected!',
                        text: 'Fillout all requried fields.'
                    })
                } else {
                    var data = {
                        'updateuser': 1,
                        'user_id': user_id,
                        'flname': flname,
                        'username': username,
                        'password': password,
                        's_question': s_question,
                        's_answer': s_answer
                    };

                    $.ajax({
                        url: "/CanoEMS/methods/authController.php",
                        type: 'POST',
                        data: data,
                        success: function(response) {
                            if (response.includes("success")) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Account Updated successfully.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1500)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to update.',
                                    text: response
                                })
                            }
                        }
                    });
                }
            });

            $("#saveUser").on("click", function() {
                var flName = $("#flName").val();
                var usernameSave = $("#usernameSave").val();
                var passwordSave = $("#passwordSave").val();
                var usertype = $("#usertype").val();
                var status = $("#status").val();
                var statusFormat = (status == "FORAPPROVAL" ? "FOR APPROVAL" : status);
                var data = {};
                if(flname == "" || usertype == "" || status == ""){
                    Swal.fire({
                                icon: 'error',
                                title: 'Empty Field/s Detected!',
                                text: 'Fill up all required fields.'
                            })
                }else{
                        data = {
                            "adminsaveUser": 1,
                            "flName": flName,
                            "usernameSave": usernameSave,
                            "passwordSave": passwordSave,
                            "usertype": usertype,
                            "status": statusFormat,
                    };
                        $.ajax({
                        url: "/CanoEMS/methods/authController.php",
                        type: 'POST',
                        data: data,
                        success: function(response) {
                                if (response.includes("Successfully")) {
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Account Successfully Created.',
                                    showConfirmButton: false,
                                    timer: 1000
                                    });
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1000);
                            } else {
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Empty Field/s Detected!',
                                    text: response
                                });
                            }
                        }
                    });
                }
            })

        });
    </script>
</body>

</html>