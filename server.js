var net = require('net');
var http = require('http');
var express = require('express');
var app = express();

var cluster = require('cluster');
const fs = require('fs');
const solc = require('solc');
const Web3 = require('web3');
var crypto = require('crypto');
var mysql = require('mysql');
var router = express.Router();
"use strict";
var http = require('http');
var url = require('url');
var WebsocketServer = require('websocket').server;
var myContract = require('./build/contracts/STIContract.json');//JSON FILE OF CONTRACT
var Accounts = require('web3-eth-accounts');
var WebsocketServer = require('websocket').server;
const web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
var textToEncrypt = new Date().toISOString().substr(0,19) + '|My super secret information.';
var encryptionMethod = 'AES-256-CBC';
var secret = "My32charPasswordAndInitVectorStr"; //must be 32 char length
var iv = secret.substr(0,16);

web3.eth.net.isListening().then(() => console.log('CONNECTED TO GANACHE')).catch(e => console.log('NOT CONNECTED TO GANACHE'));
// Variables


var decrypt = function (encryptedMessage, encryptionMethod, secret, iv) {
    var decryptor = crypto.createDecipheriv(encryptionMethod, secret, iv);
    return decryptor.update(encryptedMessage, 'base64', 'utf8') + decryptor.final('utf8');
};


const checkSTICOINBal = async (Acc_address)=>{
			
	//Gather contract details
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	var balance = 0;

	const Balance = await MetaCoin.methods.getBalance(Acc_address).call().then(function(result) {
	console.log("Address:"+Acc_address+"-"+result) // "Some User token"
	 balance = result;

	});

	return balance;
}
const checkWalletBal = async (Acc_address)=>{

  var balance = 0;
  await web3.eth.getBalance(Acc_address, function(err, result) {
  if (err) {
    console.log(err)
  } else {
     balance = parseFloat(web3.utils.fromWei(result, "ether"));
	
	 	
  }
})
	return balance;

}

const ConvertToCash = async (Escrow_Pkey,Acc_address,Escrow_Add,Amount) => {
	const initAmount = Amount;
	//Gather contract details
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	console.log(`Making a call to contract at address: ${contractAddress}`);
	
	var NewAmount = 0;
	
	var PrevBalance = await MetaCoin.methods.getBalance(Acc_address).call().then(function(result) {
		 NewAmount = parseFloat(result)-Amount;
	
		});
		const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(Acc_address,parseFloat(NewAmount));
		//Create tranasaction
		const InitTransaction = await web3.eth.accounts.signTransaction(
		{
		 to: contractAddress,
		 data: MetaCoin_init_Tx.encodeABI(),
		 gas: await MetaCoin_init_Tx.estimateGas(),
		},
		Escrow_Pkey
		);
		const InitReciept = await web3.eth.sendSignedTransaction(
		InitTransaction.rawTransaction);



		// Send Tx and Wait for Receipt

	
		
	//Deduct funds from their bank account
	const TransferToAccount = await web3.eth.accounts.signTransaction(
	{
		gas: 21000,
		to: Acc_address,
		value:  web3.utils.toWei(initAmount.toString(), 'ether'),
	},
		Escrow_Pkey
	);
	const createReceipt = await web3.eth.sendSignedTransaction(
		TransferToAccount.rawTransaction
	);
	console.log(
	`Transaction successful with hash: ${createReceipt.transactionHash}`
	);
	const Balance = MetaCoin.methods.getBalance(Acc_address).call().then(function(result) {
	console.log("Address:"+Acc_address+"-"+result) // "Some User token"
	});



}


