<?php
require_once("ViewHelper.php");
require_once("model/StoreDB.php");
require_once("resources/fractions/functions.php");
require_once("controller/StoreController.php");

class StoreRestController
{
    public static function getRules() {
        return [
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'author' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => FILTER_VALIDATE_FLOAT,
            'year' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1800,
                    'max_range' => date("Y")
                ]
            ]
        ];
    }
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }



    public static function getBooks(){
        try {
            echo ViewHelper::renderJSON(StoreDB::getAllBooks());
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function getBooksById($id){
        try {
            echo ViewHelper::renderJSON(StoreDB::get(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function addBook() {
        $data = filter_input_array(INPUT_POST, BooksController::getRules());

        if (self::checkValues($data)) {
            $id = StoreDB::insert($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/books/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function editBook($id) {
        //spremenljivka $_PUT ne obstaja, zato jo moremo narediti sami
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = filter_var_array($_PUT, self::getRules());

        if (self::checkValues($data)) {
            $data["id"] = $id;
            StoreDB::update($data);
            echo ViewHelper::renderJSON("", 200);
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function getCostumers(){
        try {
            echo ViewHelper::renderJSON(StoreDB::getUsers());
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function getCostumerById($id){
        try {
            echo ViewHelper::renderJSON(StoreDB::getUser(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function getOwnOrders($id) {
        try {
            //$orders = StoreDB::getOrdersById(["id" => $id]);
            //echo ViewHelper::renderJSON(StoreDB::getOrders());
            echo ViewHelper::renderJSON(StoreDB::getOrdersById(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function getOrder($id) {
        try {
            echo ViewHelper::renderJSON(StoreDB::getOrderDetails(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function login()
    {
//        echo $_POST["email"];
//        echo $_POST["pass"];

//        if(isset($entityBody["email"]) && isset($entityBody["pass"])){
        try {
//                $entityBody = json_decode(file_get_contents('php://input'), true);
            //$data = filter_var_array($_POST, self::getRules());
            $headers = apache_request_headers();
//            echo $headers;

            $entityBody = $_POST;
            $user = functions::VerifyLogin($entityBody["email"], $entityBody["pass"]);
            if ($user != null) {
                $phpsessid = explode("=", $headers["Cookie"])[1];
                session_write_close();
                session_id($phpsessid);
                session_start();
                $_SESSION["user"] = $user;
//                echo $_SESSION['somekey'];

//                $user["PHPSESSID"] = $headers["Cookie"];
//                $user["PHPSESSID"] = implode("|", apache_request_headers());
//                $user["PHPSESSID"] = $phpsessid;
                $user["PHPSESSID"] = implode("|", $_SESSION["user"]);
                echo ViewHelper::renderJSON($user, 200);
            } else {
//                echo ViewHelper::renderJSON("Login Failed" . implode("", $entityBody) , 401);
                echo ViewHelper::renderJSON("Login Failed", 401);
            }
        } catch (InvalidArgumentException $e) {
//            echo ViewHelper::renderJSON($e->getMessage(), 404);
            echo ViewHelper::renderJSON("Big error", 404);
        }
//        }else{
//            echo ViewHelper::renderJSON("Bad params", 400);
//        }

//    }
    }



    public static function modifyProfile()
    {
//        echo $_POST["email"];
//        echo $_POST["pass"];

//        if(isset($entityBody["email"]) && isset($entityBody["pass"])){
        try {
//                $entityBody = json_decode(file_get_contents('php://input'), true);
            //$data = filter_var_array($_POST, self::getRules());
            $entityBody = $_POST;
            //$user = functions::VerifyLogin($entityBody["email"], $entityBody["pass"]);

            $firstname = $entityBody["firstname"];
            $lastname = $entityBody["lastname"];
            $email = $entityBody["email"];
            $pass = password_hash($entityBody["pass"], PASSWORD_BCRYPT);
            $id = $entityBody["id"];
            $isConfirmed = $entityBody["isConfirmed"];
            $street = $entityBody["street"];
            $house_number =$entityBody["house_number"];
            $post = $entityBody["post"];
            $post_number = $entityBody["post_number"];
            $adress = $entityBody["adress"];

            $parameters1 = [
                "street" => htmlspecialchars($street),
                "house_number" => htmlspecialchars($house_number),
                "post" => htmlspecialchars($post),
                "post_number" => htmlspecialchars($post_number),
                "id" => (int)htmlspecialchars($adress)
            ];
            StoreDB::updateAdress($parameters1);



            if($entityBody["pass"] == "") {
                $parameters = [
                    "firstname" => htmlspecialchars($firstname),
                    "lastname" => htmlspecialchars($lastname),
                    "isConfirmed" => htmlspecialchars($isConfirmed),
                    "email" => htmlspecialchars($email),
                    "id" => (int)$id
                ];
                StoreDB::updateUserNoPass($parameters);
            }
            else {
                $parameters = [
                    "firstname" => htmlspecialchars($firstname),
                    "lastname" => htmlspecialchars($lastname),
                    "email" => htmlspecialchars($email),
                    "isConfirmed" => htmlspecialchars($isConfirmed),
                    "password" => htmlspecialchars($pass),
                    "id" => (int)$id
                ];
                StoreDB::updateUser($parameters);
            }

            $user = StoreDB::getUser(["id" => $id]);
            if ($user != null) {
                echo ViewHelper::renderJSON($user, 200);
            } else {
//                echo ViewHelper::renderJSON("Login Failed" . implode("", $entityBody) , 401);
                echo ViewHelper::renderJSON($parameters, 401);
            }


        } catch (InvalidArgumentException $e) {
//            echo ViewHelper::renderJSON($e->getMessage(), 404);
            echo ViewHelper::renderJSON("Big error", 404);
        }
//        }else{
//            echo ViewHelper::renderJSON("Bad params", 400);
//        }

//    }
    }

    public static function addToCart($id){
        $cart = self::getCartList($id);
        echo ViewHelper::renderJSON($cart, 200) ;
        $added = false;
        foreach ($cart as $key=>$item){
            echo ViewHelper::renderJSON($cart[$key], 200) ;
            if($cart[$key]["id"] == $_POST["bookId"]){
                $cart[$key]["quantity"] = $cart[$key]["quantity"] + 1;
                $added = true;
            }
        }
        $simple_cart = array();
        foreach ($cart as $key=>$item) {
            $simple_cart_item = array();
            $simple_cart_item[0] = $item["id"];
            $simple_cart_item[1] = $item["quantity"];
            $simple_cart[] = implode(",",$simple_cart_item);
        }

        if($added == false){
            $simple_cart_item = array();
            $simple_cart_item[0] = $_POST["bookId"];
            $simple_cart_item[1] = 1;
            $simple_cart[] = implode(",",$simple_cart_item);
        }

        $cart_string = implode("|",$simple_cart);
        echo ViewHelper::renderJSON($cart_string, 200) ;
        StoreDB::setCart(["cart" => $cart_string, "id" => $id]);
    }

    public static function deleteCart($id)
    {
        storeDB::deleteCart(["id" =>$id]);
        echo ViewHelper::renderJSON("Cart emptied.", 200) ;
    }

    private static function getCartList($id){
        try{
            $cart_string = StoreDB::getCart(["id" => $id]);
            if($cart_string[0]["cart"] == null || strlen($cart_string[0]["cart"]) < 1){
                return [];
            }
            $cart = explode("|", $cart_string[0]["cart"]);
            $new_cart = array();
            foreach ($cart as $item){
                $new_item = array();
                $item_array = explode(",",$item);
                $new_item["id"] = $item_array[0];
                $new_item["quantity"] = $item_array[1];
                $book = StoreDB::get(["id" => $new_item["id"]]);
                $new_item["title"] = $book["title"];
                $new_item["author"] = $book["author"];
                $new_item["description"] = $book["description"];
                $new_item["price"] = $book["price"];
                $new_cart[] = $new_item;
            }
            return $new_cart;
        }catch(Exception $e){
            return [];
        }

    }

    public static function getCart($id){
        $cart = self::getCartList($id);
        echo ViewHelper::renderJSON($cart, 200) ;
        return $cart;
    }

    public static function cartToCheckoutFromDB($id){
        $cart = self::getCartList($id);

        $date = date("Y/m/d");
        $parameters = [
            "userid" => $id,
            "date" => $date,
            "status" => 0
        ];
        $orderId = (int)StoreDB::createOrder($parameters);

        foreach ($cart as $knjiga){
            echo ViewHelper::renderJSON($knjiga, 200) ;
            $parameters1 = [
                "orderid" => $orderId,
                "bookid" => $knjiga["id"],
                "quantity" => $knjiga["quantity"]
            ];
            StoreDB::createOrderItem($parameters1);
        }

        storeDB::deleteCart(["id" => $id]);
        echo ViewHelper::renderJSON("Order added! Cart emptied.", 200) ;
    }
}
