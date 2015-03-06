<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 05/03/15
 * Time: 11:16
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT idTYPE, Type FROM TYPE ORDER BY Type");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Id":"'  . $rs["idTYPE"] . '",';
    $outp .= '"Nom":"'. $rs["Type"]     . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>