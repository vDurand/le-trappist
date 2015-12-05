<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 06/03/15
 * Time: 13:33
 */
$conn = new mysqli("localhost", "gulden", "guldendraak", "Trappist", 0, '/media/sds1/alx22/private/mysql/socket');
$conn->query("SET NAMES 'utf8'");
$id = $_GET["id"];
$result = $conn->query("SELECT idBEER, Nom, Alcool, PrixBelge, RBnote, RBstyle, BAnote, BAbro, Type, Robe, Conditionnement, Pays, Img FROM BEER JOIN TYPE USING (idTYPE) JOIN ROBE USING (idROBE) JOIN CONDITIONNEMENT USING (idCDMT) JOIN PAYS USING (idPAYS) WHERE idBEER = $id");

$rs = $result->fetch_array(MYSQLI_ASSOC);
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
    $rs["Img"] = "0000.jpg";
}
    /*if ($outp != "[") {$outp .= ",";}
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
    $outp .= '"Pays":"'. $rs["Pays"]     . '"}'; */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Le Trappist</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link href="favicon.png" rel="shortcut icon"/>
    <link rel="stylesheet" href="css/ratchet.min.css">
    <link href="css/flag.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="app.css">
    <script src="js/ratchet.min.js"></script>
  </head>
  <body>
    <header class="bar bar-nav">
      <a class="btn btn-link btn-nav pull-left" href="index.php" data-transition="slide-out">
        <span class="icon icon-left-nav"></span>
        Back
      </a>
      <h1 class="title"><?php echo $rs["Nom"]; ?></h1>
    </header>
  
    <div class="content">
      <img src="img/<?php echo $rs["Img"]; ?>" alt="bouteille" width="200" height="200" class="beerbottle">
      <ul class="table-view">
        <li class="table-view-cell table-view-divider">Détails</li>
        <li class="table-view-cell">
          Alcool
          <span class="badge"><?php echo $rs["Alcool"]; ?>°</span>
        </li>
        <li class="table-view-cell">
          Prix
          <span class="badge"><?php echo $rs["PrixBelge"]; ?>€</span>
        </li>
        <li class="table-view-cell">
          Type
          <span class="badge"><?php echo $rs["Type"]; ?></span>
        </li>
        <li class="table-view-cell">
          Robe
          <span class="badge"><?php echo $rs["Robe"]; ?></span>
        </li>
        <li class="table-view-cell">
          Conditionnement
          <span class="badge"><?php echo $rs["Conditionnement"]; ?>cl</span>
        </li>
        <li class="table-view-cell">
          Pays
          <span class="badge country"><img src="<?php echo $rs["Pays"]; ?>.png"></span>
        </li>
        <li class="table-view-cell">
          RateBeer Overall
          <span class="badge badge-primary"><?php echo $rs["RBnote"]; ?></span>
        </li>
        <li class="table-view-cell">
          RateBeer Style
          <span class="badge badge-primary"><?php echo $rs["RBstyle"]; ?></span>
        </li>
        <li class="table-view-cell">
          BeerAdvocate Score
          <span class="badge badge-positive"><?php echo $BAnote; ?></span>
        </li>
        <li class="table-view-cell">
          BeerAdvocate The Bros
          <span class="badge badge-positive"><?php echo $BAbro; ?></span>
        </li>
      </ul>
    </div>
  </body>
</html>
<?php
$conn->close();
?>