<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENT INFORMATION</title>

    <link rel="stylesheet" href="/CanoEMS/assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CanoEMS/assets/css/index.css">

    <link rel="icon" href="/CanoEMS/assets/img/mainiconlogo.jpg" type="image/gif">
    <style>
        #qrcode img {
            width: 100%;
            height: auto;
        }
        table tr td:lastchild{
            width:1%;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path . "/CanoEMS/db/config.php"); // configuration

    $event_id = $_GET["id"];

    $resultEventM = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $event_id);
    $resultEventMData = mysqli_fetch_all($resultEventM, MYSQLI_ASSOC);
    $resultEventDetails = mysqli_query($db, "SELECT * FROM `tbleventdetails` where EventId = " . $event_id);
    $resultEventDetailsz = mysqli_query($db, "SELECT * FROM `tbleventdetails` where EventId = " . $event_id);

    if (mysqli_num_rows($resultEventM) == 0) {
        header("Location: /CanoEMS/invalidevent.php");
    }

    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div id="qrcode"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <hr>
                <table width="100%">
                        <tr>
                            <td width="15%">
                                 <h2><small>EVENT ID:</small></h2>
                            </td>
                            <td style="text-align:left; width:'70%'">
                                  <h2><u><b><?= $resultEventMData[0]["event_id"] ?></b></u></h2>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">
                                 <h2><small>EVENT TITLE:</small></h2>
                            </td>
                            <td style="text-align:left; width:'70%'">
                                  <h2><u><b><?= $resultEventMData[0]["event_title"] ?></b></u></h2>
                            </td>
                        </tr>
                        <tr>
                        
                        </tr>
                        <tr>
                            <td width="15%">
                                 <h2><small>EVENT NAME:</small></h2>
                            </td>
                            <td style="text-align:left; width:'70%'">
                                  <h2><u><b><?= $resultEventMData[0]["event_name"] ?></b></u></h2>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">
                                 <h2><small>DATE:</small></h2>
                            </td>
                            <td style="text-align:left; width:'70%'">
                                  <h2><u><b><?= $resultEventMData[0]["date"] ?></b></u></h2>
                            </td>
                            <td width="15%">
                                 <h2><small>TIME:</small></h2>
                            </td>
                            <td style="text-align:left; width:'70%'">
                                  <h2><u><b><?= $resultEventMData[0]["time"] ?></b></u></h2>
                            </td>
                        </tr>
                </table><br>
                <h2><small>SPEAKERS:</small></h2>
                <table>
                    <?php
                        while($row = $resultEventDetails->fetch_assoc()) {
                            echo "
                            <tr>
                                <td width='15%' ref='" . $row['SpeakerName'] . "'><h2><small>NAME:</h2></small></td>
                                <td width='70%' ref='" . $row['SpeakerName'] . "'><h2><u><b>" . $row['SpeakerName'] . "</b></u></h2></td>
                                <td width='15%' ref='" . $row['Title'] . "'><h2><small>TITLE:</h2></small></td>
                                <td width='70%' ref='" . $row['Title'] . "'><h2><u><b>" . $row['Title'] . "</b></u></h2></td>
                            </tr>";
                        };
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script src="/CanoEMS/assets/js/jquery.min.js"></script>
    <script src="/CanoEMS/assets/js/bootstrap/js/bootstrap.min.js"></script>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".loading").hide();
            var z = ""
            // new QRCode(document.getElementById("qrcode"), "http://eventmanagementsystem.epizy.com/event.php?id=<?= $resultEventMData[0]["event_id"] ?>");

            var qrContent = " EVENT ID: <?= $resultEventMData[0]['event_id']; echo '\n';?>" 
            +"EVENT TITLE: <?= $resultEventMData[0]['event_title']; echo '\n';?>"
            +"VENUE: <?= $resultEventMData[0]['venue']; echo '\n';?>"
            +"EVENT NAME: <?= $resultEventMData[0]['event_name']; echo '\n';?>"
            +"DATE: <?= $resultEventMData[0]['date']; echo '\n';?>"
            +"TIME: <?= $resultEventMData[0]['time']; echo '\n';?>"
            +"SPEAKERS: <?php echo '\n'; ?>"
            +"<?php 
                   while($rowz = $resultEventDetailsz->fetch_assoc()) {
                   echo nl2br("NAME:" . $rowz['SpeakerName'] ."".'\n'. "TITLE:" . $rowz['Title'] . '\n'."");}?>";

            new QRCode(document.getElementById("qrcode"),qrContent);
            window.print();
            // window.close();
        });
    </script>
</body>

</html>