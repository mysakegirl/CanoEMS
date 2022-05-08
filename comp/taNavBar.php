<!-- <div class="collapse navbar-collapse " id="navbarNav">
  <a class="navbar-brand" href="/CanoEMS/users/ta/"><i class="fa fa-calendar-check-o">&nbsp;EMS</i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item nav-link">
            <a href="/CanoEMS/users/ta/events.php"><i class="fa fa-calendar-o"></i>&nbsp;Manage Events </a>
        </li>
        <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class='fa fa-cog'></i>
                </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="nav-link dropdown-item" id="cur_isUserSecuritySet" cur-isusersecurityset="<?= $_SESSION['isUserSecuritySet'] ?>" href="#" hidden></a>
                <a class="nav-link dropdown-item" id="cur_user" cur-user-id="<?= $_SESSION['user-ems']['UserID'] ?>" title="View Profile" href="/CanoEMS/profile.php"><i class='fa fa-user'></i> &nbsp;PROFILE</a>
                <a class="nav-link dropdown-item" title="Change Password" href="javascript:void(0)" id="btnChangePassword"><i class='fa fa-key'></i> &nbsp;CHANGE PASSWORD</a>
                <a class="nav-link dropdown-item" title="Logout" href="/CanoEMS/logout.php"><i class='fa fa-sign-out'></i> &nbsp;LOG OUT</a>
            </div>
        </li>
    </ul>
    
</div> -->


<div class="sidebar-header backgroundDarkColor text-center">
    <img src="/CanoEMS/assets/img/mainlogo.png" alt="icon" style="width:180px;">
</div>
<ul class="list-unstyled components">
    <h5 class="mx-2 my-3 textLightAsh">MENUS</h5>
    <li> <a href="/CanoEMS/users/ta"><i class='fa fa-home textUserColor'></i> &nbsp;&nbsp;HOME</a> </li>
    <li> <a href="/CanoEMS/users/ta/events.php"><i class='fa fa-calendar textUserColor'></i> &nbsp;&nbsp;EVENTS</a> </li>
</ul>
