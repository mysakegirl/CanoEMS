<?php
session_start();
unset($_SESSION["user-ems"]);
header("Location: /CanoEMS/auth.php");
