<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 04/03/15
 * Time: 23:21
 */
session_set_cookie_params(0);
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "Vlad", "pfudorr", "Trappist", 0, '/media/fd0b1/alx22/private/mysql/socket');
$conn->query("SET NAMES 'utf8'");
$idUser = $_SESSION["id"];
$result = $conn->query("SELECT idBEER FROM DRINK WHERE idUSER = $idUser ORDER BY idBEER");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '"'  . $rs["idBEER"] . '"';
}
$outp .="]";

$conn->close();

echo($outp);
?>