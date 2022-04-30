<?php
// toto: restore these
//require_once ('vendor/autoload.php');
//use ReallySimpleJWT\Token;
define("LOG_MODE", 'write_log');
define("SITE_CODE", 'mylanguage');
define ("ROOT_LOGS",  'c:/ampp/htdocs/logs/' );

define("VERSION", '0.01');
define("DBT_KEY", '3d116e49d7d98c6e20bf0f4a9c88e4cc');
define('VIDEO_WIDTH', 480);
define ("ROOT_DIR",  'c:/ampp/htdocs/mylanguage-vue3/' );

define ("ROOT_URL",  'http://10.1.1.245/mylanguage-vue3/' );

define ("CONTENT_DIRECTORY", ROOT_DIR . 'public/sites/default/content/');
define ("CONTENT_URL", ROOT_URL . 'public/sites/default/content/');


define ('DIR_DEFAULT_SITE', 'public/sites/default/');
define('DEFAULT_PHP_DIRECTORY', ROOT_DIR. 'public/sites/default/php/');
define('TESTING_PHP_DIRECTORY', ROOT_DIR. 'public/sites/testing/php/');

/*define("HOST", "localhost:9443");
define("USER", "mylanguage2019");
define("DEVELOPER", 11);
define("PASS", "ULuMOg13MZ01o0Sz");
define("DATABASE", "mylanguage2022");
define("DATABASE_PORT", 9306);
define("CHARSET", 'utf8');
define("DSN", 'mysql:host=' . HOST . ';dbname='. DATABASE .';charset='. CHARSET );
*/

define("HOST", "localhost");
define("USER", "mylanguagevuejs");
define("DEVELOPER", 11);
define("PASS", "ULu98&6(01o0Sz");
define("DATABASE", "mylanguagevuejs");
define("DATABASE_PORT", 3306);
define("CHARSET", 'utf8');
define("DSN", 'mysql:host=' . HOST . ';dbname='. DATABASE .';charset='. CHARSET );

define('WEBADDRESS', 'https://edit.mc2.online');

define('ACCEPTABLE_IP', '*');
define('LOCAL_TOKEN', 'JY^&%$Goiuts2');
define("LOGIN_SECRET", 's0hygedSuSMc2T423*&');
define("LOGIN_ISSUER", 'mylanguage.network');

function  myApiAuthorize($token){
    if ($token == LOCAL_TOKEN){
        $ok = true;
    }
    else{
        $ok = false;
    }

    return true;
}
function myApiLogin($p) {
    $sql = "SELECT uid, password, firstname, lastname, scope_countries, scope_languages, start_page FROM members
    WHERE username = '". $p['username'] . "' LIMIT 1";
    $content = sqlArray($sql);
    if (!$content){
        $out['debug'] .= 'NOT authorized' . "\n";
        return $out;

    }
    $hash = $content['password'];
    if (password_verify($p['password'], $hash)) {
        $expiration = time() + 360000;
        $content['expires'] = $expiration;
        $content['password'] = null; // we return content so blank it out now.
        $content[1] = null; // we return content so blank it out now.
        $content['token'] = LOCAL_TOKEN;
        $out = $content;
        $out['debug'] = 'authorized' . "\n";
    }
    else {
        $out['debug'] = $sql . "\n";
        $out['debug'] .= 'NOT authorized' . "\n";
    }
    return $out;
}


function myHeaders(){
   header("Access-Control-Allow-Origin:" . ACCEPTABLE_IP);
    header("Access-Control-Allow-Methods: POST, GET");
}
