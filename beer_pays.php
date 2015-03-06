<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 05/03/15
 * Time: 11:19
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT idPAYS, Name FROM PAYS ORDER BY Pays");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Id":"'  . $rs["idPAYS"] . '",';
    $outp .= '"Nom":"'. $rs["Name"]     . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>