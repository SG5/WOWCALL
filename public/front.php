<?php
require __DIR__ . '/../app/config.php';
spl_autoload_register(function ($class) {
    include __DIR__."/../app/{$class}.php";
});

$payload = $_POST;
if (isset($_GET["callback"])) {
    $payload["class"]  = "Ivr";
    $payload["action"] = "getXml";
    $payload["data"]   = [$_GET["callback"]];
} elseif (isset($_GET["file"]) && !empty($_FILES)) {
    $payload["class"]  = "File";
    $payload["action"] = "receiveWowcall";
    $payload["data"]   = [$_FILES];
}

if (!empty($payload)) {
    $class  = $payload["class"] . "Handler";
    $handler = new $class;

    if (method_exists($handler, $payload["action"])) {
        echo call_user_func_array(
            [$handler, $payload["action"]],
            $payload["data"]
        );
    }
    return;
}
