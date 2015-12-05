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
      <a class="icon icon-info pull-right" href="#settingsModal"></a>
      <h1 class="title">Le Trappist</h1>
    </header>

    <div class="content">

      <div class="slider">
        <div class="slide-group">
          <div class="slide">
            <img src="trap.png" alt="trappist" height="200">
          </div>
          <div class="slide">
             <img src="trapp.png" alt="trappistbelge" height="200">
          </div>
        </div>
      </div>
      
      <ul class="table-view">
        <li class="table-view-cell">
          <a class="navigate-right" href="random.php" data-transition="slide-in">
            Bière Aléatoire
          </a>
        </li>
        <li class="table-view-cell table-view-divider">Liste des Bières</li>
<?php
$result = $conn->query("SELECT idBEER, Nom, Alcool, PrixBelge, RBnote, RBstyle, BAnote, BAbro, Type, Robe, Conditionnement, Pays, Img FROM BEER JOIN TYPE USING (idTYPE) JOIN ROBE USING (idROBE) JOIN CONDITIONNEMENT USING (idCDMT) JOIN PAYS USING (idPAYS) ORDER BY Nom");

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if(!empty($rs["BAbro"])){
        $BAbro = $rs["BAbro"];
    }
    else{
        $BAbro = 'na';
    }
    if(!empty($rs["BAnote"])){
        $BAnote = $rs["BAnote"];
    }
    else{
        $BAnote = 'na';
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

        <li class="table-view-cell media">
          <a class="navigate-right" href="choose-beer.php?id=<?php echo $rs["idBEER"]; ?>" data-transition="slide-in">
            <img class="media-object pull-left" src="img/<?php echo $rs["Img"]; ?>" alt="beer pic" width="64" height="64">
            <div class="media-body">
              <?php echo $rs["Nom"]; ?>
              <p>RB overall : <span class="badge badge-primary badge-inverted"><?php echo $rs["RBnote"]; ?></span> | RB style : <span class="badge badge-primary badge-inverted"><?php echo $rs["RBstyle"]; ?></span><br>BA overall : <span class="badge badge-positive badge-inverted"><?php echo $BAnote; ?><?php if($rs["RBnote"]==100&&$BAnote!=100) echo "&nbsp;&nbsp;";?></span> | BA bros : <span class="badge badge-positive badge-inverted"><?php echo $BAbro; ?></span></p>
            </div>
          </a>
        </li>
<?php
}
?>
      </ul>
    </div><!-- /.content -->

    <!-- Settings modal -->
    <div id="settingsModal" class="modal">
      <header class="bar bar-nav">
        <a class="icon icon-close pull-right" href="#settingsModal"></a>
        <h1 class="title">Info</h1>
      </header>
    
      <div class="content">
        <form class="input-group">
          <input type="text" placeholder="Lundi - Samedi : 16h - 01h" disabled="disabled">
          <input type="email" placeholder="Dimanche : 18h - 01h" disabled="disabled">
        </form>
    
        <h5 class="content-padded">Adresse</h5>
    
        <ul class="table-view">
          <li class="table-view-cell media">
            <span class="media-object pull-left icon icon-home"></span>
            <div class="media-body">
              Le Trappist bar Belge
            </div>
          </li>
          <li class="table-view-cell media">
            <span class="media-object pull-left icon icon-right-nav"></span>
            <div class="media-body">
              56 Quai vendeuvre
            </div>
          </li>
          <li class="table-view-cell media">
            <span class="media-object pull-left icon icon-right-nav"></span>
            <div class="media-body">
              14000 Caen, France
            </div>
          </li>
        </ul>
      </div>
    </div><!-- /.modal -->
    <!--    <div id="settingsModal" class="modal">
      <header class="bar bar-nav">
        <a class="icon icon-close pull-right" href="#settingsModal"></a>
        <h1 class="title">Info</h1>
      </header>

      <div class="content">
        <form class="input-group">
          <input type="text" value="Lundi - Samedi : 16h - 01h">
          <input type="text" value="Dimanche : 18h - 01h">
        </form>

        <h5 class="content-padded">Adresse</h5>

        <ul class="table-view">
          <li class="table-view-cell media">
            <span class="media-object pull-left icon icon-home"></span>
            <div class="media-body">
              Le Trappist bar Belge
            </div>
          </li>
          <li class="table-view-cell media">
            <span class="media-object pull-left icon icon-right-nav"></span>
            <div class="media-body">
              56 Quai vendeuvre
            </div>
          </li>
          <li class="table-view-cell media">
            <span class="media-object pull-left icon icon-right-nav"></span>
            <div class="media-body">
              14000 Caen, France
            </div>
          </li>
        </ul>
      </div>
    </div>-->
  </body>
</html>
<?php
$conn->close();
?>