<?php
function myRequireOnce($filename){
    //_appendMyRequireOnce('myRequireOnce', "\n\n$subdirectory/$filename\n");
    $new_name = null;
    if (file_exists(DEFAULT_PHP_DIRECTORY . $filename)){
        $new_name = DEFAULT_PHP_DIRECTORY . $filename;
    }
    if (isset($_SESSION['user']) ){
        if (file_exists(TESTING_PHP_DIRECTORY . $filename) && $_SESSION['user'] ==  DEVELOPER){
            $new_name = TESTING_PHP_DIRECTORY . $filename;
        }
    }
    require_once($new_name);
}

function myRequireOnceSetup($user){
    $_SESSION['user'] = $user;
    return;
}
