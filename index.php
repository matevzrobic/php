<?php

// enables sessions for the entire app
//session_start();

require_once("controller/StoreController.php");
require_once("controller/StoreRestController.php");
require_once("resources/fractions/functions.php");
session_start();

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "resources/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "resources/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "/";

// ROUTER

// 0 - admin
// 1 - seller
// 2 - customer
// null - anonymous

$urls = [

    "/^home$/" => function () {
        StoreController::index();
    },
    "/^cart$/" => function () {
        if(checkPermission(2)){
            StoreController::cart();
        }
    },
    "/^cart\/update$/" => function () {
        if(checkPermission(2)){
            StoreController::cartUpdate();
        }
    },
    "/^profile$/" => function () {
        StoreController::profile();
    },
    "/^profile\/update$/" => function () {
        if(checkPermission(2)){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                StoreController::updateProfileDo();
            }
            else{
                StoreController::updateProfile();
            }
        }
    },
    "/^profile\/validate$/" => function () {
        StoreController::userValidate();
    },
    "/^managment$/" => function () {
        if(checkPermission(1)){
            StoreController::managment();
        }
    },
    "/^managment\/modify\/add$/" => function () {
        if(checkPermission(1)){
            if($_POST['do'] == "new"){
                StoreController::add_book();
            }
            else{
                StoreController::modify_book();
            }
        }
    },
    "/^article$/" => function () {
        StoreController::article();
    },
    "/^login/" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            StoreController::try_login();
        }
        else{
            StoreController::login();
        }
    },
    "/^logout/" => function () {
        StoreController::logout();
    },
    "/^managment\/modify/" => function () {
        if(checkPermission(1)){
            StoreController::manageBooks();
        }
    },
    "/^register/" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            StoreController::register_do();
        }
        else{
            StoreController::register_page();
        }

    },
    "/^checkout/" => function () {
        if(checkPermission(2)){
            StoreController::checkout();
        }
    },
    "/^admin$/" => function () {
        if(checkPermission(0)){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            StoreController::adminDo();
            }
            else {
                StoreController::admin();
            }
        }
    },
    "/^admin\/modifySeller$/" => function () {
        if(checkPermission(0)) {
            StoreController::modifySeller();
        }
    },
    "/sellerModified/" => function () {
        if(checkPermission(0)) {
            StoreController::sellerModified();
        }
    },
    "/sellerDeleted/" => function () {
        if(checkPermission(0)) {
            StoreController::sellerDeleted();
        }
    },
    "/^customers$/" => function () {
        if(checkPermission(1)) {
            StoreController::customers();
        }
    },

    "/^customers\/modify$/" => function () {
        if(checkPermission(1)) {
            StoreController::manageCustomers();
        }
    },

    "/^customers\/modify\/add$/" => function() {
        if (checkPermission(1)) {
            if (isset($_POST['do']) && $_POST['do'] == "new") {
                StoreController::register_do_no_captcha();
            } else {
                StoreController::updateCustomer();
            }
        }
    },
    "/^orders$/" => function () {
        if (checkPermission(1)) {
            StoreController::orders();
        }
    },
    "/^orders\/activate$/" => function () {
        if (checkPermission(1)) {
            StoreController::modifyOrder();
        }
    },
    "/^validate$/" => function () {
        StoreController::validate();
    },
    "/^costumers\/activate$/" => function () {
        if (checkPermission(1)) {
            StoreController::activateCostumer();
        }
    },
    "/^my\-orders$/" => function () {
        if (checkPermission(2)) {
            StoreController::getOwnOrders();
        }
    },
    "/^managment\/image$/" => function(){
        if (checkPermission(1)) {
            StoreController::addImgToBook();
        }
    },
    "/^managment\/delete-image$/" => function(){
        if (checkPermission(1)) {
            StoreController::deleteImgBook();
        }
    },
    "/^rate$/" => function() {
        if (checkPermission(2)) {
            StoreController::rate();
        }
    },
    "/^search$/" => function() {
        StoreController::searchGet();
    },
    "/^$/" => function () {
        ViewHelper::redirect(BASE_URL . "home");
    },

    # REST API
    "/^api\/books\/(\d+)$/" => function ($method, $id) {
        // TODO: izbris knjige z uporabo HTTP metode DELETE
        switch ($method) {
            case "PUT":
                StoreRestController::editBook($id);
                break;
            default: # GET
                StoreRestController::getBooksById($id);
                break;
        }
    },
    "/^api\/books$/" => function ($method) {
        switch ($method) {
            case "POST":
                StoreRestController::addBook();
                break;
            default: # GET
                StoreRestController::getBooks();
                break;
        }
    },

    "/^api\/login$/" => function ($method) {
            StoreRestController::login();
    },
    "/^api\/modifyProfile$/" => function ($method){
        StoreRestController::modifyProfile();
    },
    "/^api\/orders\/(\d+)$/" => function ($method, $id){
        StoreRestController::getOwnOrders($id);
    },
    "/^api\/order\/(\d+)$/" => function ($method, $id){
        StoreRestController::getOrder($id);
    },
    "/^api\/cart\/(\d+)$/" => function ($method, $id){
        if ($method == "GET") {
            StoreRestController::getCart($id);
        } if ($method == "POST") {
            StoreRestController::addToCart($id);
        } if ($method == "DELETE") {
            StoreRestController::deleteCart($id);
        }
    },
    "/^api\/checkout\/(\d+)$/" => function ($method, $id) {
        StoreRestController::cartToCheckoutFromDB($id);
    }




];


function checkPermission($permission) {
    if  (isset($_SESSION["user"])
        && isset($_SESSION["user"]["permission"])
        && ($_SESSION["user"]["permission"]) != null
        && $_SESSION["user"]["permission"] <= $permission){
        return true;
    }else{
        StoreController::unauth();
        return false;
    }
}


foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
//            ViewHelper::error404();
            StoreController::error("404");
        } catch (Exception $e) {
//            ViewHelper::displayError($e, true);
            StoreController::error($e);
        }
        exit();
    }
}

//ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);
StoreController::error("View not found.");
