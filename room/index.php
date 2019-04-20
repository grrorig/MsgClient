<?php
	$nickname = $_POST['userid'];
	$roomid = $_POST['roomid'];
?>

<!DOCTYPE html>
<html>

<head>

	<meta charset="UTF-8">
	<title>Chat Room</title>
	
	<link rel="stylesheet" href="../style.css" type="text/css">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="chat.js"></script>
	<script type="text/javascript">
		
		// Get roomid
		var roomid = "<?php echo $roomid ?>";

		// Get userid name and strip tags, default is "Guest", and display name
		//var name = prompt("Enter your display name: ", "Guest"); // Outdated code, for keepsake only
		var name = "<?php echo $nickname ?>";

		if (!name || name === '') {
			name = "Guest";
		}
		
		name = name.replace(/(<([^>]+)>)/ig,"");

		$("#name-area").html("You are <span>" + name + "</span>");

		// Init chat
		var chat = new Chat(roomid); // Assign room chat log
		
		$(function() {

			chat.getState();

			// Listen for key press in text area
			$("#sendie").keydown(function(event) {
				var key = event.which;

				if (key >= 33) {
					var maxLength = $(this).attr("maxlength");
					var length = this.value.length;

					// Limit the length of message
					if (length >= maxLength) {
						event.preventDefault();
					}
				}
			});

			// Listen for key release in text area
			$("#sendie").keyup(function(e) {			 
				if (e.keyCode == 13) {
					var text = $(this).val();
					var maxLength = $(this).attr("maxlength");  
					var length = text.length; 

					// Send
					if (length <= maxLength + 1) { 				 
						chat.send(text, name);
						$(this).val("");
					} else {
						$(this).val(text.substring(0, maxLength));			
					}		
				}
			 });

		});

	</script>

</head>

<body onload="setInterval('chat.update()', 1000)">
	
	<div id="page-wrap">
		
		<?php echo "<h2>Welcome to $roomid Room!</h2>" ?>

		<p id="name-area"></p>

		<div id="chat-wrap">
			<div id="chat-area">
				
			</div>
		</div>

		<form id="send-message-area">
			<p>Your message: </p>
			<textarea id="sendie" maxlength='100'></textarea>
		</form>

	</div>

</body>

</html>