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
var dateTime = require('node-datetime');
var dt = dateTime.create();
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
	const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	var balance = 0;

	const Balance = await STIContract.methods.getBalance(Acc_address).call().then(function(result) {
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
     balance = result;
	
	 	
  }
})
	return balance;

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
const ConvertToSTICOIN_Response = async (TransactionName,Amount,AmountETH,WalletPubKey,WalletPrivateKey,EscrowAddress,EscrowPrivateKey,STICPubKey)=> {
	Amount = Math.round(Amount* 100);
	AmountETH = Math.round(new Number((AmountETH)* 1000000000000000000));
		
	app.set('Amount', Amount);
	app.set('AmountETH', AmountETH);
	app.set('WalletPubKey', WalletPubKey);
	app.set('WalletPrivateKey', WalletPrivateKey);
	app.set('EscrowAddress', EscrowAddress);
	app.set('STICPubKey', STICPubKey);	
	await app.all(TransactionName, function (req, res) {
			
		const sendFunc = async ()=> {
			
			var balance =  await checkWalletBal(app.get('WalletPubKey'));
			
			const accountverify = web3.eth.accounts.privateKeyToAccount(app.get('WalletPrivateKey'));
			if(accountverify.address!=app.get('WalletPubKey')){
				res.send({"Transaction":"Public key and private key do not match"});
				return;
			}
		
			if((new Number(balance)) < (app.get('AmountETH'))){
				res.send({"Transaction":"Insufficient fund"});
				return;
			}
			else{
				
				var STICAmount = parseFloat(app.get('Amount'));
				//Gather contract details
				const id = await web3.eth.net.getId();
				const deployednetwork = myContract.networks[id];
				const contractAddress = deployednetwork.address;
				const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
				console.log(`Making a call to contract at address: ${contractAddress}`);
				var PrevBalance = await STIContract.methods.getBalance(app.get('STICPubKey')).call().then(function(result) {
					const converttowei = async(result)=>{
					STICAmount+=parseFloat(result);
					}
					converttowei(result);
					
					
			});
				const STIContract_init_Tx = await STIContract.methods.setBalance(app.get('STICPubKey'),String(toFixed(STICAmount)));
			//Create tranasaction
			const InitTransaction = await web3.eth.accounts.signTransaction(
			{
			to: contractAddress,
			data: STIContract_init_Tx.encodeABI(),
			gas: await STIContract_init_Tx.estimateGas(),
			},
			app.get('WalletPrivateKey')
			);
			const InitReciept = await web3.eth.sendSignedTransaction(
			InitTransaction.rawTransaction);
			console.log(InitReciept);
			setTimeout(function(){ UpdateTransaction(InitReciept.transactionHash,app.get('Amount'),app.get('WalletPubKey'),app.get('STICPubKey'),app.get('WalletPrivateKey'),'Top-Up')}, 1000);
			const TransferToEscrow = await web3.eth.accounts.signTransaction(
			{
			gas: 53000,
			to: app.get('EscrowAddress'),
			value:  app.get('AmountETH'),
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
setTimeout(function(){ UpdateBalance(STICPubKey)}, 2000);
}
const ConvertToETH_Response = async (TransactionName,Amount,AmountETH,WalletPubKey,EscrowPrivate,STICPubKey)=> {
	Amount = Math.round(Amount* 100);
	app.set('Amount', Amount);
	AmountETH = Math.round(new Number((AmountETH)* 1000000000000000000));
	app.set('AmountETH', AmountETH);
	app.set('WalletPubKey', WalletPubKey);
	app.set('EscrowPrivate', EscrowPrivate);
	app.set('STICPubKey', STICPubKey);	

	app.all(TransactionName, function (req, res) {
			
		const sendFunc = async ()=> {
		

				var STICAmount = Math.round(new Number(app.get('Amount')));
				
				//Gather contract details
				const id = await web3.eth.net.getId();
				const deployednetwork = myContract.networks[id];
				const contractAddress = deployednetwork.address;
				const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
				console.log(`Making a call to contract at address: ${contractAddress}`);
				var PrevBalance = await STIContract.methods.getBalance(app.get('STICPubKey')).call().then(function(result) {
				const converttowei = async(result)=>{
					
					STICAmount= Math.round(new Number(result))-STICAmount;

				}
				converttowei(result);
				
			
				
			});
			const STIContract_init_Tx = await STIContract.methods.setBalance(app.get('STICPubKey'),String(toFixed(STICAmount)));
		
			const InitTransaction = await web3.eth.accounts.signTransaction(
			{
			to: contractAddress,
			data: STIContract_init_Tx.encodeABI(),
			gas: await STIContract_init_Tx.estimateGas(),
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
			value:app.get('AmountETH').toString(),
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
			setTimeout(function(){UpdateTransaction(InitReciept.transactionHash,app.get('Amount'),app.get('STICPubKey'),app.get('WalletPubKey'),app.get('EscrowPrivate'),'Redeem')}, 1000);
			}
		
			
		sendFunc();
});

let server =  app.listen(process.env.PORT || 3003);
setTimeout(function(){ server.close()}, 1000);
setTimeout(function(){ UpdateBalance(STICPubKey)}, 2000);
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

const UpdateBalance = async (AccountPublicKey)=> {
	app.set('STICPubKey', AccountPublicKey);	
	const sendFunc = async ()=> {
	 var con = await mysql.createConnection({
		  host: "localhost",
		  user: "root",
		  password: "",
		  database: "sticdb"
		});

		const connectfunction = async()=>{
			var sticoinsbal = await checkSTICOINBal(app.get('STICPubKey'));
			var sticoinsbal = sticoinsbal/100;
			
				con.query("UPDATE `users` SET `AccountBalance` = '"+parseFloat(sticoinsbal)+"' Where `PublicKey` = '"+AccountPublicKey+"'", function (err, result, fields) {
			if (err) throw err;
			;
			});
			}
			connectfunction();
		setTimeout(function(){ con.destroy()}, 3000);
		
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

const PayForProduct_Response = async (TransactionName,Amount,EscrowPrivate,EscrowPublic,UserPublic)=> {
	
Amount = toFixed(Math.round(Amount* 100));
app.set('Amount', Amount);
app.set('UserPubKey', UserPublic);
app.set('EscrowPubkKey', EscrowPublic);	
app.set('EscrowPrivateKey', EscrowPrivate);
app.all(TransactionName, function (req, res) {	
const sendFunc = async ()=> {
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	console.log(`Making a call to contract at address: ${contractAddress}`);
	const STICTransaction = STIContract.methods.sendCoin(app.get('EscrowPubkKey'),app.get('UserPubKey'),String(app.get('Amount')));
	const InitTransaction = await web3.eth.accounts.signTransaction(
	{
		to: contractAddress,
		data: STICTransaction.encodeABI(),
		gas: await STICTransaction.estimateGas()+10000,
	},
	app.get('EscrowPrivateKey')
	);
	const InitReciept = await web3.eth.sendSignedTransaction(InitTransaction.rawTransaction);
	console.log(InitReciept.transactionHash);
	console.log("Successfully Transferred");
	res.send({"Transaction":"Success"});
	setTimeout(function(){ UpdateTransaction(InitReciept.transactionHash,app.get('Amount'),app.get('UserPubKey'),app.get('EscrowPubkKey'),app.get('EscrowPrivateKey'),'Payment for product listing')}, 1000);
	const STIContract_init_Tx = await STIContract.methods.setBalance(app.get('EscrowPubkKey'),'0');
	const InitTransaction2 = await web3.eth.accounts.signTransaction(
	{
	to: contractAddress,
	data: STIContract_init_Tx.encodeABI(),
	gas: await STIContract_init_Tx.estimateGas()+10000,
	},
	app.get('EscrowPrivateKey')
	);
	const InitReciept2 = await web3.eth.sendSignedTransaction(InitTransaction2.rawTransaction);
	console.log(InitReciept2.transactionHash);
	console.log("Payment Successful");

}					
sendFunc();

});

let server =  app.listen(process.env.PORT || 3004);
setTimeout(function(){ server.close()}, 1000);
setTimeout(function(){ UpdateBalance(UserPublic)}, 4000);

}

const Buyer_Refund_Response = async (TransactionName,SellerPubKey,BuyerPubKey,EscrowPrivateKey,Amount)=> {
Amount = toFixed(Math.round(Amount* 100));
app.set('Amount', Amount);
app.set('SellerPubKey', SellerPubKey);
app.set('BuyerPubKey', BuyerPubKey);	
app.set('EscrowPrivateKey', EscrowPrivateKey);
app.all(TransactionName, function (req, res) {	
const sendFunc = async ()=> {
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	console.log(`Making a call to contract at address: ${contractAddress}`);
	const STICTransaction = STIContract.methods.sendCoin(app.get('BuyerPubKey'),app.get('SellerPubKey'),String(app.get('Amount')));
	const InitTransaction = await web3.eth.accounts.signTransaction(
	{
		to: contractAddress,
		data: STICTransaction.encodeABI(),
		gas: await STICTransaction.estimateGas()+10000,
	},
	app.get('EscrowPrivateKey')
	);
	const InitReciept = await web3.eth.sendSignedTransaction(InitTransaction.rawTransaction);
	console.log(InitReciept);
	res.send({"TransactionHash":InitReciept.transactionHash});
	console.log("Successfully Transferred");
	setTimeout(function(){ UpdateTransaction(InitReciept.transactionHash,app.get('Amount'),app.get('SellerPubKey'),app.get('BuyerPubKey'),app.get('EscrowPrivate'),'Contract Transaction')}, 1000);
}					
sendFunc();
});

let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);

}
const Contract_Payment_Response = async (TransactionName,SellerPubKey,BuyerPubKey,EscrowPrivateKey,Amount)=> {
Amount = toFixed(Math.round(Amount* 100));
app.set('Amount', Amount);
app.set('SellerPubKey', SellerPubKey);
app.set('BuyerPubKey', BuyerPubKey);	
app.set('EscrowPrivateKey', EscrowPrivateKey);
app.all(TransactionName, function (req, res) {	
const sendFunc = async ()=> {
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	console.log(`Making a call to contract at address: ${contractAddress}`);
	const STICTransaction = STIContract.methods.sendCoin(app.get('SellerPubKey'),app.get('BuyerPubKey'),String(app.get('Amount')));
	const InitTransaction = await web3.eth.accounts.signTransaction(
	{
		to: contractAddress,
		data: STICTransaction.encodeABI(),
		gas: await STICTransaction.estimateGas()+10000,
	},
	app.get('EscrowPrivateKey')
	);
	const InitReciept = await web3.eth.sendSignedTransaction(InitTransaction.rawTransaction);
	console.log(InitReciept);
	res.send({"TransactionHash":InitReciept.transactionHash});
	console.log("Successfully Transferred");
	setTimeout(function(){ UpdateTransaction(InitReciept.transactionHash,app.get('Amount'),app.get('BuyerPubKey'),app.get('SellerPubKey'),app.get('EscrowPrivate'),'Contract Transaction')}, 1000);
}					
sendFunc();
});

let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);

}
/////////////////////////////////////////////////////////////////
const UpdateTransaction = async (Hash,Amount,Sender,Reciever,PrivKey,Title)=> {
const date = dt.format('Y-m-d H:M:S');
var con = await mysql.createConnection({
host: "localhost",
user: "root",
password: "",
database: "sticdb"
});
console.log(date);
const connectfunction = async()=>{
con.query("INSERT INTO `transactions`(`TransactionID`, `Receiver`, `Sender`, `Title` ,`Amount` ,`Date` ) VALUES ('"+Hash+"','"+ Reciever+"','"+Sender+"','"+Title+"','"+Amount+"','"+date+"')", function (err, result, fields) {
if (err) throw err;
;
});
}
connectfunction();
setTimeout(function(){ con.destroy()}, 3000);
}

/////////////////////////////////////////////////////////////////
const InitContract_Response = async (ContractID,Amount,EscrowPrivate,Buyer,Seller)=> {
const id = await web3.eth.net.getId();
const deployednetwork = myContract.networks[id];
const contractAddress = deployednetwork.address;
const STIContract = new web3.eth.Contract(myContract.abi,deployednetwork.address);
console.log(`Making a call to contract at address: ${contractAddress}`);
const STICTransaction = STIContract.methods.InitContract(ContractID,Amount,Buyer,Seller);
console.log("Contract Initialised");	
const InitTransaction = await web3.eth.accounts.signTransaction(
{
to: contractAddress,
data: STICTransaction.encodeABI(),
gas: await STICTransaction.estimateGas()+10000,
},
EscrowPrivate
);
const InitReciept = await web3.eth.sendSignedTransaction(InitTransaction.rawTransaction);
console.log(InitReciept);
console.log("Contract Initialised");	
	
}

////////////////////////////////////////////////////////////////
const ServerFunction = async () => {

var Server = await net.createServer(function(Sock) {
    console.log('Client Connected.');
    Sock.on('data',async  function(data) {
       console.log('Data received: ' + data);
		const JSONdata = JSON.parse(data);

      if(JSONdata.REQUEST == "GetNewAccount"){
			setTimeout(function(){createNewAccount('/GetNewAccount')},0);			
	   }
	  else if(JSONdata.REQUEST == "ConvertToSTICoin"){
			var decryptedMessage = decrypt(JSONdata.WALLETPRIVATEKEY, encryptionMethod, secret, iv);
			await setTimeout(function(){ConvertToSTICOIN_Response('/ConvertToSTICoin',JSONdata.AMOUNT,JSONdata.AMOUNTETH,JSONdata.WALLETPUBKEY,decryptedMessage,JSONdata.ESCROWPUBKEY,JSONdata.ESCROWPRIVATE,JSONdata.PUBKEY)},1000);			
			
			
	   }
	   else if(JSONdata.REQUEST == "ConvertToETH"){
		  
			var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv);
			await setTimeout(function(){ ConvertToETH_Response('/ConvertToETH',JSONdata.AMOUNT,JSONdata.AMOUNTETH,JSONdata.WALLETPUBKEY,decryptedMessage,JSONdata.PUBKEY)},1000);	
	   }
	  else if(JSONdata.REQUEST == "CheckAccount"){
			await setTimeout(function(){ checkAccountInNetwork('/CheckAccount',JSONdata.PUBKEY)},0);			
	  }
	  else if(JSONdata.REQUEST == "ContractPayment"){
	
		    var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv)
			await setTimeout(function(){ Contract_Payment_Response('/TransferAmount',JSONdata.SELLERPUBLICKEY,JSONdata.BUYERPUBLICKEY,decryptedMessage,JSONdata.AMOUNT)},5000);
		
	  }
	   else if(JSONdata.REQUEST == "PayForProduct"){
		  
			var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv);
			await setTimeout(function(){ PayForProduct_Response('/PayForProduct',JSONdata.AMOUNT,decryptedMessage,JSONdata.ESCROWPUBLIC,JSONdata.PUBKEY)},1000);	
	   }
	   else if(JSONdata.REQUEST == "InitContract"){
			var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv);
			//await setTimeout(function(){ InitContract_Response(JSONdata.CONTRACTID,JSONdata.AMOUNT,decryptedMessage,JSONdata.BUYERPUBLICKEY,JSONdata.SELLERPUBLICKEY)},0);	
	   }
	  else if(JSONdata.REQUEST == "RefundBuyer"){
			var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv)
			await setTimeout(function(){ Buyer_Refund_Response('/TransferAmount',JSONdata.SELLERPUBLICKEY,JSONdata.BUYERPUBLICKEY,decryptedMessage,JSONdata.AMOUNT)},1000);
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

				var array = JSON.parse(POST.data);
				
				
	            callback(POST);
	        });
	    }
	}
    // in-server request from PHP
    if (request.method === "POST") {
    	getPostParams(request, function(POST) {
			var array = JSON.parse(POST.data);
			if (typeof array.REQUEST != 'undefined') {
				
			}
			if (typeof array.Balance != 'undefined') {	
				UpdateBalance(array.PubKey)		
				messageClients(POST.data);
				response.writeHead(200);
				response.end();
			}
			else{
				messageClients(POST.data);
				response.writeHead(200);
				response.end();
			}
			
			
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
        x += (new Array(e+1)).join ('0');
    }
  }
  return x;
}

ServerFunction ();
Server_ContractFunction();
setInterval(
function(){
var con = mysql.createConnection({
host: "localhost",
user: "root",
password: "",
database: "sticdb"
});
const date = Date.parse(dt.format('Y-m-d'));

const connectfunction = async()=>{
 con.query("SELECT * FROM product", function (err, result, fields) {
    if (err) throw err;
	for(var x = 0;x<result.length;x++){
			if(date > Date.parse(result[x].DateOfExpiry)){
				con.query("UPDATE `product` SET `Status` = 'Unlisted' Where `ProductID` = '"+result[x].ProductID+"'", function (err, result, fields) {
				if (err) throw err;
	
				;
				})
			}
	}

  });
}
connectfunction();
console.log("Updating Product List");
setTimeout(function(){ con.destroy()}, 3000);
}, 3600000);






