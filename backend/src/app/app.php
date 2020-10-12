<?php

use Slim\Factory\AppFactory;

require_once __DIR__. '/Dotenv.php';

$app = AppFactory::create();

require_once __DIR__. '/Cors.php';

$app->addBodyParsingMiddleware();

require_once __DIR__. '/ErrorHandler.php';

require_once __DIR__. '/Routes.php';

$app->run();
