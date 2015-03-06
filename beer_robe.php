<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 05/03/15
 * Time: 11:21
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT idROBE, Robe FROM ROBE ORDER BY Robe");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Id":"'  . $rs["idROBE"] . '",';
    $outp .= '"Nom":"'. $rs["Robe"]     . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>