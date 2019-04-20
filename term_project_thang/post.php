<!DOCTYPE html>
<html>

<body>
<?php
session_start();
if (isset($_SESSION['name'])) {
    $text = $_POST['text'];

    $fp = fopen("log.html", 'w');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
}
?>
</body>

</html>