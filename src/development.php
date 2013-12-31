<?php
require_once __DIR__ . "/../vendor/autoload.php";

putenv("APP_ENV=dev");

/* @var \Silex\Application $app */
$app = require __DIR__ . "/app.php";

require __DIR__ . "/providers.php";
require __DIR__ . "/controllers.php";

return $app;