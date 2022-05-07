<div class="collapse navbar-collapse " id="navbarNav">
  <a class="navbar-brand" href="/CanoEMS/users/admin/"><i class="fa fa-calendar-check-o">&nbsp;EMS</i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                MANAGE <i class='fa fa-angle-down'></i>
                </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/CanoEMS/users/admin/users.php"><i class='fa fa-users'></i> USERS</a> 
                <a class="dropdown-item" href="/CanoEMS/users/admin/events.php"><i class='fa fa-calendar'></i> EVENTS</a>
            </div>
        </li>
        <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class='fa fa-cog'></i>
                </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="nav-link dropdown-item" id="cur_user" cur-user-id="<?= $_SESSION['user-ems']['UserID'] ?>" title="View Profile" href="/CanoEMS/profile.php"><i class='fa fa-user'></i> &nbsp;PROFILE</a>
                <?php 
                    if($_SESSION['isUserSecuritySet'] == 'true'){
                        echo '<a class="nav-link dropdown-item" title="Change Password" href="javascript:void(0)" id="btnChangePassword"><i class="fa fa-key"></i> &nbsp;CHANGE PASSWORD</a>';
                    }else{
                        echo '<button class="nav-link dropdown-item" title="Change Password" onclick="alert(`Set up your security question to gain access on change password.`)" id="btnFalseSecurity"><i class="fa fa-key"></i> &nbsp;CHANGE PASSWORD</button>';
                    }
                ?>
                <a class="nav-link dropdown-item" title="Logout" href="/CanoEMS/logout.php"><i class='fa fa-sign-out'></i> &nbsp;LOG OUT</a>
            </div>
        </li>
    </ul>
    
</div>

<!-- <script>
    $(document).ready(function(){
        $("#btnFalseSecurity").on("click", async function() {
        Swal.fire({
            icon: "error",
            title: "Failed to change password",
            text: '',
        });
    });
});
</script> -->
<!-- <p class="fixed-bottom text-center m-0">Copyright ©2021 EVENT MANAGEMENT SYSTEM USING QR CODE.</p> -->