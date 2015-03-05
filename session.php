<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 04/03/15
 * Time: 21:26
 */
session_set_cookie_params(0);
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_SESSION['user'])) {
    $data = array('success' => true, 'message' => $_SESSION['user']);
    echo json_encode($data);
}
else{
    $data = array('success' => false, 'message' => 'No session');
    echo json_encode($data);
    exit;
}
?>