<?php

class ViewHelper {

    //Displays a given view and sets the $variables array into scope.
    public static function render($file, $variables = array()) {
        extract($variables);

        ob_start();
        include($file);
        return ob_get_clean();
    }

    // Redirects to the given URL
    public static function redirect($url) {
        header("Location: " . $url);
    }

    public static function renderJSON($data, $httpResponseCode = 200) {
        header('Content-Type: application/json');
        http_response_code($httpResponseCode);
        return json_encode($data);
    }

    // Displays a simple 404 message
    public static function error404() {
        header('This is not the page you are looking for', true, 404);
        $html404 = sprintf("<!doctype html>\n" .
            "<title>Error 404: Page does not exist</title>\n" .
            "<h1>Error 404: Page does not exist</h1>\n" .
            "<p>The page <i>%s</i> does not exist.</p>", $_SERVER["REQUEST_URI"]);

        echo $html404;
    }

}
