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
        #tbl_filter,
        #tbl_paginate {
            float: right !important;
        }
    </style>
</head>

<body>
    <?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path . "/CanoEMS/methods/sessionChecker.php");
    include_once($path . "/CanoEMS/db/config.php"); // configuration

    if ($_SESSION['user-ems']['UserType'] != 'TA') {
        header("Location: /CanoEMS");
    }

    $event_id = $_GET["id"];

    $resultEventM = mysqli_query($db, "SELECT * FROM `tblevent` where event_id = " . $event_id);
    $resultEventMData = mysqli_fetch_all($resultEventM, MYSQLI_ASSOC);

    $resultEventD = mysqli_query($db, "SELECT * FROM `tbleventdetails` where event_id = " . $resultEventMData[0]["event_id"]);

    if (mysqli_num_rows($resultEventM) == 0) {
        header("Location: /CanoEMS/invalidevent.php");
    }

    ?>
    <div class="wrapper">
        <div class="content w-100">
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <img style="float: left; height: 150px; width: auto;" src="/ems/assets/img/icon.jpeg">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-12 mb-3">
                                                            <h2 class="text-center mt-5">EVENT INFORMATION</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <img class="qr-generated" style="float: right; height: 150px; width: auto;" src="https://api.qrserver.com/v1/create-qr-code/?data=/ems/event.php?id=<?php echo $resultEventMData[0]["event_id"] ?>&size=300x300">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h5>EVENT ID:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventId" value="<?php echo $resultEventMData[0]["event_id"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <h5>EVENT NAME:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventName" value="<?php echo $resultEventMData[0]["title"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h5>LOCATION:</h5>
                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <input type="text" class="form-control" id="location" value="<?php echo $resultEventMData[0]["location"] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>TIME:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventId" value="<?php echo $resultEventMData[0]["time"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>DATE:</h5>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <input type="text" class="form-control" id="eventName" value="<?php echo $resultEventMData[0]["date"] ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr>
                                            <div id="accordion">
                                                <div class="card text-white bg-info">
                                                    <div class="card-header" id="headingOne">
                                                        <h5 class="mb-0">
                                                            GUEST:
                                                            <button class="btn btnCollapseExpand text-white text-decoration-none float-right" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                <i class='fa fa-minus collapses'></i>
                                                                <i class='fa fa-expand expand d-none'></i>
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="tbl" class="table table-stripe table-hover text-white">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>GUEST_NAME</th>
                                                                            <th>ADDRESS</th>
                                                                            <th>CONTACT_NO</th>
                                                                            <th>EMAIL</th>
                                                                            <th>IS_APPROVED</th>
                                                                            <th class="hideOnPrint">ACTION</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php

                                                                        while ($row = $resultEventD->fetch_assoc()) {

                                                                            $_isApproved = "FALSE";
                                                                            $_actionBtn = "<button class='btn btn-danger btnEdit m-1 pt-0 pb-0'><i class='fa fa-thumbs-up'></i> Approve</button>";
                                                                            if ($row['is_approved'] == 1) {
                                                                                $_isApproved = "TRUE";
                                                                                $_actionBtn = "<span class='text-white'>APPROVED</span>";
                                                                            }

                                                                            echo "
                                                                            <tr row-id='" . $row['id'] . "'>
                                                                                <th scope='row'>" . $row['guest_name'] . "</th>
                                                                                <td>" . $row['address'] . "</td>
                                                                                <td>" . $row['contact_no'] . "</td>
                                                                                <td>" . $row['email'] . "</td>
                                                                                <td>" . $_isApproved . "</td>
                                                                                <td class='hideOnPrint'>" .
                                                                                $_actionBtn .
                                                                                "</td>
                                                                            </tr>";
                                                                        }

                                                                        if (mysqli_num_rows($resultEventD) == 0) {
                                                                            echo "
                                                                            <tr>
                                                                                <td colspan='6' class='text-center'>No guest found.</td>
                                                                            </tr>";
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END COLLAPSE -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CARD BODY -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/CanoEMS/assets/js/jquery.min.js"></script>
    <script src="/CanoEMS/assets/js/bootstrap/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".loading").hide();
        });
    </script>
</body>

</html>