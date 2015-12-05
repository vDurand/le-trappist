<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('init.php');
$result = $conn->query("SELECT idBEER, Nom, Alcool, PrixBelge, RBnote, RBstyle, BAnote, BAbro, Type, Robe, Conditionnement, Pays, Img FROM BEER JOIN TYPE USING (idTYPE) JOIN ROBE USING (idROBE) JOIN CONDITIONNEMENT USING (idCDMT) JOIN PAYS USING (idPAYS) ORDER BY Nom");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	if(!empty($rs["BAbro"])){
		$BAbro = $rs["BAbro"];
	}
	else{
		$BAbro = '0';
	}
	if(!empty($rs["BAnote"])){
		$BAnote = $rs["BAnote"];
	}
	else{
		$BAnote = '0';
	}
	if(empty($rs["Img"])){
		$rs["Img"] = '0000.jpg';
	}
	if ($outp != "[") {$outp .= ",";}
	$outp .= '{"Id":"'  . $rs["idBEER"] . '",';
	$outp .= '"Nom":"'   . $rs["Nom"]        . '",';
	$outp .= '"Alcool":'   . $rs["Alcool"]        . ',';
	$outp .= '"PrixBelge":'   . $rs["PrixBelge"]        . ',';
	$outp .= '"RBnote":'   . $rs["RBnote"]        . ',';
	$outp .= '"RBstyle":'   . $rs["RBstyle"]        . ',';
	$outp .= '"BAnote":'   . $BAnote        . ',';
	$outp .= '"BAbro":'   . $BAbro        . ',';
	$outp .= '"Type":"'   . $rs["Type"]        . '",';
	$outp .= '"Robe":"'   . $rs["Robe"]        . '",';
	$outp .= '"Conditionnement":"'   . $rs["Conditionnement"]        . '",';
	$outp .= '"Img":"'   . $rs["Img"]        . '",';
	$outp .= '"Pays":"'. $rs["Pays"]     . '"}'; 
}
$outp .="]";

$conn->close();

echo($outp);
?>