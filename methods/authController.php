<?php
// session_destroy();
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
// $path .= "/hms/components/adminNavBar.php";
// include_once($path);

include_once($path . "/CanoEMS/db/config.php");

// initialize variables
$user_id = 0;
$fname = "";
$lname = "";
$username = "";
$password = "";
$type_of_user = "";
$status = "";
$s_question = "";
$s_answer = "";

if (isset($_POST['signup'])) {
    $flname = $_POST['flname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $s_question = $_POST['s_question'];
    $s_answer = $_POST['s_answer'];
    $query = "INSERT INTO `tblusers`(`Name`, `Password`, `SAnswer`, `SQuestion`, `Status`,`Username`,`UserType`) VALUES ('" . $flname . "','" . $password . "','" . $s_answer . "','" . $s_question . "','FOR APPROVAL','" . $username . "','TBD')";
    $insertResult = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        echo "success";
    } else {
        echo "error";
    }
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($db, "SELECT * FROM `tblusers` WHERE Username = '$username'");
    $resCount = mysqli_num_rows($result);
    if ($resCount == 0) {
        echo "Account not exist";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $row_val = $row['Password'];

            if ($row['Status'] != "ACTIVE") {
                echo $row['Status'];
            } else if (password_verify($password, $row_val)) {
                echo $row['Status'];
                echo "|success|";
                $_SESSION['user-ems'] = $row;

                if($row['SAnswer'] == '' || $row['SQuestion'] == ''){
                    $_SESSION['isUserSecuritySet'] = 'false';
                }else{
                    $_SESSION['isUserSecuritySet'] = 'true';
                }

            } else {
                echo "Wrong Password";
            }
        }
        // echo mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['activate'])) {
    $user_id = $_POST['user_id'];

    $result = mysqli_query($db, "UPDATE `tblusers` SET `Status`='ACTIVE' WHERE UserID = " . $user_id);
    if (mysqli_affected_rows($db) > 0) {
        echo "success";
    } else {
        echo mysqli_error($db);
    }
}

if (isset($_POST['deactivate'])) {
    $user_id = $_POST['user_id'];

    $result = mysqli_query($db, "UPDATE `tblusers` SET `Status`='INACTIVE' WHERE UserID = " . $user_id);
    if (mysqli_affected_rows($db) > 0) {
        echo "success";
    } else {
        echo mysqli_error($db);
    }
}

if (isset($_POST['approve'])) {
    $user_id = $_POST['user_id'];
    $type_of_user = $_POST['type_of_user'];

    $result = mysqli_query($db, "UPDATE `tblusers` SET `Status`='ACTIVE',`UserType`='" . $type_of_user . "' WHERE UserID = " . $user_id);
    if (mysqli_affected_rows($db) > 0) {
        echo "success";
    } else {
        echo mysqli_error($db);
    }
}

if (isset($_POST['getuser'])) {
    $user_id = $_POST['user_id'];

    $result = mysqli_query($db, "SELECT * FROM `tblusers` WHERE UserID = " . $user_id);
    if (mysqli_affected_rows($db) > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo "error: " . mysqli_error($db);
    }
}

if (isset($_POST['updatecurrentuserpassword'])) {
    $user_id = $_POST['user_id'];
    $oldpassword = $_POST['oldpassword'];
    $password = $_POST['password'];

    $result = mysqli_query($db, "SELECT * FROM `tblusers` WHERE UserID = $user_id");
    $row   = mysqli_fetch_row($result);

    if (password_verify($oldpassword, $row[4])) {
        $newPass = password_hash($password, PASSWORD_DEFAULT);
        $insertResult = mysqli_query($db, "UPDATE `tblusers` SET `Password`='$newPass' WHERE UserID = $user_id");
        if (mysqli_affected_rows($db) > 0) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        echo "Reason: Wrong Old Password";
    }

    // $result = mysqli_query($db, "UPDATE `tblusers` SET `password`='$password' WHERE `user_id`= " . $user_id);
    // if (mysqli_affected_rows($db) > 0) {
    //     echo "success";
    // } else {
    //     echo "error: " . mysqli_error($db);
    // }
}

if (isset($_POST['updateuser'])) {
    $user_id = $_POST['user_id'];
    $flname = $_POST['flname'];
    $username = $_POST['username'];
    $password = ($_POST['password'] == null) ? "" : ",`Password`= '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "'";
    $s_question = $_POST['s_question'];
    $s_answer = $_POST['s_answer'];

    if($_POST['password'] == null){
        $result = mysqli_query($db, "UPDATE `tblusers` SET `Name`='$flname',`Username`='$username',`SQuestion`='$s_question',`SAnswer`='$s_answer' WHERE `UserID`= " . $user_id);
    }else{
        $result = mysqli_query($db, "UPDATE `tblusers` SET `Name`='$flname'" . $password . ",`Username`='$username',`SQuestion`='$s_question',`SAnswer`='$s_answer' WHERE `UserID`= " . $user_id);
    }

    if (mysqli_affected_rows($db) > 0) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($db);
    }
}

//update user profile
if (isset($_POST['updateuserProfile'])) {
    $user_id = $_POST['useridUpdateProf'];
    $flname = $_POST['flnameUpdateProf'];
    $username = $_POST['usernameUpdateProf'];
    $s_question = $_POST['s_questionUpdateProf'];
    $s_answer = $_POST['s_answerUpdateProf'];

    $result = mysqli_query($db, "UPDATE `tblusers` SET `Name`='$flname',`Username`='$username',`SQuestion`='$s_question',`SAnswer`='$s_answer' WHERE `UserID`= " . $user_id);

    if (mysqli_affected_rows($db) > 0) {
        $_SESSION['isUserSecuritySet'] = 'true';
        echo "success";
    } else {
        echo "error: " . mysqli_error($db);
    }
}

if (isset($_POST['adminsaveUser'])) {
    $flNameSave = $_POST['flName'];
    $usernameSave = $_POST['usernameSave'];
    $passwordSave = password_hash($_POST['passwordSave'], PASSWORD_DEFAULT);
    $userTypeSave = $_POST['usertype'];
    $statusSave = $_POST['status'];
    $emptyString = '';
    $querySave = "INSERT INTO `tblusers`(`Name`, `Password`, `SAnswer`, `SQuestion`, `Status`,`Username`,`UserType`) VALUES ('" . $flNameSave . "','" . $passwordSave . "','" . $emptyString . "','" . $emptyString . "','".$statusSave."','" . $usernameSave . "','" . $userTypeSave . "')";
    $insertResultSave = mysqli_query($db, $querySave);
    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully";
    } else {
        echo "Successfully";
    }
}
