<?php

require_once("ViewHelper.php");
require_once("model/StoreDB.php");
require_once("resources/fractions/functions.php");

class StoreController{

    public static function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
            ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    public static function index() {

        $page_title="Home" ;
        $parameters = [
            "page_title" => $page_title,
            "books" => StoreDB::getAllBooks()
        ];

        echo ViewHelper::render("view/home.php", $parameters);

    }

    public static function unauth() {
        // user is unauthorized to view
        $page_title="No permission" ;
        $parameters = [
            "page_title" => $page_title,
        ];
        echo ViewHelper::render("view/unauth.php", $parameters);
    }

    public static function error($e) {
        $page_title="Error" ;
        $parameters = [
            "page_title" => $page_title,
            "error" => $e,
        ];
        echo ViewHelper::render("view/error.php", $parameters);
    }

    public static function profile(){
        $page_title="Profile" ;
        $parameters = [
            "page_title" => $page_title,
        ];

        echo ViewHelper::render("view/profile.php", $parameters);
    }

    public static function cart() {
        $page_title="Cart" ;
        $parameters = [
            "page_title" => $page_title,
            "books" => StoreDB::getAllBooks()
            // CE KOMU USPE USPOSOBT TA SQL CESTITKE
            //"books" => StoreDB::getSpecificBooks(array_keys($_SESSION["cart"]))
        ];
        echo ViewHelper::render("view/cart.php", $parameters);
    }

    public static function article() {
        //$id = array($_POST["id"]);

        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        if (isset($_POST))

        $id = filter_input_array(INPUT_GET, $rules);

        $parameters = [
            "book" => StoreDB::get($id),
            "rating" => StoreDB::getAvgRating($id)
        ];
        echo ViewHelper::render("view/article.php", $parameters);
    }
//modify_book
    public static function cartUpdate() {
        //update cart
        include('resources/fractions/cartmanagment.php');
        //redirect back to cart
        ViewHelper::redirect(BASE_URL ."cart");
    }



    public static function managment() {

        $page_title="Managment" ;
        $parameters = [
            "page_title" => $page_title,
            "books" => StoreDB::getAllBooks()
        ];
        echo ViewHelper::render("view/managment.php", $parameters);
    }


    public static function manageBooks() {

        if(isset($_POST["do"]) &&  $_POST["do"]=="deactivate"){
            $parameters = [
                "id"=>$_POST["id"],
                "isDeleted"=>$_POST["delete"]
            ];
            StoreDB::deleteBook($parameters);
            ViewHelper::redirect(BASE_URL . "managment");
        }


        if(isset($_POST["id"])){
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $id = filter_input_array(INPUT_POST, $rules);
            $book = StoreDB::get($id);
        }
        else{
            $book = 0;
        }


        $page_title="BookManagment" ;
        $parameters = [
            "page_title" => $page_title,
            "book" => $book
        ];
        echo ViewHelper::render("view/modify.php", $parameters);
    }

