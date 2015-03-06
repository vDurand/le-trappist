<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 05/03/15
 * Time: 12:11
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

$conn = new mysqli("localhost", "Vlad", "pfudorr", "Trappist", 0, '/media/fd0b1/alx22/private/mysql/socket');
$conn->query("SET NAMES 'utf8'");

if (isset($_POST['nom']) && isset($_POST['type']) && isset($_POST['pays']) && isset($_POST['alcool']) && isset($_POST['robe']) && isset($_POST['prix']) && isset($_POST['cdmt'])) {
    if (empty($_POST['nom']) || empty($_POST['type']) || empty($_POST['pays']) || empty($_POST['alcool']) || empty($_POST['robe']) || empty($_POST['prix']) || empty($_POST['cdmt'])) {
        $data = array('success' => false, 'message' => 'Merci de remplir le formulaire');
        echo json_encode($data);
        exit;
    }
    else{
        $nom = $conn->real_escape_string($_POST['nom']);
        $type = $conn->real_escape_string($_POST['type']);
        $pays = $conn->real_escape_string($_POST['pays']);
        $alcool = $conn->real_escape_string($_POST['alcool']);
        $robe = $conn->real_escape_string($_POST['robe']);
        $prix = $conn->real_escape_string($_POST['prix']);
        $cdmt = $conn->real_escape_string($_POST['cdmt']);
        $rbnote = 0; if(!empty($_POST['RBnote'])){$rbnote = $_POST['RBnote'];}
        $rbstyle = 0; if(!empty($_POST['RBstyle'])){$rbstyle = $_POST['RBstyle'];}
        $banote = 0; if(!empty($_POST['BAnote'])){$banote = $_POST['BAnote'];}
        $babro = 0; if(!empty($_POST['BAbro'])){$babro = $_POST['BAbro'];}


        $result = $conn->query("INSERT INTO BEER VALUES (NULL, '$nom', '$alcool', NULL, '$prix', $rbnote, $rbstyle, $banote, $babro, $type, $robe, $cdmt, $pays)");

        if(!$result){
            $data = array('success' => false, 'message' => 'Erreur lors de l\'ajout');
            echo json_encode($data);
            exit;
        }

        $data = array('success' => true, 'message' => 'Bière ajoutée avec succés');
        echo json_encode($data);
    }
}
else{
    $data = array('success' => false, 'message' => 'Empty ');
    echo json_encode($data);
    exit;
}

$conn->close();
?>