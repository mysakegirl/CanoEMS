<!DOCTYPE html>
<html lang="en">
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path . "/CanoEMS/methods/sessionChecker.php");
include_once($path . "/CanoEMS/db/config.php"); // configuration
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title><?= $_SESSION['user-ems']['fname'] ?> <?= $_SESSION['user-ems']['lname'] ?></title> -->
    <title>Profile | <?php echo $_SESSION['user-ems']['UserType'] ?></title>
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

    if ($_SESSION['user-ems']['UserType'] != 'TA' && $_SESSION['user-ems']['UserType'] != 'ADMIN') {
        header("Location: /CanoEMS");
    }

    $user_id = $_SESSION['user-ems']['UserID'];

    $result = mysqli_query($db, "SELECT * FROM `tblusers` where UserID = " . $user_id);
    $resultData = mysqli_fetch_all($result, MYSQLI_ASSOC);

    ?>
    <div class="wrapper">

        <nav id="sidebar" class="backgroundDarkColor border-right border-dark">
            <?php 
                if($_SESSION['user-ems']['UserType'] == "ADMIN"){
                     include($path . "/CanoEMS/comp/adminNavBar.php");
                }else{
                    include($path . "/CanoEMS/comp/taNavBar.php");
                }
                
            ?>
        </nav>
        <div class="content w-100 backgroundDarkerColor">
            <nav class="navbar navbar-expand-lg backgroundDarkColor">
                <?php 
                if($_SESSION['user-ems']['UserType'] == "ADMIN"){
                     include($path . "/CanoEMS/comp/commonNavBar.php");
                }else{
                    include($path . "/CanoEMS/comp/taCommonNavBar.php");
                }
                
                ?>
            </nav>
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="/CanoEMS"><i class='fa fa-arrow-left'></i> HOME</a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-3">
                                                            <h2 class="text-center textUserColor">PROFILE <small><a href="javascript:void(0)" id="btnEdit" class="" title="Edit"><i class='fa fa-edit'></i></a></small></h2>
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
                                                <div class="col-sm-2">
                                                    <h5>USER ID:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="user_id" value="<?php echo $resultData[0]["UserID"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <h5>NAME:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="fname" value="<?php echo $resultData[0]["Name"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>USERNAME:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="username" value="<?php echo $resultData[0]["Username"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>USER TYPE:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <h3 class="text-center text-success"><b><?= ($resultData[0]["UserType"] == "TA") ? "TECHNICAL ASSISTANT" : "ADMIN" ?></b></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mt-0">
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>SECURITY QUESTION:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <select class="form-control" name="s_question" id="s_question" require disabled>
                                                                <?php
                                                                if ($resultData[0]["SQuestion"] == null) {
                                                                    echo "<option disabled selected>-- Select a Question --</option>";
                                                                } else {
                                                                    echo "<option value='" . $resultData[0]["SQuestion"] . "' selected>" . $resultData[0]["SQuestion"] . "</option>";
                                                                }
                                                                ?>
                                                                <option value="In what city were you born?">In what city were you born?</option>
                                                                <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                                                                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                                                <option value="What high school did you attend?">What high school did you attend?</option>
                                                                <option value="What is the name of your first school?">What is the name of your first school?</option>
                                                                <option value="What was your favorite food as a child?">What was your favorite food as a child?</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>SECURITY ANSWER:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="s_answer" placeholder="Enter your Answer" value="<?php echo $resultData[0]["SAnswer"] ?>" require disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 btns" style="display: none;">
                                                    <hr>
                                                    <button class="btn btn-success float-right ml-2" id="btnSave"><i class='fa fa-save'></i> Save</button>
                                                    <button class="btn btn-secondary float-right ml-2" id="btnCancel"><i class='fa fa-ban'></i> Cancel</button>
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="/CanoEMS/assets/js/common.js"></script>

    <script>
        $(document).ready(function() {
        
            $("#sidebarCollapse").on('click', function() {
                $("#sidebar").toggleClass('active');
            });

            $(document).on("click", "#btnEdit", function() {
                $("#username, #fname, #s_question, #s_answer").removeAttr("disabled");
                $("#fname").focus();
                $(".btns").show();
            })

            $(document).on("click", "#btnSave", function() {

                var user_id = <?= $resultData[0]["UserID"] ?>;
                var fname = $("#fname").val();
                var username = $("#username").val();
                var s_question = $("#s_question").val();
                var s_answer = $("#s_answer").val();

                if (fname == "" || username == "" || s_question == "" || s_answer == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Field/s Detected!',
                        text: 'Fillout all requried fields.'
                    })
                } else {
                    var data = {
                        'updateuserProfile': 1,
                        'useridUpdateProf': user_id,
                        'flnameUpdateProf': fname,
                        'usernameUpdateProf': username,
                        's_questionUpdateProf': s_question,
                        's_answerUpdateProf': s_answer
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
            })
            $(document).on("click", "#btnCancel", function() {
                window.location.reload()
            })

            $(".loading").hide();
        });
    </script>
</body>

</html>