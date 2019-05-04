// Chat engine

var instanse = false; // To avoid running multiple functions at once
var state;
var mes;
var file;

function Chat (roomid) {
	file = roomid + ".txt";
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

// Get state of chat (number of lines of messages)
function getStateOfChat() {
	if (!instanse) {
		instanse = true;
		$.ajax({
			type: "POST",
			url: "process.php",
			data: {
				'function': 'getState',
				'file': file
			},
			dataType: "json",

			success: function(data) {
				state = data.state;
				instanse = false;
			},
		});
	}
}

// Update the chat with new messages
function updateChat() {
	if (!instanse) {
		instanse = true;
		$.ajax({
			type: "POST",
			url: "process.php",
			data: {
				'function': 'update',
				'state': state,
				'file': file
			},
			dataType: "json",

			success: function(data) {
				if (data.text) {
					for (var i=0; i<data.text.length; i++) {
						$('#chat-area').append($("<p>" + data.text[i] + "</p>"));
					}
				}
				// Enable scrolling
				//document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				instanse = false;
				state = data.state;
			},
		});
	}
	else {
		setTimeout(updateChat, 1500); // To avoid multiple updates at the same time
	}
}

// Send the message
function sendChat(message, nickname) {
	console.log("Sending")
	updateChat(); // Update the chat first
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'function': 'send',
			'message': message,
			'nickname': nickname,
			'file': file
		},
		dataType: "json",

		success: function(data){
			updateChat(); // Update again after messaged is written to file by process.php
			document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
		},
	});
}