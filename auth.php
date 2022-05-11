<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CanoEMS/assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CanoEMS/assets/css/index.css">
    <link rel="icon" href="../CanoEMS/assets/img/mainiconlogo.jpg" type="image/gif">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    if (!empty($_SESSION['user-ems'])) {
        header("Location: /CanoEMS/");
    }
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 vh-100" style="background-color: #161D31;  background-image: url('../CanoEMS/assets/img/indeximg.svg'); background-repeat: no-repeat, repeat;background-position: center;">
                <div id="content" style="position: relative;cursor:pointer">
                    <img src="../CanoEMS/assets/img/mainlogo.png" style="position: absolute;top: 0px;left: 0px; width:150px;"/>
                </div>
            </div>
            <div class="col-md-4 vh-100" style="background-color: #283046;">
                    <div class="col-sm-12 pb-2 rounded pt-4  py-4 px-5" style="top: 20%;">
                        <h3 class="mb-3 textLighterPurp">Welcome to EMS!</h3>
                        <h5 class="mb-3 textLightAsh">Sign into your account</h5><br>
                        <form method="post" id="loginform">
                            <div class="form-group">
                                <label class="font-weight-bold textLightAsh">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold textLightAsh">Password <span class="text-danger">*</span></label>
                                <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col textLightAsh">
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