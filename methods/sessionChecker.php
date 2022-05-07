<?php
session_start();
if (empty($_SESSION['user-ems'])) {
    header("Location: /CanoEMS/auth.php");
}
