<?php

$method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);

if ($method == "POST") {
    $validationRules = [
        'do' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                // dopustne vrednosti spremenljivke do, popravi po potrebi
                "regexp" => "/^(add_into_cart|purge_cart|remove_from_cart)$/"
            ]
        ],
        'id' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ]
    ];

    $post = filter_input_array(INPUT_POST, $validationRules);

    if ($post["do"] == "add_into_cart") {
        try {
            $id = $post["id"];

            if (isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id]++;
            } else {
                $_SESSION["cart"][$id] = 1;
            }
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }
    elseif ($post["do"] == "remove_from_cart"){
        try{
            $id = $post["id"];
            if($_SESSION['cart'][$id]==1){
                unset($_SESSION['cart'][$id]);
            }
            elseif (isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id]--;
            }
        } catch (Exception $ex) {
            die($exc->getMessage());
        }


    }
}
?>