    public static function add_book(){

        $title = $_POST["title"];
        $author = $_POST["author"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $img = $_POST["img"];

        $parameters = [
            "title" => htmlspecialchars($title),
            "author" => htmlspecialchars($author),
            "description" => htmlspecialchars($description),
            "price" => htmlspecialchars($price),
            "img" => htmlspecialchars($img)

        ];
        try{
            StoreDB::insert($parameters);
            ViewHelper::redirect(BASE_URL ."managment");
        }
        catch (Exception $e) {
            echo "<p>Napaka pri vstavljanju: {$e->getMessage()}.</p>";
        }
    }

    public static function modify_book() {

        $title = $_POST["title"];
        $author = $_POST["author"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $img = $_POST["img"];
        $id = $_POST["id"];

        $parameters = [
            "id" => $id,
            "title" => htmlspecialchars($title),
            "author" => htmlspecialchars($author),
            "description" => htmlspecialchars($description),
            "price" => htmlspecialchars($price),
            "img" => htmlspecialchars($img)

        ];

        StoreDB::update($parameters);
        ViewHelper::redirect(BASE_URL ."managment");
    }

    public static function login() {
        $page_title="login" ;
        $parameters = [
            "page_title" => $page_title,
            "try" => 0,
            "msg" => ""
        ];

        echo ViewHelper::render("view/login.php", $parameters);
    }

    public static function updateProfile() {
        $page_title="update profile" ;
        $parameters = [
            "page_title" => $page_title,
        ];
        echo ViewHelper::render("view/updateProfile.php", $parameters);
    }

    public static function updateProfileDo(){
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $id = $_POST["id"];
        $isConfirmed = $_POST["isConfirmed"];

        if($_SESSION["user"]["permission"] == 2) {

            $street = $_POST["street"];
            $house_number =$_POST["house_number"];
            $post = $_POST["post"];
            $post_number = $_POST["post_number"];

            $parameters = [
                "street" => htmlspecialchars($street),
                "house_number" => htmlspecialchars($house_number),
                "post" => htmlspecialchars($post),
                "post_number" => htmlspecialchars($post_number),
                "id" => $_SESSION["user"]["adress"]
            ];

            StoreDB::updateAdress($parameters);
        }

        $parameters = [
            "firstname" => htmlspecialchars($firstname),
            "lastname" => htmlspecialchars($lastname),
            "email" => htmlspecialchars($email),
            "password" => htmlspecialchars($pass),
            "isConfirmed" => htmlspecialchars($isConfirmed),
            "id" => $id
        ];
        $certt = $_SESSION["user"]["certCN"];
        if($_POST["password"] == "") {
            StoreDB::updateUserNoPass($parameters);

            $_SESSION["user"] = StoreDB::getUser(["id" => $id]);
            echo "sem";
        }
        else {
            StoreDB::updateUser($parameters);
            $_SESSION["user"] = StoreDB::getUser(["id" => $id]);
        }
        $_SESSION["user"]["certCN"] = $certt;
        //var_dump($_SESSION);
        ViewHelper::redirect(BASE_URL . "profile");

    }

    public static function updateCustomer(){
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $id = $_POST["id"];
        $isConfirmed = $_POST["isConfirmed"];
        $street = $_POST["street"];
        $house_number =$_POST["house_number"];
        $post = $_POST["post"];
        $post_number = $_POST["post_number"];
        $adressId = $_POST["adressId"];

        $parameters = [
            "street" => htmlspecialchars($street),
            "house_number" => htmlspecialchars($house_number),
            "post" => htmlspecialchars($post),
            "post_number" => htmlspecialchars($post_number),
            "id" => htmlspecialchars($adressId)
        ];

        StoreDB::updateAdress($parameters);

        $parameters = [
            "firstname" => htmlspecialchars($firstname),
            "lastname" => htmlspecialchars($lastname),
            "email" => htmlspecialchars($email),
            "password" => htmlspecialchars($pass),
            "isConfirmed" => htmlspecialchars($isConfirmed),
            "id" => $id
        ];

        if($_POST["password"] == "") {
            StoreDB::updateUserNoPass($parameters);
        }
        else {
            StoreDB::updateUser($parameters);
        }

        ViewHelper::redirect(BASE_URL . "customers");
    }

    public static function try_login() {
        // Build POST request:
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6Lc2qQoaAAAAAG9AMnbwdmwdHTFHtgERvYxm4Qbm';
        $recaptcha_response = $_POST['recaptcha_response'];
        //var_dump($recaptcha_response);

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {
            $email= $_POST["email"];
            $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
            //var_dump($pass); // odkomentiraj da izves salted pass:
            //izvede login logiko
            //var_dump(functions::tryLogin($email,$_POST["password"]));
            functions::login($email,$_POST["password"]);
        } else {
            echo "You are a robot";
        }




    }

    public static function logout() {
        unset($_SESSION['user']);
        ViewHelper::redirect(BASE_URL ."home");
    }

    public static function register_page() {
        $page_title="Register" ;
        $parameters = [
            "page_title" => $page_title,
        ];
        echo ViewHelper::render("view/register.php", $parameters);
    }

    public static function register_do() {

        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6Lc2qQoaAAAAAG9AMnbwdmwdHTFHtgERvYxm4Qbm';
        $recaptcha_response = $_POST['recaptcha_response'];
        //var_dump($recaptcha_response);

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {


            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);;
            $dateCreated = date("Y/m/d");


            $street = $_POST["street"];
            $house_number = $_POST["house_number"];
            $post = $_POST["post"];
            $post_number = $_POST["post_number"];

            $parameters = [
                "street" => htmlspecialchars($street),
                "house_number" => htmlspecialchars($house_number),
                "post" => htmlspecialchars($post),
                "post_number" => htmlspecialchars($post_number),
            ];

            $adressid = StoreDB::createAdress($parameters);

            $parameters = [
                "firstname" => htmlspecialchars($firstname),
                "lastname" => htmlspecialchars($lastname),
                "email" => htmlspecialchars($email),
                "password" => htmlspecialchars($pass),
                "dateCreated" => htmlspecialchars($dateCreated),
                "permission" => 2,
                "isConfirmed" => 0,
                "isDeleted" => 0,
                "adress" => htmlspecialchars($adressid)
            ];
            if (isset($_POST["origin"]) && $_POST["origin"] == "seller") {
                $parameters["isConfirmed"] = 1;
            }

            $id = StoreDB::addUser($parameters);
            $par = ["id" => $id];
            $parameters = array_merge($parameters, $par);
            //NAREDI LOGIN
            if (isset($_POST["origin"]) && $_POST["origin"] == "seller") {
                ViewHelper::redirect(BASE_URL . "customers");
            } else {

                echo ViewHelper::render("view/validate.php", $parameters);

            }
        }
        else {
            echo "You are a robot";
        }

    }

    public static function register_do_no_captcha() {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);;
        $dateCreated = date("Y/m/d");


        $street = $_POST["street"];
        $house_number = $_POST["house_number"];
        $post = $_POST["post"];
        $post_number = $_POST["post_number"];

        $parameters = [
            "street" => htmlspecialchars($street),
            "house_number" => htmlspecialchars($house_number),
            "post" => htmlspecialchars($post),
            "post_number" => htmlspecialchars($post_number),
        ];

        $adressid = StoreDB::createAdress($parameters);

        $parameters = [
            "firstname" => htmlspecialchars($firstname),
            "lastname" => htmlspecialchars($lastname),
            "email" => htmlspecialchars($email),
            "password" => htmlspecialchars($pass),
            "dateCreated" => htmlspecialchars($dateCreated),
            "permission" => 2,
            "isConfirmed" => 0,
            "isDeleted" => 0,
            "adress" => htmlspecialchars($adressid)
        ];
        if (isset($_POST["origin"]) && $_POST["origin"] == "seller") {
            $parameters["isConfirmed"] = 1;
        }

        $id = StoreDB::addUser($parameters);
        $par = ["id" => $id];
        $parameters = array_merge($parameters, $par);
        //NAREDI LOGIN
        if (isset($_POST["origin"]) && $_POST["origin"] == "seller") {
            ViewHelper::redirect(BASE_URL . "customers");
        } else {

            echo ViewHelper::render("view/validate.php", $parameters);

        }
    }

