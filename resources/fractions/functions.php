<?php
require_once("ViewHelper.php");
require_once("model/StoreDB.php");
require_once("resources/fractions/functions.php");

class functions
{
    public static function login($email, $pass){
        $users = StoreDB::getUsers();

        $msg ="";
        $correct_user = 0;
        foreach ($users as $user){
            if ($user["email"] == $email && $user["isDeleted"] == 0){
                $correct_user = 1;

                if(password_verify ( $pass ,  $user["password"] )){
                    $msg = "Prijava uspešna";
                    $signed_usr = $user;
                    break;
                }
                else{
                    //POZOR: ce naredimo to ne sme biti dveh uporabnikov z istim imenom
                    break;
                }
            }
        }

        if(strcmp($msg,"") == 0 && $correct_user==1){
            $msg = "Wrong password for user";
        }
        elseif (strcmp($msg,"") == 0 && $correct_user==0){
            $msg = "User does not exist";
        }
        elseif (strcmp($msg,"Prijava uspešna") == 0){
            #var_dump($signed_usr);
            if($signed_usr["permission"] < 2){
                # isUserCertified
                $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
                $cert_data = openssl_x509_parse($client_cert);
                if(isset($cert_data) && !is_null($cert_data) && isset($cert_data['subject']) && !is_null($cert_data['subject'])){
                    $common_name = $cert_data['subject']['CN'];

                    #var_dump($common_name);
                    #var_dump($signed_usr["certCN"]);
                    if ($common_name == $signed_usr["certCN"]) {
                        #phpinfo(-1);
                        echo "<div class='banner-info'> 
                    [INFO] Logged in as certified user : $common_name  
                    </div>";
                        $_SESSION["user"] = $signed_usr;
                        ViewHelper::redirect(BASE_URL ."home");
                        return;
                    } else {
                        echo "<div class='banner-danger'> [Error] Uporabnik $common_name nima dostopa do te strani! </div>";
                    }
                }else{
                    echo "<div class='banner-danger'> [Error] Error with certificate. Please switch to secure connection and try again.</div>";
                }

            }else{
                $_SESSION["user"] = $signed_usr;
                ViewHelper::redirect(BASE_URL ."home");
                return;
            }



        }

        $page_title="login" ;
        $parameters = [
            "page_title" => $page_title,
            "try" => 1,
            "msg" => $msg
        ];
        echo ViewHelper::render("view/login.php", $parameters);
        return;
    }

    public static function VerifyLogin($email, $pass){
        $users = StoreDB::getUsers();

        foreach ($users as $user){
            if ($user["email"] == $email && $user["isDeleted"] == 0){
                if(password_verify ( $pass ,  $user["password"] )){
                    return $user;
                }
            }
        }

        return null;
    }

    public static function isCustomer(){
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["permission"]) && ($_SESSION["user"]["permission"]) == 2) {
            return true;
        } else{
            return false;
        }
    }

    public static function isSeller(){
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["permission"]) && ($_SESSION["user"]["permission"]) <= 1) {
            return true;
        }else{
            return false;
        }
    }

    public static function isAdmin(){
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["permission"]) && ($_SESSION["user"]["permission"]) == 0) {
            return true;
        }else{
            return false;
        }
    }
}