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
    
    $result=mysqli_query($db,"SELECT count(*) as total from tblparticipants WHERE eventId = " . $event_id);
    $data=mysqli_fetch_assoc($result);
    $participantCode = '';
    if($data['total'] < 10){
        $participantCode = 'EMS'.$event_id.'000'.$data['total']+1;
    }else if($data['total'] > 9 && $data['total'] < 100){
        $participantCode = 'EMS'.$event_id.'00'.$data['total']+1;
    }else{
        $participantCode = 'EMS'.$event_id.'0'.$data['total']+1;
    }

    mysqli_query($db, "INSERT INTO `tblparticipants`(`eventId`, `participantName`,`participantCode`) VALUES 
    ('" . $event_id . "','" . $participantName . "','" . $participantCode . "')");

    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully added participant";
    } else {
        echo mysqli_error($db);
    }
    // exit();
}

if (isset($_POST['editParticipant'])) {
    $editparticipantId = $_POST['editparticipantId'];
    $editparticipantName  = $_POST['editparticipantName'];
    
    mysqli_query($db, "UPDATE `tblparticipants` SET `participantName`='" . $editparticipantName . "' WHERE participantId = " . $editparticipantId);

    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully edited participant";
    } else {
        echo mysqli_error($db);
    }
    // exit();
}


if (isset($_POST['deleteParticipant'])) {
    $deleteparticipantId = $_POST['deleteparticipantId'];
    
    mysqli_query($db, "UPDATE `tblparticipants` SET `isDeleted`='0' WHERE participantId = " . $deleteparticipantId);

    if (mysqli_affected_rows($db) > 0) {
        echo "Successfully edited participant";
    } else {
        echo mysqli_error($db);
    }
    // exit();
}

if (isset($_POST['searchParticipant'])) {

    $event_id = $_POST['eventId'];
    $searchParticipantCodeName  = $_POST['pCodeName'];
    $tableHeader = '<div class="resultDiv"><table class="table">';
    $tableFooter = '</table></div>';
    $searchResult = $tableHeader;

   $SearchCodeResult =  mysqli_query($db, "SELECT * FROM `tblparticipants` WHERE participantCode LIKE '%".$searchParticipantCodeName."%' AND isDeleted = 0 AND eventId = " . $event_id);

    if (mysqli_affected_rows($db) > 0) {
        $searchResult.='<tr class="text-white"><th>P-Id</th>th>P-Code</th>th>P-Name</th><th>Action</th></tr>';
        while ($row = $SearchCodeResult->fetch_assoc()) {
            $searchResult .= "
            <tr row-name='" . $row['participantName'] . "' row-id='" . $row['participantId'] . "'>
                <th scope='row'>" . $row['participantId'] . "</th>
                <td  ref='" . $row['participantCode'] . "'>" . $row['participantCode'] . "</td>
                <td  ref='" . $row['participantName'] . "'>" . $row['participantName'] . "</td>
                <td>
                    <button class='btn btn-primary m-1 pt-0 pb-0 btnEditParticipant'><i class='fa fa-clock'></i> Clock In</button>
                </td>
            </tr>";
        }

    } else{
        $SearchNameResult = mysqli_query($db, "SELECT * FROM `tblparticipants` WHERE participantName LIKE '%".$searchParticipantCodeName."%' AND isDeleted = 0 AND eventId = " . $event_id);
        if (mysqli_affected_rows($db) > 0) {
            $searchResult.='<tr class="text-white"><th>P-Id</th><th>P-Code</th><th>P-Name</th><th>Action</th></tr>';
            while ($row = $SearchNameResult->fetch_assoc()) {
                $searchResult .= "
                <tr row-id='" . $row['participantId'] . "'>
                    <th scope='row'>" . $row['participantId'] . "</th>
                    <td  ref='" . $row['participantCode'] . "'>" . $row['participantCode'] . "</td>
                    <td  ref='" . $row['participantName'] . "'>" . $row['participantName'] . "</td>
                    <td>
                        <button class='btn btn-primary m-1 pt-0 pb-0 btnClockIn'><i class='fa fa-clock'></i> Clock In</button>
                    </td>
                </tr>";
            }
        }else{
            $searchResult .= '<tr><h3>No participants found</h3></tr>'.$tableFooter;
        }
        // echo mysqli_error($db);
    }
    echo $searchResult;
}



if (isset($_POST['participantClockIn'])) {
    $participantName = $_POST['participantName'];
    $eventId = $_POST['eventId'];
    $clockedIn = $_POST['clockIn'];

    $resultz = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $eventId);
    $resultEvent = mysqli_fetch_all($resultz, MYSQLI_ASSOC);

    if($resultEvent[0]['attendanceStatus'] == 'OPEN'){
        mysqli_query($db, "INSERT INTO `tblparticipantsattendance`(`eventId`,`participantName`, `ClockIn`) VALUES 
        ('" . $eventId . "','" . $participantName . "',CURRENT_TIMESTAMP())");
    
        if (mysqli_affected_rows($db) > 0) {
            echo "Successfully clock in";
        } else {
            echo mysqli_error($db);
        }
    }else{
        echo "closed";
    }
    // exit();
}


if (isset($_POST['attendanceStatusChange'])) {
    $eventId = $_POST['eventId'];
    $editAttendanceStatus = $_POST['editAttendanceStatus'];

    mysqli_query($db, "UPDATE `tblevent` SET `attendanceStatus`='" . $editAttendanceStatus . "' WHERE event_id = " . $eventId);

    if (mysqli_affected_rows($db) > 0) {
        echo "Successful";
    } else {
        echo mysqli_error($db);
    }
    // exit();
}

