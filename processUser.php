<?php
    $log;
    //if (!file_exists("./room/users/" . $_POST['userid'] . ".txt") {
        $fp = fopen("./room/users/" . $_POST['userid'] . ".txt", "w");
        fwrite($fp, $_POST['userpass']);
        fclose($fp);
    //}

    echo json_encode($log);
?>