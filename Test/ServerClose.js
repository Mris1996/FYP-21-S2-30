var net = require('net');
var http = require('http');
var express = require('express');
var app = express();
var port = 3000

const ServerFunction = async () => {
var Server = await net.createServer(function(Sock) {
    console.log('Client Connected.');
    
    Sock.on('data',async  function(data) {
       console.log('Data received: ' + data);
		const JSONdata = JSON.parse(data);
        if(JSONdata.REQUEST == "CloseServer"){
		var server =  app.listen(process.env.PORT || 3000);
		server.close();
	   }
	   else{
		   console.log("problem");
	   }
 
    });
    
    Sock.on('end', function() {

    });
 
    Sock.pipe(Sock);
});

Server.listen(8080, function() {
   console.log('Listening on port ' + 8080); 
});
 
}

ServerFunction();