const checkAccountInNetwork= async(TransactionName,AccountPubKey) =>{

	app.set('AccountPublicKey', AccountPubKey);
		
	app.all(TransactionName, function func(req, res) {
		var accountexist =  web3.utils.isAddress(app.get('AccountPublicKey'));
		console.log(accountexist);
		res.send({"RESPONSE":accountexist});
		app.use(function(req, res, next) {
		delete req.headers[TransactionName]; // should be lowercase
		next();
});

	
});

	let server =  app.listen(process.env.PORT || 3001);
	setTimeout(function(){ server.close()}, 1000);	
	


	
}
const ConvertToSTICOIN_Response = async (TransactionName,Amount,WalletPubKey,WalletPrivateKey,EscrowAddress,STICPubKey)=> {
	Amount = Math.round(new Number(Amount* 1000000000000000000));
	app.set('Amount', Amount);
	app.set('WalletPubKey', WalletPubKey);
	app.set('WalletPrivateKey', WalletPrivateKey);
	app.set('EscrowAddress', EscrowAddress);
	app.set('STICPubKey', STICPubKey);	
	app.all(TransactionName, function (req, res) {
			
		const sendFunc = async ()=> {
			
			var balance =  await checkWalletBal(app.get('WalletPubKey'));
			
			const accountverify = web3.eth.accounts.privateKeyToAccount(app.get('WalletPrivateKey'));
			if(accountverify.address!=app.get('WalletPubKey')){
				res.send({"Transaction":"Public key and private key do not match"});
				return;
			}
			console.log(Amount);
			if((Math.round(new Number(balance* 1000000000000000000))) < (Amount+0.0016)){
				res.send({"Transaction":"Insufficient fund"});
				return;
			}
			else{
				const initAmount = parseFloat(app.get('Amount'));
				var STICAmount = parseFloat(app.get('Amount'));
				//Gather contract details
				const id = await web3.eth.net.getId();
				const deployednetwork = myContract.networks[id];
				const contractAddress = deployednetwork.address;
				const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
				console.log(`Making a call to contract at address: ${contractAddress}`);
				var PrevBalance = await MetaCoin.methods.getBalance(app.get('STICPubKey')).call().then(function(result) {
					const converttowei = async(result)=>{
					STICAmount+=parseFloat(result);
					}
					converttowei(result);
					console.log(STICAmount);
			});
				const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(app.get('STICPubKey'),String(STICAmount));
			//Create tranasaction
			const InitTransaction = await web3.eth.accounts.signTransaction(
			{
			to: contractAddress,
			data: MetaCoin_init_Tx.encodeABI(),
			gas: await MetaCoin_init_Tx.estimateGas(),
			},
			app.get('WalletPrivateKey')
			);
			const InitReciept = await web3.eth.sendSignedTransaction(
			InitTransaction.rawTransaction);
			console.log(InitReciept);
			const TransferToEscrow = await web3.eth.accounts.signTransaction(
			{
			gas: 53000,
			to: app.get('EscrowAddress'),
			value:  initAmount.toString(),
			},
			app.get('WalletPrivateKey')
			);
			const createReceipt = await web3.eth.sendSignedTransaction(
			TransferToEscrow.rawTransaction
			);
			console.log(
			`Transaction successful with hash: ${createReceipt.transactionHash}`
			);
			res.send({"Transaction":"Success"});

			}
		
			}
		sendFunc();
});

let server =  app.listen(process.env.PORT || 3002);
setTimeout(function(){ server.close()}, 1000);

}
const ConvertToETH_Response = async (TransactionName,Amount,WalletPubKey,EscrowPrivate,STICPubKey)=> {
	app.set('Amount', Amount);
	app.set('WalletPubKey', WalletPubKey);
	app.set('EscrowPrivate', EscrowPrivate);
	app.set('STICPubKey', STICPubKey);	
	console.log(Amount);
	app.all(TransactionName, function (req, res) {
			
		const sendFunc = async ()=> {
		
				const initAmount = toFixed(Math.round(new Number(app.get('Amount')* 1000000000000000000)));
				var STICAmount = Math.round(new Number(app.get('Amount')* 1000000000000000000));
				
				//Gather contract details
				const id = await web3.eth.net.getId();
				const deployednetwork = myContract.networks[id];
				const contractAddress = deployednetwork.address;
				const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
				console.log(`Making a call to contract at address: ${contractAddress}`);
				var PrevBalance = await MetaCoin.methods.getBalance(app.get('STICPubKey')).call().then(function(result) {
				const converttowei = async(result)=>{
					STICAmount= Math.round(new Number(result))-STICAmount;
					console.log(STICAmount);
				}
				converttowei(result);
				
			
				
			});
			const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(app.get('STICPubKey'),String(STICAmount));
			
			const InitTransaction = await web3.eth.accounts.signTransaction(
			{
			to: contractAddress,
			data: MetaCoin_init_Tx.encodeABI(),
			gas: await MetaCoin_init_Tx.estimateGas(),
			},
			app.get('EscrowPrivate')
			);
			
			const InitReciept = await web3.eth.sendSignedTransaction(
			InitTransaction.rawTransaction);
			console.log(InitReciept);
			
			const TransferToEscrow = await web3.eth.accounts.signTransaction(
			{
			gas: 53000,
			to: app.get('WalletPubKey'),
			value:initAmount.toString(),
			},
			app.get('EscrowPrivate')
			);
			const createReceipt = await web3.eth.sendSignedTransaction(
			TransferToEscrow.rawTransaction
			);
			console.log(
			`Transaction successful with hash: ${createReceipt.transactionHash}`
			);
			res.send({"Transaction":"Success"});
			}
		
			
		sendFunc();
});

let server =  app.listen(process.env.PORT || 3003);
setTimeout(function(){ server.close()}, 1000);

}

