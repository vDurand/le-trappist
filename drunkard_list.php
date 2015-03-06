<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 04/03/15
 * Time: 17:59
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT Nick FROM USER ORDER BY Nick");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '"'  . $rs["Nick"] . '"';
}
$outp .="]";

$conn->close();

echo($outp);
?>