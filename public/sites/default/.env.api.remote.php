<?php
// toto: restore these
//require_once ('vendor/autoload.php');
//use ReallySimpleJWT\Token;
define("LOG_MODE", 'write_log');
define("SITE_CODE", 'mylanguage');

define("VERSION", '2.10');
define("DBT_KEY", '3d116e49d7d98c6e20bf0f4a9c88e4cc');
define('VIDEO_WIDTH', 480);
define ("ROOT",  '/home/globa544/' );


define ('DIR_SITE', 'sites/' . SITE_CODE . '/');
define ('DIR_DEFAULT_SITE', 'sites/default/');

define("HOST", "localhost");
define("USER", "globa544_pro-34ap");
define("DEVELOPER", 11);
define("PASS", "g5x+8JfQ3xCin9=_@u");
define("DATABASE_CONTENT", "globa544_pro-ap34");
define("DATABASE_BIBLE", "globa544_pro-ap34");
define("DATABASE_PORT", 3306);

define('WEBADDRESS', 'https://edit.mc2.online');

define('ACCEPTABLE_IP', 'https://edit.mc2.online');
define('LOCAL_TOKEN', 'JY^&%$Goiuts2');
define("LOGIN_SECRET", 's0hygedSuSMc2T423*&');
define("LOGIN_ISSUER", 'myfriends.network');

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
    header("Access-Control-Allow-Origin: " . ACCEPTABLE_IP);
    header("Access-Control-Allow-Methods: POST, GET");
}