function getAvailablePort(startingAt) {

    function getNextAvailablePort (currentPort, cb) {
        const server = net.createServer()
        server.listen(currentPort, _ => {
            server.once('close', _ => {
                cb(currentPort)
            })
            server.close()
        })
        server.on('error', _ => {
            getNextAvailablePort(++currentPort, cb)
        })
    }

    return new Promise(resolve => {
        getNextAvailablePort(startingAt, resolve)
    })
}

const GetBalance_Response = async (AccountPublicKey)=> {
	app.set('STICPubKey', AccountPublicKey);	
	const sendFunc = async ()=> {
	 var con = await mysql.createConnection({
		  host: "localhost",
		  user: "root",
		  password: "",
		  database: "sticdb"
		});

		con.connect(function(err) {
			const converttoeth = async()=>{
			var sticoinsbal = await checkSTICOINBal(app.get('STICPubKey'));
			sticoinsbal = await Web3.utils.fromWei(sticoinsbal, 'ether');
			console.log(sticoinsbal);
			if (err) throw err;
				con.query("UPDATE `users` SET `AccountBalance` = '"+parseFloat(sticoinsbal)+"' Where `PublicKey` = '"+AccountPublicKey+"'", function (err, result, fields) {
			if (err) throw err;
				console.log(result);
			});
			}
			converttoeth();
		
			
		});
		setTimeout(function(){ con.destroy()}, 2000);
		
	}
	sendFunc();
	
}


const createNewAccount = async(TransactionName) => {
	app.get(TransactionName, function (req, res,jsondata) {
	const sendFunc = async ()=> {
	var account = web3.eth.accounts.create();
	res.send({"pubkey":account.address,"privatekey":account.privateKey});
	}
	sendFunc();
	});
	let server =  app.listen(process.env.PORT || 3004);
	setTimeout(function(){ server.close()}, 1000);

	
}


