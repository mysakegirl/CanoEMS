<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CanoEMS/assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CanoEMS/assets/css/index.css">
    <link rel="icon" href="../CanoEMS/assets/img/icon.png" type="image/gif">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    if (!empty($_SESSION['user-ems'])) {
        header("Location: /CanoEMS/");
    }
    ?>

<!-- style="padding-bottom:70px !important" -->
<div class="container my-5 py-3 h-100 shadow" style="width:500px">  
<div class="align-items-center justify-content-center h-100" >

  <!-- login form -->
  <div class="">
  <!-- style="height: 632px;" -->
            <!-- <ul class="nav nav-tabs nav-fill" id="pills-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" id="pills-signin-tab" data-toggle="pill" href="#pills-signin" role="tab" aria-controls="pills-signin" aria-selected="true">Sign In</a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">Sign Up</a> </li>
            </ul> -->
            <!-- Login -->
            <div class="tab-content mb-1 rounded" id="pills-tabContent">
                <div class="tab-pane fade  show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
                    <div class="col-sm-12 pb-2  rounded pt-4 py-4">
                        <h3 class="mb-3">Login</h3>
                        <h5 class="mb-3">Sign into your account</h5><br>
                        <form method="post" id="loginform">
                            <div class="form-group">
                                <label class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label><input type="checkbox" name="condition" id="condition"> Remember me.</label>
                                    </div>
                                    <div class="col text-right textUserColor"> <a href="#" class="textUserColor" data-toggle="modal" data-target="#forgotPass">Forgot Password?</a> </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <input type="submit" name="submit" value="Sign In" class="btn btn-block btnColor">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Sign Up -->
                <div class="tab-pane fade " id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab">
                    <div class="col-sm-12 pb-2 rounded pt-4">
                        <h3 class="mb-3 text-center">Register</h3>
                        <form method="post" id="singnupFrom">
                            <div class="form-group">
                                <label class="font-weight-bold">Name<span class="text-danger">*</span></label>
                                <input type="text" name="flname" id="flname" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="usernameS" id="usernameS" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Re-enter Password" required>
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
                            <div class="form-group mt-4">
                                <input type="submit" name="signupsubmit" id="signupsubmit" value="Sign Up" class="btn btn-block btnColor">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
  </div>
</div>
</div> 
        <!-- Modal for forgot password -->
        <div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" id="forgotpassForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Forgot Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="forgotemail" id="forgotemail" class="form-control" placeholder="Enter your valid email..." required>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sign In</button>
                            <button type="submit" name="forgotPass" class="btn btn-primary"><i class="fa fa-envelope"></i> Send Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>






            
    <script src="../CanoEMS/assets/js/jquery.min.js"></script>
    <script src="../CanoEMS/assets/js/bootstrap/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#signupsubmit").on("click", function(e) {
                e.preventDefault();
                var flname = $("#flname").val();
                var username = $("#usernameS").val();
                var password = $("#password").val();
                var cpassword = $("#cpassword").val();
                var s_question = $("#s_question").val();
                var s_answer = $("#s_answer").val();
                if(flname == "" || s_answer == "" || username == "" || password == "" || cpassword == "" ){
                    alert("Please input all fields!");
                }else{
                if (password != cpassword) {
                    alert("Password Not Match!");
                } else {
                        var data = {
                            'signup': 1,
                            'flname': flname,
                            'username': username,
                            'password': password,
                            's_question': s_question,
                            's_answer': s_answer,
                        };
                        $.ajax({
                            url: "/CanoEMS/methods/authController.php",
                            type: 'POST',
                            data: data,
                            success: function(response) {
                                alert(response);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 500)
                            }
                        });
                    }
                }
            })

            $("#loginform").on("submit", function(e) {
                e.preventDefault();
                var username = $("#username").val();
                var password = $("#loginPassword").val();

                var data = {
                    'login': 1,
                    'username': username,
                    'password': password
                };

                $.ajax({
                    url: "/CanoEMS/methods/authController.php",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        var res = response.split('|');

                        if (response.includes("DEACTIVATED") || response.includes("FOR APPROVAL")) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Account Status: ' + response,
                                text: 'Please contact the Admin to activate your account!'
                            })
                        } else if (res[1] == "success") {
                            if (res[0].includes("FOR APPROVAL") || res[0].includes("ACTIVE") || res[0].includes("INACTIVE")) {
                                window.location.href = "/CanoEMS";
                                return;
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Account Status: ' + res[0],
                                    text: 'Contact the Admin to Approve your account!'
                                })
                                window.location.href = "logout.php";
                            }
                        } else if (response.includes("Account not exist")) {
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: 'Error reponse: ' + res[0],
                            //     text: 'Please click the Sign Up Here below!',
                            //     footer: '<a href="javascript:void(0)" id="gotoSignup">Sign up here</a>'
                            // })
                            Swal.fire({
                                icon: 'error',
                                title: 'Error reponse: ' + res[0],
                                text: 'Ask the administrator to register you an Account.'
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Account Status: ' + res[0],
                                text: (res[0].includes('INACTIVE')) ? 'Contact the Admin to activate.' : 'Your userid/password didn\'t match any account!'
                            })
                        }

                        $("#userId").val("");
                        $("#loginPassword").val("");
                    },
                    error: function(e) {
                        alert(e);
                    }
                });
            })

            $(document).on("click", "#gotoSignup", function() {
                $(".swal2-confirm, #pills-signup-tab").click();
            })
        })
    </script>
</body>

</html>