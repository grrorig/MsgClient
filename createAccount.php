<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>New Username</title>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script type="text/javascript">
    
    $(function() {

        $("#send-button").click(function() {
            var userid = $("#userid").val();
            var userpass = $("#userpass").val();
            var userpassrepeat = $("#userpass-repeat").val();

            if (userpass != userpassrepeat) {
                alert("Password does not match, please check again.");
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "processUser.php",
                    data: {
                        'userid': userid,
                        'userpass': userpass
                    },
                    dataType: "json",

                    success: function(data) {
                        alert("User id " + userid + " submitted successfully!");
                    },
                });
            }

        });

    });

    </script>

</head>

<body>

    <div id="page-wrap">

    <div id="header">
        <h1>Create New Username</h1>
    </div>

    <div id="section">
        <form id="new-user-form">
            <p>New username:</p>
            <input type="text" id="userid">
            <br><br>

            <p>New password:</p>
            <input type="password" id="userpass">
            <br><br>

            <p>Repeat password:</p>
            <input type="password" id="userpass-repeat">
            <br><br>

            <button id="send-button">Submit</button>

            <br><br>
            <a href="./index.html" target="_self">Back to login page</a>
        </form>

        
    </div>

    </div>

</body>

</html>