const TransferSTICoins_Response = async (TransactionName,SellerPubKey,BuyerPubKey,EscrowPrivateKey,Amount)=> {
console.log(Amount);	
Amount = Math.round(new Number(Amount* 1000000000000000000));
app.set('Amount', Amount);
app.set('SellerPubKey', SellerPubKey);
app.set('BuyerPubKey', BuyerPubKey);	
app.set('EscrowPrivateKey', EscrowPrivateKey);
app.all(TransactionName, function (req, res) {	
const sendFunc = async ()=> {
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	console.log(`Making a call to contract at address: ${contractAddress}`);
	const MetaCoinTx = MetaCoin.methods.sendCoin(app.get('SellerPubKey'),app.get('BuyerPubKey'),String(app.get('Amount')));
	const InitTransaction = await web3.eth.accounts.signTransaction(
	{
		to: contractAddress,
		data: MetaCoinTx.encodeABI(),
		gas: await MetaCoinTx.estimateGas()+10000,
	},
	app.get('EscrowPrivateKey')
	);
	const InitReciept = await web3.eth.sendSignedTransaction(InitTransaction.rawTransaction);
	console.log(InitReciept.transactionHash);
	res.send({"TransactionHash":InitReciept.transactionHash});
	console.log("Successfully Transferred");
}					
sendFunc();
});

let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);
	
}
const ServerFunction = async () => {

var Server = await net.createServer(function(Sock) {
    console.log('Client Connected.');
    Sock.on('data',async  function(data) {
       console.log('Data received: ' + data);
		const JSONdata = JSON.parse(data);

       if(JSONdata.REQUEST == "GetBalance"){
		 
			setTimeout(function(){GetBalance_Response( JSONdata.ACCOUNTPUBLICKEY)},0);			
	   }
	   else if(JSONdata.REQUEST == "GetNewAccount"){
			setTimeout(function(){createNewAccount('/GetNewAccount')},0);			
	   }
	  else if(JSONdata.REQUEST == "ConvertToSTICoin"){
			var decryptedMessage = decrypt(JSONdata.WALLETPRIVATEKEY, encryptionMethod, secret, iv);
			setTimeout(function(){ConvertToSTICOIN_Response('/ConvertToSTICoin',JSONdata.AMOUNT,JSONdata.WALLETPUBKEY,decryptedMessage,JSONdata.ESCROWPUBKEY,JSONdata.PUBKEY)},1000);			
	   }
	   else if(JSONdata.REQUEST == "ConvertToETH"){
		  
			var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv);
			
			setTimeout(function(){ ConvertToETH_Response('/ConvertToETH',JSONdata.AMOUNT,JSONdata.WALLETPUBKEY,decryptedMessage,JSONdata.PUBKEY)},1000);	
	   }
	  else if(JSONdata.REQUEST == "CheckAccount"){
			setTimeout(function(){ checkAccountInNetwork('/CheckAccount',JSONdata.PUBKEY)},0);			
	   }
	  else if(JSONdata.REQUEST == "TransferSTICoins"){
		    var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv);
			console.log(decryptedMessage);
			setTimeout(function(){ TransferSTICoins_Response('/TransferAmount',JSONdata.SELLERPUBLICKEY,JSONdata.BUYERPUBLICKEY,decryptedMessage,JSONdata.AMOUNT)},0);			
	   }
	   else{
		   console.log("Problem");
	   }
 
    });

	Sock.on('end', function(){
	console.log('Client Disconnected.'); });
	Sock.pipe(Sock);
});

Server.listen(8080, function() {
   console.log('Listening on port ' + 8080); 

});
 
}


const Server_ContractFunction = async () => {


var server = http.createServer(function(request,response) {
	function getPostParams(request, callback) {
	    var qs = require('querystring');
	    if (request.method == 'POST') {
	        var body = '';

	        request.on('data', function (data) {
	            body += data;
	            if (body.length > 1e6)
	                request.connection.destroy();
	        });

	        request.on('end', function () {
	            var POST = qs.parse(body);
	            callback(POST);
	        });
	    }
	}
    // in-server request from PHP
    if (request.method === "POST") {
    	getPostParams(request, function(POST) {	
			messageClients(POST.data);
			response.writeHead(200);
			response.end();
		});
		return;
	}
});
server.listen(3030);
var websocketServer = new WebsocketServer({
	httpServer: server
});
websocketServer.on("request", websocketRequest);
// websockets storage
global.clients = {}; // store the connections
var connectionId = 0; // incremental unique ID for each connection (this does not decrement on close)
function websocketRequest(request) {
	// start the connection
	var connection = request.accept(null, request.origin); 
	connectionId++;
	// save the connection for future reference
	clients[connectionId] = connection;
	
}
// sends message to all the clients
function messageClients(message) {
	for (var i in clients) {
		clients[i].sendUTF(message);
	}
}
}
function toFixed(x) {
  if (Math.abs(x) < 1.0) {
    var e = parseInt(x.toString().split('e-')[1]);
    if (e) {
        x *= Math.pow(10,e-1);
        x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
    }
  } else {
    var e = parseInt(x.toString().split('+')[1]);
    if (e > 20) {
        e -= 20;
        x /= Math.pow(10,e);
        x += (new Array(e+1)).join('0');
    }
  }
  return x;
}
ServerFunction ();
Server_ContractFunction();

//Amount = toFixed(Amount+Amount);