    public static function checkout(){


        $date = date("Y/m/d");
        $parameters = [
            "userid" => $_SESSION["user"]["id"],
            "date" => $date,
            "status" => 0
        ];
        $orderId = (int)StoreDB::createOrder($parameters);


        foreach ($_SESSION["cart"] as $knjiga => $stevilo){

            $parameters1 = [
                "orderid" => $orderId,
                "bookid" => $knjiga-1,
                "quantity" => $stevilo
            ];
            unset($_SESSION['cart']);
            StoreDB::createOrderItem($parameters1);
        }
        $page_title="Checkout" ;
        $parameters = [
            "page_title" => $page_title,
        ];
        echo ViewHelper::render("view/checkout.php", $parameters);
    }

    public static function admin() {
        if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] == 0) {
            $page_title = "Admin view";
            $parameters = [
                "page_title" => $page_title,
                "sellers" => StoreDB::getSellers()
            ];
            echo ViewHelper::render("view/admin.php", $parameters);
        }
        else {
            echo "You are not allowed on this site!";
        }
    }

    public static function adminDo() {
        if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] == 0) {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $certCN = $_POST["certCN"];
            $permission = $_POST["permission"];
            $isDeleted = $_POST["isDeleted"];

            $parameters = [
                "firstname" => htmlspecialchars($firstname),
                "lastname" => htmlspecialchars($lastname),
                "email" => htmlspecialchars($email),
                "password" => htmlspecialchars($pass),
                "certCN" => htmlspecialchars($certCN),
                "permission" => htmlspecialchars($permission),
                "isDeleted" => htmlspecialchars($isDeleted)
            ];

            StoreDB::addSeller($parameters);
            ViewHelper::redirect(BASE_URL . "admin");
        }
        else {
            echo "You are not allowed on this site!";
        }
    }

    public static function modifySeller() {
        if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] == 0) {
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $page_title = "Admin view";
            $id = filter_input_array(INPUT_POST, $rules);

            $parameters = [
                "page_title" => $page_title,
                "seller" => StoreDB::getSeller($id)
            ];

            echo ViewHelper::render("view/modifySeller.php", $parameters);
        }
        else {
            echo "You are not allowed on this site!";
        }
    }

    public static function sellerModified() {
        if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] == 0) {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);;
            $certCN = $_POST["certCN"];
            $permission = $_POST["permission"];
            $isDeleted = $_POST["isDeleted"];
            $id = $_POST["id"];

            $parameters = [
                "firstname" => htmlspecialchars($firstname),
                "lastname" => htmlspecialchars($lastname),
                "email" => htmlspecialchars($email),
                "password" => htmlspecialchars($pass),
                "certCN" => htmlspecialchars($certCN),
                "permission" => htmlspecialchars($permission),
                "isDeleted" => htmlspecialchars($isDeleted),
                "id" => $id
            ];

            if ($_POST["password"] == "") {
                StoreDB::updateSellerNoPass($parameters);
            }
            else {
                StoreDB::updateSeller($parameters);
            }
            ViewHelper::redirect(BASE_URL . "admin");
        }
        else {
            echo "You are not allowed on this site!";
        }
    }

    public static function sellerDeleted() {
        if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] == 0) {
        $id = $_POST["id"];
        $parameters = [ "id" => $id];
        $seller = StoreDB::getSeller($parameters);
        if($seller["isDeleted"] == 0) {
            $seller["isDeleted"] = 1;
        }
        else {
            $seller["isDeleted"] = 0;
        }
        StoreDB::updateSeller($seller);
        ViewHelper::redirect(BASE_URL . "admin");
        }
        else {
            echo "You are not allowed on this site!";
        }
    }

    public static function customers() {

        $page_title="Manage users";
        $parameters = [
            "page_title" => $page_title,
            "users" => StoreDB::getCustomers()
        ];
        echo ViewHelper::render("view/customers.php", $parameters);

    }

    public static function manageCustomers(){
        if(isset($_POST["id"])){
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $id = filter_input_array(INPUT_POST, $rules);
            $user = StoreDB::getUser($id);
        }
        else{
            $user = 0;
        }

        $page_title="Add/edit user" ;
        $parameters = [
            "page_title" => $page_title,
            "user" => $user
        ];
        echo ViewHelper::render("view/modifyCustomer.php", $parameters);
    }

    public static function orders(){
        $page_title="Orders" ;
        $parameters = [
            "page_title" => $page_title,
            "orders" => StoreDB::getOrders()
        ];
        echo ViewHelper::render("view/orders.php", $parameters);
    }
    public static function modifyOrder(){
        $modify = $_POST["do"];

        $parameters = [
            "status" => $modify,
            "id" => $_POST["id"]
        ];

        StoreDB::modifyOrders($parameters);
        ViewHelper::redirect(BASE_URL."orders");
    }
    public static function userValidate() {
        $page_title = "Mail verification";
        $parameters = [
            "page_title" => $page_title,
            ];
        echo ViewHelper::render("view/validate.php", $parameters);
    }

    public static function validate () {
        $hash = $_GET["hash"];
        $id = openssl_decrypt($hash,"AES-128-ECB","123gesloidkvseenmije");

        $parameters = [
            "id" => $id
        ];
        $user = StoreDB::getUser($parameters);

        if($user["isConfirmed"] == 0) {
            $user["isConfirmed"] = "1";
            StoreDB::updateUser($user);
            echo 'Email ' . $user["email"] . ' verified!';
        }
        else {
            echo 'This user has already been verified.';
        }
    }
    public static function activateCostumer(){
        $parameters = [
            "status" => $_POST["activate"],
            "id" => $_POST["id"]
        ];
        StoreDB::deleteCostumer($parameters);
        ViewHelper::redirect(BASE_URL."customers");
    }

    public static function getOwnOrders(){
        $page_title="My orders" ;
        $parameters = [
            "page_title" => $page_title,
            "orders" => StoreDB::getOwnOrders()
        ];
        echo ViewHelper::render("view/userOrders.php", $parameters);
    }

    public static function addImgToBook(){
        $name = $_FILES["myfile"]["name"];
        $type = $_FILES["myfile"]["type"];
        //var_dump($name);
        $data = file_get_contents($name = $_FILES["myfile"]["tmp_name"]);
        //var_dump($data);

        $bookId = $_POST["bookId"];

        $parameters = [
            "bookId" => htmlspecialchars($bookId),
            "imgblob" =>  $data
        ];


        try{
            StoreDB::insertImage($parameters);
            //var_dump($bookId);
            if(isset($_POST["bookId"])){
                $rules = [
                    "id" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => ['min_range' => 1]
                    ]
                ];

                $id = filter_input_array(INPUT_POST, $rules);
                $book = StoreDB::get($id);
            }
            else{
                $book = 0;
            }
            //var_dump($bookId);
            $page_title="BookManagment";
            $parameters = [
                "page_title" => $page_title,
                "book" => $book
            ];
            echo ViewHelper::render("view/modify.php", $parameters);
        } catch (Exception $e) {
            echo "<p> Error inserting img: {$e->getMessage()}.</p>";
        }
    }
    public static function  deleteImgBook(){
        try{
            if(isset($_POST["id"])){
                $rules = [
                    "id" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => ['min_range' => 1]
                    ]
                ];
                $id = filter_input_array(INPUT_POST, $rules);
                $book = StoreDB::deleteImage($id);
            }

//            $page_title="BookManagment";
//            $parameters = [
//                "page_title" => $page_title,
//            ];
//            echo ViewHelper::render("view/managment.php", $parameters);
        } catch (Exception $e) {
            echo "<p> Error inserting img: {$e->getMessage()}.</p>";
        }
    }

    public static function rate() {
        $userid = $_SESSION["user"]["id"];
        $bookid = $_POST["bookid"];
        $rating = $_POST["rating"];

        $parameters = [
            "userid" => htmlspecialchars($userid),
            "bookid" => htmlspecialchars($bookid),
            "rating" => htmlspecialchars($rating)
        ];
        if ($_SESSION["user"]["permission"] == 2) {
            $ratingId = StoreDB::getRating($parameters);
            if ($ratingId == null) {
                StoreDB::insertRating($parameters);
            } else {
                StoreDB::updateRating($parameters);
            }
        }
        ViewHelper::redirect(BASE_URL . "/article?id=". $bookid);
    }

    public static function searchGet() {
        $page_title= "Home" ;
        $params = [
            "searchString" => htmlspecialchars($_GET["searchString"])
        ];
        $parameters = [
            "page_title" => $page_title,
            "searchString" => $params["searchString"],
            "books" => StoreDB::getSpecificBooks($params)
        ];

        echo ViewHelper::render("view/home.php", $parameters);
    }
}