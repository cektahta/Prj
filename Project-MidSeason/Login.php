<?php
session_start();
require_once 'dbconfig.php';


if(!empty($_POST))
{
    $user_email = $_POST['lmail'];
    $user_password = $_POST['lpassword'];



    function secureCheck($user_email , $user_password) {
        if(strlen($user_email) == 0){
            return false;
        }
        if(strlen($user_password) == 0){
            return false;
        }
        return true;
    }
    if(secureCheck($user_email,$user_password)){
        try
        {

            $stmt = $db_con->prepare("SELECT * FROM users WHERE user_email=:email");
            $stmt->execute(array(":email"=>$user_email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
            if($count == 1) {
                if ($row['user_password'] == $user_password) {

                    echo "ok"; // log in
                    $_SESSION['user_session'] = $row['user_id'];
                    header("Location: http://localhost/Project-MidSeason/Front.html");
                } else {

                    echo "email or password does not exist."; // wrong details
                }
            } else {
                echo "There is not a registered account with this name";
            }

        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

    }else{
        echo "Username and password cannot be empty";
    }
}
?>