<!DOCTYPE html>
<html>

<head>
    <title>Chat Webpage</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    session_start();

    function loginForm() {
        echo '
        <div id="loginform">
        <form action="index.php" method="post">
            <p>Please enter your name to continue:</p>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <input type="submit" name="enter" id="enter" value="Enter">
        </form>
        </div>
        ';
    }

    if (isset($_POST['enter'])) {
        if ($_POST['name'] != "") {
            $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        }
        else {
            echo '<span class="error">Please type in a name</span>';
        }
    }

    if (isset($_GET['logout'])) {
        // Exit message
        $fp = fopen("log.html", 'a');
        fwrite($fp, "<div class='msgln'><i>User ".$_SESSION['name']." has left the chat session.</i><br></div>");
        fclose($fp);

        session_destroy();
        header("Location: index.php"); // Redirects back to start
    }

    if (!isset($_SESSION['name'])) {
        loginForm();
    }
    else {
    ?>
    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        <div style="clear:both"></div>
    
        <div id="chatbox"><?php
        if (file_exists("log.html") && filesize("log.html")>0) {
            $handle = fopen("log.html", "r");
            $contents = fread($handle, filesize("log.html"));
            fclose($handle);

            echo $contents;
        }
        ?></div>
        
        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" size="63">
            <input name="submitmsg" type="submit" id="submitmsg" value="Send">
        </form>
    </div>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
    // jQuery Document
    $(document).ready(function(){
        // If user wants to end session
        $("#exit").click(function() {
            var exit = confirm("Are you sure you want to end the session?");
            if (exit==true) {
                window.location = 'index.php?logout=true';
            }
        });

        // If user submits the form
        $("#submitmsg").click(function(){
            var clientmsg = $("#usermsg").val();
            $.post("post.php", {text: clientmsg()});
            $("#usermsg").attr("value", "");
            return false;
        });

        // Load the file containing the chat log
        setInterval(loadLog, 2500);
        function loadLog() {
            var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
            $.ajax({
                url: "log.html",
                cache: false,
                success: function(html) {
                    $("#chatbox").html(html); // Insert chatbox into #chatbox div

                    // Auto-scroll
                    var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                    if (newscrollHeight > oldscrollHeight) {
                        $("#chatbox").animate({scrollTop: newscrollHeight}, 'normal');
                    }
                },
            });
        }
    });
    </script>

    <?php
    }
    ?>
</body>

</html>