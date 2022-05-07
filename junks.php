auth.php


    <!-- style="padding-bottom:70px !important" -->
    <div class="container my-5 py-3 h-100 shadow" >  
    <div class="row d-flex align-items-center justify-content-center h-100" >
      <div class="col-md-8 col-lg-7 col-xl-6">
          <h2 class="py-5 text-center">Event Management System</h2>
        <img src="../CanoEMS/assets/img/indeximgsvg.svg" class="img-fluid" alt="Phone image">
      </div>
      <!-- login form -->
      <div class="col-md-7 col-lg-5 col-xl-5">
      <!-- style="height: 632px;" -->
                <!-- <ul class="nav nav-tabs nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" id="pills-signin-tab" data-toggle="pill" href="#pills-signin" role="tab" aria-controls="pills-signin" aria-selected="true">Sign In</a> </li>
                    <li class="nav-item"> <a class="nav-link" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">Sign Up</a> </li>
                </ul> -->
                <!-- Login -->
                <div class="tab-content mb-1 border rounded" id="pills-tabContent">
                    <div class="tab-pane fade  show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
                        <div class="col-sm-12 pb-2  rounded pt-4 py-4">
                            <h3 class="mb-3 text-center">Login</h3>
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

