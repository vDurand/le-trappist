<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('init.php');

if (isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['passwordtwo'])) {
    if (empty($_POST['pseudo']) || empty($_POST['mail']) || empty($_POST['password']) || empty($_POST['passwordtwo'])) {
        $data = array('success' => false, 'message' => 'Merci de remplir le formulaire');
        echo json_encode($data);
        exit;
    }
    else if ($_POST['password'] != $_POST['passwordtwo']){
        $data = array('success' => false, 'message' => 'Merci de confirmer un mot de passe identique');
        echo json_encode($data);
        exit;
    }
    else{
        if(isset($_POST['grecaptcharesponse'])){
            $captcha=$_POST['grecaptcharesponse'];
        }
        if(!$captcha){
            $data = array('success' => false, 'message' => 'Remplir le Captcha, merci');
            echo json_encode($data);
            exit;
        }
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfeHgMTAAAAAMRq4A98MX_Tt8VDBzhLveySHFhl&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $answer=json_decode($response, true);
        if($answer["success"]==false)
        {
            $data = array('success' => false, 'message' => 'Merci de ne pas spammer le formulaire');
            echo json_encode($data);
            exit;
        }else
        {
            $pseudo = $conn->real_escape_string($_POST['pseudo']);
            $mail = $conn->real_escape_string($_POST['mail']);
            $password = $conn->real_escape_string($_POST['password']);

            // A higher "cost" is more secure but consumes more processing power
            $cost = 10;

            // Create a random salt
            $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

            // Prefix information about the hash so PHP knows how to verify it later.
            // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
            $salt = sprintf("$2a$%02d$", $cost) . $salt;

            // Value:
            // $2a$10$eImiTXuWVxfM37uY4JANjQ==

            // Hash the password with the salt
            $hash = crypt($password, $salt);

            $result = $conn->query("INSERT INTO USER VALUES (NULL, '$pseudo', '$hash', '$mail', 0, 'default.jpg')");

            if(!$result){
                $data = array('success' => false, 'message' => 'Erreur lors de lajout');
                echo json_encode($data);
                exit;
            }

            $data = array('success' => true, 'message' => 'Utilisateur ajouté avec succés');
            echo json_encode($data);
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