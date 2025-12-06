<?php

error_reporting(E_ALL & ~E_WARNING);

error_reporting(0);

ini_set('display_errors', 0);

define("ROOT_URL", "https://hmimpex.com/");

define("ADMIN_URL", "https://hmimpex.com/admin/");

define("ADMIN_UPLOAD_URL", "https://hmimpex.com/admin/uploads/");

define('BASE_APP',str_replace('\\','/',__DIR__).'/' );

define('DB_HOST', 'localhost');

define('DB_USER', 'srv1_blite');

define('DB_PASS', 'y-@#F5rD69pqCKpD');

define('DB_NAME', 'srv1_blite');



define('API_BASE_URL', 'https://idietapi.nccauh.ae/api/');

define('GRANT_TYPE', 'password');

define('API_USERNAME', 'blite.Creotopi');

define('API_PASSWORD', 'Bl!t3#Cre0top!');

define('SCOPE', 'mobile');

define('TOKEN_ENDPOINT', 'AuthToken/GetToken');

ob_start();

session_set_cookie_params([
    'lifetime' => 86400,       // 1 day (or your preferred long time)
    'path' => '/',
    'domain' => '.hmimpex.com', // allow subdomains if any
    'secure' => true,           // must be HTTPS
    'httponly' => true,
    'samesite' => 'None'        // required for cross-site redirects
]);

session_start();