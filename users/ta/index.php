<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TA</title>

    <link rel="stylesheet" href="/CanoEMS/assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CanoEMS/assets/css/index.css">

    <link rel="icon" href="/CanoEMS/assets/img/icon.png" type="image/gif">
    <link rel="stylesheet" href="/CanoEMS/assets/css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .content-wrapper {
            height: 100vh !important;
        }

        #v {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path . "/CanoEMS/methods/sessionChecker.php");

 
    if ($_SESSION['user-ems']['UserType'] != 'TA') {
        header("Location: /CanoEMS");
    }

    include_once($path . "/CanoEMS/db/config.php"); // configuration

    $resultEventM = mysqli_query($db, "SELECT * FROM `tblevent` where convert(date, date) = CURRENT_DATE()");
    $resultEventUpcoming = mysqli_query($db, "SELECT * FROM `tblevent` where convert(date, date) > CURRENT_DATE()");
    ?>
    <div class="wrapper">
        <div class="content w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <?php include($path . "/CanoEMS/comp/taNavBar.php") ?>
            </nav>
            <div class="wrapper">
        <div class="content w-100">
            <div class="container-fluid">
                <div class="content-wrapper p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                           <h3 class="textUserColor">TODAY'S SCHEDULES</h3><br>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tbl" class="table table-stripe">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="w-12" scope="col">NAME</th>
                                                    <th class="w-12" scope="col">TIME</th>
                                                    <th class="w-24" scope="col">DATE</th>
                                                    <th class="w-24" scope="col">TITLE</th>
                                                    <th class="w-12" scope="col">LOCATION</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                        while ($row = $resultEventM->fetch_assoc()) {
                                                            echo "
                                                <tr row-id='" . $row['event_id'] . "'>
                                                    <th scope='row'>" . $row['event_name'] . "</th>
                                                    <td>" . $row['time'] . "</td>
                                                    <td>" . $row['date'] . "</td>
                                                    <td>" . $row['event_title'] . "</td>
                                                    <td>" . $row['venue'] . "</td>
                                                    <td>
                                                    <a href='/CanoEMS/users/ta/event.php?id=" . $row['event_id'] . "' class='btn btn-info'>More Info <i class='fa fa-info-circle'></i></a>
                                                    </td>
                                                </tr>";
                                                        }
                                                        if (mysqli_num_rows($resultEventM) == 0) {
                                                            echo "
                                                            <tr>
                                                                <td colspan='5' class='text-center'>No event today.</td>
                                                            </tr>";
                                                        }
                                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br><br>
                                    <div class="row" style="padding-top: 50px;">
                                        <div class="col-sm-8">
                                           <h3 class="textUserColor">UPCOMING SCHEDULES</h3><br>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tbl" class="table table-stripe">
                                            <thead  class="thead-light">
                                                <tr>
                                                    <th class="w-12" scope="col">NAME</th>
                                                    <th class="w-12" scope="col">TIME</th>
                                                    <th class="w-24" scope="col">DATE</th>
                                                    <th class="w-24" scope="col">TITLE</th>
                                                    <th class="w-12" scope="col">LOCATION</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        while ($row = $resultEventUpcoming->fetch_assoc()) {
                                                            echo "
                                                <tr row-id='" . $row['event_id'] . "'>
                                                    <th scope='row'>" . $row['event_name'] . "</th>
                                                    <td>" . $row['time'] . "</td>
                                                    <td>" . $row['date'] . "</td>
                                                    <td>" . $row['event_title'] . "</td>
                                                    <td>" . $row['venue'] . "</td>
                                                    <td>
                                                    <a href='/CanoEMS/users/ta/event.php?id=" . $row['event_id'] . "' class='btn btn-info'>More Info <i class='fa fa-info-circle'></i></a>
                                                    </td>
                                                </tr>";
                                                        }

                                                        if (mysqli_num_rows($resultEventUpcoming) == 0) {
                                                            echo "
                                                <tr>
                                                    <td colspan='5' class='text-center'>No upcoming events.</td>
                                                </tr>";
                                                        }
                                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/CanoEMS/assets/js/jquery.min.js"></script>
    <script src="/CanoEMS/assets/js/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="/CanoEMS/assets/js/llqrcode.js"></script>
    <script type="text/javascript" src="/CanoEMS/assets/js/webqr.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="/CanoEMS/assets/js/common.js"></script>

    <script>
        $(".loading").show();
        $(document).ready(function() {
            $("#sidebarCollapse").on('click', function() {
                $("#sidebar").toggleClass('active');
            });

            $("#btnScan").on("click", function() {
                load();
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-24451557-1']);
                _gaq.push(['_trackPageview']);

                // (function() {
                //     var ga = document.createElement('script');
                //     ga.type = 'text/javascript';
                //     ga.async = true;
                //     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                //     var s = document.getElementsByTagName('script')[0];
                //     s.parentNode.insertBefore(ga, s);
                // })();
            })


            $(".loading").hide();
        });

        function finishScan(b) {
            console.log(b);
            alert("fisnish");
        }
    </script>
</body>

</html>