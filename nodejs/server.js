
var fs          = require('fs');
// var options = {
//   key: fs.readFileSync('/etc/apache2/ssl/example.com.key'),
//   cert: fs.readFileSync('/etc/apache2/ssl/2_fusionmate.com.crt'),
//   ca:fs.readFileSync('/etc/apache2/ssl/1_root_bundle.crt')
// };

var
    app         = require('http').createServer(handler),
    io 	        = require('socket.io')(app),
    redis       = require('redis'),
    
    redisClient = redis.createClient();


//app.createServer(options);
app.listen(3000);

console.log('Realtime Chat Server running at http://127.0.0.1:3000/');
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'fusionmate'
});

connection.connect();



connection.end();
function handler (req, res) {
    
	fs.readFile(__dirname + '/index.html', function(err, data) {
        if(err) {
            res.writeHead(500);
            return res.end('Error loading index.html');
        }
        res.writeHead(200);
        res.end(data);
    });
}

/***
    Redis Channels Subscribes
***/
redisClient.subscribe('chat.conversations');
redisClient.subscribe('chat.messages');
redisClient.subscribe('chat.status');
redisClient.subscribe('task.status');
redisClient.subscribe('invite.status');

/***
    Redis Events
***/
redisClient.on('message', function(channel, message) {
    var result = JSON.parse(message);

    io.to('admin').emit(channel, 'channel -> ' + channel + ' |  room -> ' + result.room);
    io.to(result.room).emit(channel, result);
});

/***
    Socket.io Connection Event
***/
io.on('connection', function(socket) {

socket.on('disconnect', function () {
        console.log(socket.id);
    });
    socket.emit('welcome',  { message: 'Welcome! Realtime Chat Server running at http://127.0.0.1:3000/'} );

    /***
        Socket.io Events
    ***/

    socket.on('join', function(data) {
         socket.join(data.room);
         socket.emit('joined', { message: 'Joined room: ' + data.room });
         
    });
    socket.on("typed", function(data) {
    io.sockets.emit("typing", { message: data.room});
});
       
});
