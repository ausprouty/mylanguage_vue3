<?php
$debug = 'Content API Post' . "\n";
$backend = '.env.api.'.  $_GET['location'] . '.php';

if (file_exists($backend)){
	require_once ($backend);
}
else{
	trigger_error("No backend for  Content Api: $backend", E_USER_ERROR);
}
require_once('core/myRequireOnce.php');
require_once('core/writeLog.php');
require_once('core/myLink.php');
require_once('core/sql.php');
require_once('core/translate.php');
require_once('core/validateParameters.php');



$p = array();
$out = null;
$p = getParameters();
if (isset($p['my_uid'])){
    myRequireOnceSetup($p['my_uid']);
}
$action = $p['action'];
myRequireOnce( $action . '.php');
$parts = explode('/', $action);

$call= end($parts);
$out= $call($p);
myHeaders(); // send cors headers
$debug .= "\n\n\n";
$debug .= strlen(json_encode($out, JSON_UNESCAPED_UNICODE));
$debug .= "\n\nHERE IS JSON_ENCODE OF DATA\n";
$debug .= json_encode($out, JSON_UNESCAPED_UNICODE) . "\n";
$fn = "ContentApi-" . $call ;
writeLogDebug($fn, $debug);
header("Content-type: application/json");
echo json_encode($out, JSON_UNESCAPED_UNICODE);
die();

//
//   FUNCTIONS
//
// we clean parameters because people may be adding crummy stuff
function getParameters(){

    $conn = new mysqli(HOST, USER, PASS, DATABASE, DATABASE_PORT);
    foreach ($_POST as $param_name => $param_value) {
        //$p[$param_name] = $conn->real_escape_string($param_value);
        $p[$param_name] = $param_value;
        if ($p[$param_name] == 'null'){
            $p[$param_name] = NULL;
        }
    }
    writeLogDebug('ContentSetParameters-p', $p);
    return $p;
}