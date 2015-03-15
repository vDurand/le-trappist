<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 15/03/15
 * Time: 20:39
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT idUSER, Nick, Pic FROM USER ORDER BY idUSER");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Id":"'  . $rs["idUSER"] . '",';
    $outp .= '"Nom":"'   . $rs["Nick"]        . '",';
    $outp .= '"Avatar":"'. $rs["Pic"]     . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>