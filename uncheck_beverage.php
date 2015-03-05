<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 04/03/15
 * Time: 21:54
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_set_cookie_params(0);
session_start();

$conn = new mysqli("localhost", "Vlad", "pfudorr", "Trappist", 0, '/media/fd0b1/alx22/private/mysql/socket');
$conn->query("SET NAMES 'utf8'");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$idBeer = $request->Id;

if (isset($idBeer)) {
    if(isset($_SESSION["id"])){
        if (empty($idBeer) || empty($_SESSION["id"])) {
            $data = array('success' => false, 'message' => 'epic fail');
            echo json_encode($data);
            exit;
        }
        else{
            $idUser = $_SESSION["id"];
            //$idBeer = $_POST['Id'];

            $result = $conn->query("DELETE FROM DRINK WHERE idBEER = $idBeer AND idUSER = $idUser");

            if(!$result){
                $data = array('success' => false, 'message' => 'Erreur lors du uncheck');
                echo json_encode($data);
                exit;
            }

            $data = array('success' => true, 'message' => 'Successfully unchecked');
            echo json_encode($data);
        }
    }
    else{
        $data = array('success' => false, 'message' => 'Empty user id');
        echo json_encode($data);
        exit;
    }
}
else{
    $data = array('success' => false, 'message' => 'Empty beer id');
    echo json_encode($data);
    exit;
}

$conn->close();
?>