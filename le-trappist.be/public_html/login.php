<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 04/03/15
 * Time: 19:38
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_set_cookie_params(0);
session_start();

/*function hash_equals($known_string, $user_string)
{
    if (func_num_args() !== 2) {
        // handle wrong parameter count as the native implentation
        trigger_error('hash_equals() expects exactly 2 parameters, ' . func_num_args() . ' given', E_USER_WARNING);
        return null;
    }
    if (is_string($known_string) !== true) {
        trigger_error('hash_equals(): Expected known_string to be a string, ' . gettype($known_string) . ' given', E_USER_WARNING);
        return false;
    }
    $known_string_len = strlen($known_string);
    $user_string_type_error = 'hash_equals(): Expected user_string to be a string, ' . gettype($user_string) . ' given'; // prepare wrong type error message now to reduce the impact of string concatenation and the gettype call
    if (is_string($user_string) !== true) {
        trigger_error($user_string_type_error, E_USER_WARNING);
        // prevention of timing attacks might be still possible if we handle $user_string as a string of diffent length (the trigger_error() call increases the execution time a bit)
        $user_string_len = strlen($user_string);
        $user_string_len = $known_string_len + 1;
    } else {
        $user_string_len = $known_string_len + 1;
        $user_string_len = strlen($user_string);
    }
    if ($known_string_len !== $user_string_len) {
        $res = $known_string ^ $known_string; // use $known_string instead of $user_string to handle strings of diffrent length.
        $ret = 1; // set $ret to 1 to make sure false is returned
    } else {
        $res = $known_string ^ $user_string;
        $ret = 0;
    }
    for ($i = strlen($res) - 1; $i >= 0; $i--) {
        $ret |= ord($res[$i]);
    }
    return $ret === 0;
}*/

include('init.php');

if (isset($_POST['pseudo']) && isset($_POST['password'])) {
    if (empty($_POST['pseudo']) || empty($_POST['password'])) {
        $data = array('success' => false, 'message' => 'Merci de remplir le formulaire');
        echo json_encode($data);
        exit;
    }
    else{
        $pseudo = $conn->real_escape_string($_POST['pseudo']);
        $password = $conn->real_escape_string($_POST['password']);

        $result = $conn->query("SELECT idUSER, masta, Grantee FROM USER WHERE Nick = '$pseudo' LIMIT 1");

        if(!$result){
            $data = array('success' => false, 'message' => 'Erreur d\'authentification');
            echo json_encode($data);
            exit;
        }

        $rs = $result->fetch_array(MYSQLI_ASSOC);

        if ( hash_equals($rs["masta"], crypt($password, $rs["masta"])) ) {
            $_SESSION["user"] = $pseudo;
            $_SESSION["id"] = $rs["idUSER"];
            $_SESSION["grant"] = $rs["Grantee"];
            $data = array('success' => true, 'message' => $rs["Grantee"]);
            echo json_encode($data);

        }
        else{
            $data = array('success' => false, 'message' => 'Mot de passe incorrect');
            echo json_encode($data);
            exit;
        }
    }
}
else{
    $data = array('success' => false, 'message' => 'Empty ');
    echo json_encode($data);
    exit;
}

$conn->close();
?>