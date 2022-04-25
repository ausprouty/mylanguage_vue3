<?php




 // // see https://www.youtube.com/watch?v=kEW6f7Pilc4

function getUidFromEmail($email){
    $sql = 'SELECT uid FROM users WHERE email = :email';
    $data = array(
        'email' => $email
    );
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $data = $stmt->fetch();
    $output = $data->uid;
    return ($output);
}

function sqlReturnObjectMany($sql, $data){
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $output = $stmt->fetchAll();
    return ($output);
}
function sqlReturnObjectOne($sql, $data){
	$output = [];
	$pdo = new PDO (DSN, USER, PASS);
	$pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute ($data);
	$output= $stmt->fetch();
	return ($output);
}

function sqlSafe($sql, $data){
    $output=[];
    $output['debug'] = 'ran sqlSafe ' ."\n";
	$pdo = new PDO (DSN, USER, PASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	return ($output);
}
function sqlReturnArrayMany($sql, $data){
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $output = $stmt->fetchAll();
    return ($output);
}
function sqlReturnArrayOne($sql, $data){
    $pdo = new PDO (DSN, USER, PASS);
    $pdo->SetAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare($sql);
    $stmt->execute ($data);
    $output = $stmt->fetch();
    return ($output);
}
