<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 04/03/15
 * Time: 22:32
 */
session_set_cookie_params(0);
session_start();
session_destroy();
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>