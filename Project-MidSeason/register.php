<?php
session_start();
require_once 'dbconfig.php';
$err = [];
$response = [];


 if($_POST)
 {
     $user_name = $_POST['nick'];
     $user_email = $_POST['mail'];
     $user_password = $_POST['password'];
     $joining_date =date('Y-m-d H:i:s');

     function checkValidate($user_name,$user_email,$user_password,&$err){
         if(preg_match("/[A-Za-z]\\w{3,19}/",$user_name)== 0){
             $err[] = "Username must be between 4 and 20 characters";
         }
         if(strlen($user_password) < 6 || strlen($user_password) > 20){
             $err[] = "Password must be at least 6 characters, no more than 20 characters, and must include at least one upper case letter, one lower case letter, and one numeric digit.";
         }



         if(count($err) == 0){
             return true;
         }
         return false;
     }

     try
     {

         $stmt = $db_con->prepare("SELECT * FROM users WHERE user_email=:email");
         $stmt->execute(array(":email"=>$user_email));
         $count = $stmt->rowCount();

         if($count==0){
             $cheking = checkValidate($user_name , $user_password , $user_email, $err );
             if ($cheking) {
                 $stmt = $db_con->prepare("INSERT INTO users(user_name,user_email,user_password,joining_date) VALUES(:uname, :email, :pass, :jdate)");
                 $stmt->bindParam(":uname",$user_name);
                 $stmt->bindParam(":email",$user_email);
                 $stmt->bindParam(":pass",$user_password);
                 $stmt->bindParam(":jdate",$joining_date);

                 if($stmt->execute())
                 {
                     echo "registered";

                 }
                 else
                 {
                     echo "Query could not execute !";
                 }
             }  else {
                 $err[] = "Invalid data";
             }


         }
         else{

             echo "Username is already in use";
         }

     }
     catch(PDOException $e){
         echo $e->getMessage();
     }
 }
$response["errors"] = $err;
echo json_encode($response);


?>