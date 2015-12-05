<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 07/03/15
 * Time: 17:43
 */
session_set_cookie_params(0);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('init.php');

if (isset($_POST['id']) && isset($_POST['note'])) {
    if (empty($_POST['id'])) {
        $data = array('success' => false, 'message' => 'Selectionner une bière');
        echo json_encode($data);
        exit;
    }
    else{
        $id = $conn->real_escape_string($_POST['id']);
        $note = $conn->real_escape_string($_POST['note']);
        $user = $_SESSION["id"];

        $result = $conn->query("UPDATE DRINK SET Note = $note WHERE idBEER = $id AND idUSER = $user");

        if(!$result){
            $data = array('success' => false, 'message' => 'Erreur lors de la notation');
            echo json_encode($data);
            exit;
        }

        $data = array('success' => true, 'message' => 'Bière notée avec succés');
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