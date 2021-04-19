var net = require('net');
var http = require('http');
var express = require('express');
var app = express();
var port = 3000
const fs = require('fs');
const solc = require('solc');
const Web3 = require('web3');
var myContract = require('./build/contracts/MetaCoin.json');//JSON FILE OF CONTRACT
var Accounts = require('web3-eth-accounts');


const web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
web3.eth.net.isListening().then(() => console.log('CONNECTED TO GANACHE')).catch(e => console.log('NOT CONNECTED TO GANACHE'));
// Variables
const Escrow_Account = {
   privateKey: '9fadb3c63d66140740461f300f6f65ef0f5f0a3611e72303cecc44e88789e734',
   publicKey: '0x73fA385076B6e9BEA157Ba6e507E922c2951Dc69'//account has key
};
const My_Account = {
   privateKey: '079dcdd1a3ee113655d9c2fe947c4f52f3fa086f73d359e131a1825c439623ec',
   publicKey: '0x25a1f9214773CC9B063dAAe9317B577843D1FAF3'//account has key
};

const ConvertToSTICOIN = async (Acc_pkey,Acc_address,Escrow_Add,Amount) => {
	const initAmount = Amount;
	//Gather contract details
	const id = await web3.eth.net.getId();
	const deployednetwork = myContract.networks[id];
	const contractAddress = deployednetwork.address;
	const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
	console.log(`Making a call to contract at address: ${contractAddress}`);
	
	
	
	var PrevBalance = await MetaCoin.methods.getBalance(Acc_address).call().then(function(result) {
		 Amount+=parseInt(result);
	
		});
		const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(Acc_address,parseInt(Amount));
		//Create tranasaction
		const InitTransaction = await web3.eth.accounts.signTransaction(
		{
		 to: contractAddress,
		 data: MetaCoin_init_Tx.encodeABI(),
		 gas: await MetaCoin_init_Tx.estimateGas(),
		},
		Acc_pkey
		);
		const InitReciept = await web3.eth.sendSignedTransaction(
		InitTransaction.rawTransaction);



		// Send Tx and Wait for Receipt

	
		
	//Deduct funds from their bank account
	const TransferToEscrow = await web3.eth.accounts.signTransaction(
	{
		gas: 21000,
		to: Escrow_Add,
		value:  web3.utils.toWei(initAmount.toString(), 'ether'),
	},
		Acc_pkey
	);
	const createReceipt = await web3.eth.sendSignedTransaction(
		TransferToEscrow.rawTransaction
	);
	console.log(
	`Transaction successful with hash: ${createReceipt.transactionHash}`
	);
	

}
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
     balance = parseInt(web3.utils.fromWei(result, "ether"));
	
	 	
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
		 NewAmount = parseInt(result)-Amount;
	
		});
		const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(Acc_address,parseInt(NewAmount));
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
	
try{
web3.eth.getBalance(AccountPubKey)
.then(
function(){
app.get(TransactionName, function (req, res,jsondata) {
		const sendFunc = async ()=> {
			res.send({"RESPONSE":"VALID ACCOUNT"});
		console.log("PASSED");
		}
		sendFunc();
});
let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);

}
);

// require express, a minimalistic web framework for nodejs
}
catch(e){
	
	app.get(TransactionName, function (req, res,jsondata) {
		const sendFunc = async ()=> {
		res.send({"RESPONSE":"INVALID ACCOUNT"});
		console.log("failed");
		}
		sendFunc();
});
let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);
	
}
	
}
const ConvertToSTICOIN_Response = async (TransactionName,Amount)=> {

	app.get(TransactionName, function (req, res,jsondata) {
		const sendFunc = async ()=> {
		var balance =  await checkWalletBal(My_Account.publicKey);
		var sticoinsbal = await checkSTICOINBal(My_Account.publicKey);
		if(balance>Amount){
		    ConvertToSTICOIN(My_Account.privateKey,My_Account.publicKey,Escrow_Account.publicKey,Amount);
			res.send({"sticoin":sticoinsbal,"wallet":balance});
		}
		else{
			res.send({"sticoin":sticoinsbal,"wallet":"Insufficient fund"});
		}
		}
		sendFunc();
});
//let server =  app.listen(process.env.PORT || 3000);
//setTimeout(function(){ server.close()}, 1000);

}
const GetBalance_Response = async (TransactionName,AccountPublicKey)=> {

	app.get(TransactionName, function (req, res,jsondata) {
		const sendFunc = async ()=> {
		var sticoinsbal = await checkSTICOINBal(AccountPublicKey);
			res.send({"sticoin_balance":sticoinsbal});
			
		}
		sendFunc();
});
let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);

}


const createNewAccount = async(TransactionName) => {
	app.get(TransactionName, function (req, res,jsondata) {
	const sendFunc = async ()=> {
	var account = web3.eth.accounts.create();
	res.send({"pubkey":account.address,"privatekey":account.privateKey});

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
			setTimeout(function(){GetBalance_Response('/getBalance', JSONdata.ACCOUNTPUBLICKEY)},0);			
	   }
	    if(JSONdata.REQUEST == "GetNewAccount"){
			setTimeout(function(){createNewAccount('/GetNewAccount')},0);			
	   }
	   else{
		   console.log("problem");
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

ServerFunction ();
// create a web path /getdata which will return your BT data as JSON

// makes your node app listen to web requests on port 3000


