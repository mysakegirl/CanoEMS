<?php
// session_destroy();
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];

include_once($path . "/CanoEMS/db/config.php");

// initialize variables
$title = "";
$location = "";
$date = "";
$time = "";
$guest = "";

// for save
if (isset($_POST['save'])) {
    $eventtitle  = $_POST['eventtitle'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $eventname = $_POST['eventname'];
    $speakerList = $_POST['speakerArr'];
    
    $query = "INSERT INTO `tblevent`(`event_title`, `time`, `date`, `venue`, `event_name`) VALUES 
    ('" . $eventtitle . "','" . $time . "','" . $date . "','" . $venue . "','" . $eventname . "')";
    $result = mysqli_query($db, $query);
    $lastId = mysqli_insert_id($db);

    foreach($speakerList as $item){
        mysqli_query($db, "INSERT INTO `tbleventdetails`(`EventId`, `SpeakerName`, `Title`) VALUES 
        ('" . $lastId . "','" . $item['speakerName'] . "','" . $item['title'] . "')");
    }

    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully added event";
    } else {
        echo "error ni:";
        echo mysqli_error($db);
    }
}

// for update
if (isset($_POST['update'])) {
    $event_id = $_POST['event_id'];
    $title  = $_POST['title'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guest = $_POST['guest'];

    mysqli_query($db, "UPDATE `tblevent` SET `title`='" . $title . "',`time`='" . $time . "',`date`='" . $date . "',`location`='" . $location . "',`guest`='" . $guest . "' WHERE event_id = " . $event_id);
    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully updated event";
    } else {
        echo mysqli_error($db);
    }
    // exit();
}


if (isset($_POST['addParticipant'])) {
    $event_id = $_POST['eventId'];
    $participantName  = $_POST['participantName'];
    
    mysqli_query($db, "UPDATE `tblevent` SET `title`='" . $title . "',`time`='" . $time . "',`date`='" . $date . "',`location`='" . $location . "',`guest`='" . $guest . "' WHERE event_id = " . $event_id);
    
    mysqli_query($db, "INSERT INTO `tblparticipants`(`eventId`, `participantName`) VALUES 
    ('" . $event_id . "','" . $participantName . "')");
    
    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully added participant";
    } else {
        echo mysqli_error($db);
    }
    // exit();
}
