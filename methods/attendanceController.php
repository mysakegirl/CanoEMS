<?php
// session_destroy();
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];

include_once($path . "/CanoEMS/db/config.php");

// initialize variables
$name = "";

// for update
if (isset($_POST['save'])) {
    $name  = $_POST['name'];

    mysqli_query($db, "INSERT INTO `tblparticipants`(`name`, `time_in`) VALUES ('" . $name . "',CURRENT_TIMESTAMP())");
    if (mysqli_affected_rows($db) > 0) {
        echo "success insert";
    } else {
        echo "error ni:";
        echo mysqli_error($db);
    }
}
