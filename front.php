<?php
require __DIR__.'/config.php';

$payload = $_POST;
if (isset($_GET["callback"])) {
    $payload["class"]  = "Ivr";
    $payload["action"] = "getXml";
    $payload["data"]   = [$_GET["callback"]];
}

if (!empty($payload)) {
    $class  = $payload["class"] . "Handler";

    require __DIR__."/{$class}.php";
    $handler = new $class;

    if (method_exists($handler, $payload["action"])) {
        echo call_user_func_array(
            [$handler, $payload["action"]],
            $payload["data"]
        );
    }
    return;
}

