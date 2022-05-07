<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path . "/CanoEMS/methods/sessionChecker.php");

if ($_SESSION['user-ems']['UserType'] == 'ADMIN') {
    header("Location: /CanoEMS/users/admin/");
} else if ($_SESSION['user-ems']['UserType'] == 'TA') {
    header("Location: /CanoEMS/users/ta/");
} else if ($_SESSION['user-ems']['Status'] == 'FOR APPROVAL') {
    header("Location: /CanoEMS/forapproval.php");
} else {
    // session_destroy();
    header("Location: /CanoEMS/auth.php");
}
