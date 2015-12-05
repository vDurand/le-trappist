<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 05/03/15
 * Time: 11:22
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT idCDMT, Conditionnement FROM CONDITIONNEMENT ORDER BY Conditionnement");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Id":"'  . $rs["idCDMT"] . '",';
    $outp .= '"Nom":"'. $rs["Conditionnement"]     . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>