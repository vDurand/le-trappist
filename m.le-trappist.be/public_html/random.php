<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 06/03/15
 * Time: 13:33
 */
$conn = new mysqli("localhost", "gulden", "guldendraak", "Trappist", 0, '/media/sds1/alx22/private/mysql/socket');
$conn->query("SET NAMES 'utf8'");
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
    <link rel="stylesheet" href="app.css">
    <script src="js/ratchet.min.js"></script>
  </head>
  <body>
    <header class="bar bar-nav">
      <a class="btn btn-link btn-nav pull-left" href="index.php" data-transition="slide-out">
        <span class="icon icon-left-nav"></span>
        Back
      </a>
      <a class="btn btn-link btn-nav pull-right" href="random.php">
        <span class="icon icon-refresh"></span>
      </a>
      <h1 class="title">Bière Aléatoire</h1>
    </header>

<?php
$result = $conn->query("SELECT idBEER, Nom, Alcool, PrixBelge, RBnote, RBstyle, BAnote, BAbro, Type, Robe, Conditionnement, Pays, Img FROM BEER JOIN TYPE USING (idTYPE) JOIN ROBE USING (idROBE) JOIN CONDITIONNEMENT USING (idCDMT) JOIN PAYS USING (idPAYS) ORDER BY Nom");
while($rss = $result->fetch_array(MYSQLI_ASSOC)) {
  $rs[] = $rss;
}
$max = count($rs);
$id = rand(0, $max);
if(!empty($rs[$id]["BAbro"])){
    $BAbro = $rs[$id]["BAbro"];
}
else{
    $BAbro = 'na';
}
if(!empty($rs[$id]["BAnote"])){
    $BAnote = $rs[$id]["BAnote"];
}
else{
    $BAnote = 'na';
}
if(empty($rs[$id]["Img"])){
    $rs[$id]["Img"] = "0000.jpg";
}
?>
    <div class="content">
      <div class="card">
        <ul class="table-view">
          <li class="table-view-cell" style="text-align: center; padding-right: 15px;"><b><?php echo $rs[$id]["Nom"]; ?></b></li>
        </ul>
      </div>
      <img src="img/<?php echo $rs[$id]["Img"]; ?>" alt="bouteille" width="200" height="200" class="beerbottle">
      <ul class="table-view">
        <li class="table-view-cell table-view-divider">Détails</li>
        <li class="table-view-cell">
          Alcool
          <span class="badge"><?php echo $rs[$id]["Alcool"]; ?>°</span>
        </li>
        <li class="table-view-cell">
          Prix
          <span class="badge"><?php echo $rs[$id]["PrixBelge"]; ?>€</span>
        </li>
        <li class="table-view-cell">
          Type
          <span class="badge"><?php echo $rs[$id]["Type"]; ?></span>
        </li>
        <li class="table-view-cell">
          Robe
          <span class="badge"><?php echo $rs[$id]["Robe"]; ?></span>
        </li>
        <li class="table-view-cell">
          Conditionnement
          <span class="badge"><?php echo $rs[$id]["Conditionnement"]; ?>cl</span>
        </li>
        <li class="table-view-cell">
          Pays
          <span class="badge country"><img src="<?php echo $rs[$id]["Pays"]; ?>.png"></span>
        </li>
        <li class="table-view-cell">
          RateBeer Overall
          <span class="badge badge-primary"><?php echo $rs[$id]["RBnote"]; ?></span>
        </li>
        <li class="table-view-cell">
          RateBeer Style
          <span class="badge badge-primary"><?php echo $rs[$id]["RBstyle"]; ?></span>
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