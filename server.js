var http 		= require('http');
var https 		= require('https');
var fs 			= require('fs');
var server_port = process.argv[2];

var UserRegistry 	= require('./userRegistry.js');
var MessageRegistry = require('./messageRegistry.js')

var options = {
	key: fs.readFileSync('key/server.key'),
	cert: fs.readFileSync('key/server.crt')
};

var userRegistry 	= new UserRegistry();
var messageRegistry = new MessageRegistry();

/*
	node js server config server
 */
var app = https.createServer(options).listen(server_port, function(err) {
	console.log('Server is listening at port ' + server_port + '...');
});

var allRooms = [];
var roomsHistory = {};

// require('./Signaling-Server.js');
/*
	socket io settings
 */
var io = require('socket.io', 'socket.io-emitter').listen(app, {
	'pingInterval': 2000,
	'pingTimeout': 6000,
	'origins': '*:*'
});


io.sockets.on('connection', function(socket) {
	console.log("New socket connection");

	socket.connectionData = {};

	socket.on('create or join', function(message) {
		console.log("user created or joined with message: ", message);

		if (message.room == undefined) {
			message = JSON.parse(message);
		}

		var user;

		registerUser(socket, message, function() {
			user = userRegistry.getById(socket.id);
			socket.connectionData = user;
			socket.join(message.room);
			if (allRooms.indexOf(message.room) == -1) {
				console.log('creating room')
				console.log(message.room);;
				allRooms.push(message.room);
				roomsHistory[message.room] = {};
			}
			console.log(allRooms.indexOf(message.room));
			socket.broadcast.in(message.room).emit('new-user', JSON.stringify(user));
			var messageToClient = {};
			messageToClient.user = userRegistry.getUserUiFieldsById(socket.id);
			socket.emit('joined', JSON.stringify(messageToClient));
			socket.emit('history', JSON.stringify(roomsHistory[message.room]));
			if (message.reconnect == "1") {
				socket.emit('continue-reconnection', JSON.stringify(messageToClient));
			}
		});
	});

	socket.on('rejoin', function(message) {
		message = JSON.parse(message);
		socket.join(message.room);
		var user = userRegistry.getById(message.id);
		socket.connectionData = user;
		socket.broadcast.in(message.room).emit('user-reconnect', JSON.stringify(user));
		console.log("<<user-reconnect>> emit User : " + user.name + " id: " + user.id);
	});

	socket.on('getUsersList', function(message) {
		message = JSON.parse(message);
		var usersInRoom = userRegistry.getUsersByRoom(message.room);
		socket.emit('user-list', JSON.stringify(usersInRoom));
		console.log("<<get-usersList>>  User " + message.name +" room: " + message.room);
	});

	socket.on('objectAdded', function(message) {
		var msg = JSON.parse(message);
		console.log('objectAdded: ', msg.content.id);
		socket.broadcast.in(msg.room).emit('objectAdded', JSON.stringify(msg.content));
		console.log(msg.room);
		roomsHistory[msg.room][msg.content.customId] = msg.content;
	})

	socket.on('objectModified', function(message) {
		var msg = JSON.parse(message);
		console.log('objectModified: ', msg.content.id);

		socket.broadcast.in(msg.room).emit('objectModified', JSON.stringify(msg.content));
		roomsHistory[msg.room][msg.content.customId] = msg.content;	
	});

	socket.on('objectRemoved', function(message){
		var msg = JSON.parse(message);
		delete 	roomsHistory[msg.room][msg.content];
		socket.broadcast.in(msg.room).emit('objectRemoved', JSON.stringify(msg.content));
	})

	socket.on('command', function(message) {
		var msg = JSON.parse(message);
		console.log('received command', msg.content);
		socket.broadcast.in(msg.room).emit('command', JSON.stringify(msg.content));
	});

	socket.on('clearHistory', function(message) {
		var msg = JSON.parse(message);
		console.log('received clear', msg.room);
		roomsHistory[msg.room] = {};
	})

	socket.on('error', function(error) {
		console.log(Date() + ' !!! Error ' + error);
	});

	socket.on('disconnect', function() {
		var userToRemove = userRegistry.getById(socket.id);
		if (userToRemove) {
			var data = userRegistry.unregister(socket.connectionData.id);
			console.log("<<user-disconnect>> userId: " + userToRemove.id + " name: " + userToRemove.name);
			socket.broadcast.in(socket.connectionData.room).emit('user-out', JSON.stringify(data));
			socket.broadcast.in(socket.connectionData.room).emit('user-disconnect', JSON.stringify(data));
		}
	});
});


function registerUser(socket, userEnteredInfo, callback) {
	userRegistry.register(socket.id);
	userRegistry.setName(socket.id, userEnteredInfo.name);
	userRegistry.setEmail(socket.id, userEnteredInfo.email);
	userRegistry.setRoom(socket.id, userEnteredInfo.room);
	userRegistry.setImage(socket.id, 'user1');
	userRegistry.setCurrentStatus(socket.id, 'online');
	callback();
}