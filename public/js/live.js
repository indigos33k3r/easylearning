var currentUser = null;
var config = {
		"port" : "7555",
		"ip" : "163.172.112.50"
};
var SocketFactory = function() {
	var disconnect = false;

	var socket;

	function login() {
		if (PROJECT_TYPE == "template") {
			return;
		}
	    socket = io.connect('https://' + config.ip + ':' + config.port, {
	        'reconnection': true,
	        'reconnectionDelay': 1000,
	        'reconnectionDelayMax': 5000,
	        'reconnectionAttempts': Infinity,
	        'forceNew': true
	    });
	}

	function on(eventName, callback) {
		if (PROJECT_TYPE == "template") {
			return;
		}
	    if (socket && socket._callbacks["$" + eventName] == undefined) {
	        socket.on(eventName, function() {
	            // console.log('In socket ON --------------->', eventName)
	            var args = arguments;
	            if (!disconnect) {
                    callback.apply(socket, args);
	            }
	        });
	    }
	}

	function off(eventName, callback) {
		if (PROJECT_TYPE == "template") {
			return;
		}
	    if (socket && socket._callbacks["$" + eventName] !== undefined) {
	        console.log('removing listeners', eventName, callback);
	        socket.removeListener(eventName, callback);
	    }
	}

	function emit(eventName, data, callback) {
		if (PROJECT_TYPE == "template") {
			return;
		}
	    socket.emit(eventName, data, function() {
	        var args = arguments;
	        $rootScope.$apply(function() {
	            if (callback) {
	                callback.apply(socket, args);
	            }
	        });
	    });
	}
	return {
		login: login,
		emit: emit,
		on: on,
		off: off
	}
}
var socketFactory = new SocketFactory();

if (PROJECT_TYPE == "project") {
	var connection = new RTCMultiConnection();
	// connection.socketURL = 'https://' + config.ip + ':' + config.port + "/";
	connection.socketURL = "https://rtcmulticonnection.herokuapp.com:443/";
	connection.socketMessageEvent = 'RTCMultiConnection-Message';
	connection.session = {
	    audio: true,
	    video: true
	};
	connection.sdpConstraints.mandatory = {
	    OfferToReceiveAudio: true,
	    OfferToReceiveVideo: true
	};
	connection.videosContainer = document.getElementById('videos-container');



	connection.onstream = function(event) {
		console.log('received stream');
	    var width = parseInt(connection.videosContainer.clientWidth / 2) - 20;
	    var mediaElement = getMediaElement(event.mediaElement, {
	        title: event.userid,
	        // buttons: ['full-screen'],
	        width: width,
	        showOnMouseEnter: false
	    });
	    connection.videosContainer.appendChild(mediaElement);
	    setTimeout(function() {
	        mediaElement.media.play();
	    }, 5000);
	    mediaElement.id = event.streamid;
	};


	connection.onstreamended = function(event) {
	    var mediaElement = document.getElementById(event.streamid);
	    if (mediaElement) {
	        mediaElement.parentNode.removeChild(mediaElement);
	    }
	};

	connection.openOrJoin(eventId, function(isRoomExists, roomid) {
	    if (!isRoomExists) {
	        alert("room exists");
	    }
	});

	var socketFactory = new SocketFactory();
	socketFactory.login();
	var messageToConnect = {};
	console.log(eventId);
	messageToConnect.room = eventId;
	messageToConnect.name = user.name;
	socketFactory.emit('create or join', JSON.stringify(messageToConnect));

	socketFactory.on('created', function(message) {
	    var msg = JSON.parse(message);
	    currentUser = msg.user;
	    console.log("On Created USER-->:", currentUser);
	    socketFactory.emit('getUsersList', JSON.stringify(messageToConnect));
	});

	socketFactory.on('joined', function(message) {
	    var msg = JSON.parse(message);
	    currentUser = msg.user;
	    console.log("USER-->:", currentUser);
	    socketFactory.emit('getUsersList', JSON.stringify(messageToConnect));
	});

	socketFactory.on('user-list', function(message) {
	    var users = JSON.parse(message);
	    console.log("USERS LIST-->:", users);
	});
}


