<?php




 // // see https://www.youtube.com/watch?v=kEW6f7Pilc4
 /*
define("HOST", "localhost:9443");
define("USER", "mc22020");
define("PASS", "ULuMOg13MZ01o0Sz");
define("DATABASE", "mylanguage2022");
define("DATABASE_PORT", 9306);
define("CHARSET", 'utf8');
define("DSN", 'mysql:host=' . HOST . ';dbname='. DATABASE .';charset='. CHARSET );
*/


function  sqlFetchObject ($sql, $data){
    //writeLogDebug('sqlFetchObject-19', $sql);
    //writeLogDebug('sqlFetchObject-20', $data);
    $pdo = new PDO (DSN, USER, PASS);
    //writeLogDebug('sqlFetchObject-22', DSN);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
     //writeLogDebug('sqlFetchObject-24', USER);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //writeLogDebug('sqlFetchObject-26', $pdo);
    $stmt = $pdo->prepare($sql);
    // writeLogDebug('sqlFetchObject-28', $stmt);
    $stmt->execute ($data);
    //writeLogDebug('sqlFetchObject-30', $stmt);
    $output = $stmt->fetch();
    //writeLogDebug('sqlFetchObject-32', $output);
    return $output;

}

function sqlFetchObjects($sql, $data){
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $output = $stmt->fetchAll();
    return ($output);
}
function sqlFetchObjectOne($sql, $data){
	$output = [];
	$pdo = new PDO (DSN, USER, PASS);
	$pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute ($data);
	$output= $stmt->fetch();
	return ($output);
}

function sql($sql, $data){
    $output=[];
    $output['debug'] = 'ran sqlSafe ' ."\n";
	$pdo = new PDO (DSN, USER, PASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	return ($output);
}
function sqlFetchArrayMany($sql, $data){
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $output = $stmt->fetchAll();
    return ($output);
}
function sqlFetchArrayOne($sql, $data){
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $output = $stmt->fetch();
    return ($output);
}
