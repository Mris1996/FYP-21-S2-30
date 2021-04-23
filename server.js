var net = require('net');
var http = require('http');
var express = require('express');
var app = express();
var port = 3000
const fs = require('fs');
const solc = require('solc');
const Web3 = require('web3');
var crypto = require('crypto');
var router = express.Router();
var myContract = require('./build/contracts/MetaCoin.json');//JSON FILE OF CONTRACT
var Accounts = require('web3-eth-accounts');
const web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
web3.eth.net.isListening().then(() => console.log('CONNECTED TO GANACHE')).catch(e => console.log('NOT CONNECTED TO GANACHE'));
// Variables
const Escrow_Account = {
   privateKey: '9fadb3c63d66140740461f300f6f65ef0f5f0a3611e72303cecc44e88789e734',
   publicKey: '0x73fA385076B6e9BEA157Ba6e507E922c2951Dc69'//account has key
};

var decrypt = function (encryptedMessage, encryptionMethod, secret, iv) {
    var decryptor = crypto.createDecipheriv(encryptionMethod, secret, iv);
    return decryptor.update(encryptedMessage, 'base64', 'utf8') + decryptor.final('utf8');
};
var textToEncrypt = new Date().toISOString().substr(0,19) + '|My super secret information.';
var encryptionMethod = 'AES-256-CBC';
var secret = "My32charPasswordAndInitVectorStr"; //must be 32 char length
var iv = secret.substr(0,16);

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

	let server =  app.listen(process.env.PORT || 3000);
	setTimeout(function(){ server.close()}, 1000);	
	


	
}
const ConvertToSTICOIN_Response = async (TransactionName,Amount,WalletPubKey,WalletPrivateKey,EscrowAddress,STICPubKey)=> {
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
			if(balance < app.get('Amount')){
				res.send({"Transaction":"Insufficient fund"});
				return;
			}
			else{
				const initAmount = parseInt(app.get('Amount'));
				var STICAmount = parseInt(app.get('Amount'));
				//Gather contract details
				const id = await web3.eth.net.getId();
				const deployednetwork = myContract.networks[id];
				const contractAddress = deployednetwork.address;
				const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
				console.log(`Making a call to contract at address: ${contractAddress}`);
				var PrevBalance = await MetaCoin.methods.getBalance(app.get('STICPubKey')).call().then(function(result) {
					STICAmount = app.get('Amount') *10000;
					STICAmount+=parseInt(result);
			});
				const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(app.get('STICPubKey'),parseInt(STICAmount));
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
			value:  web3.utils.toWei(initAmount.toString(), 'ether'),
			},
			app.get('WalletPrivateKey')
			);
			const createReceipt = await web3.eth.sendSignedTransaction(
			TransferToEscrow.rawTransaction
			);
			console.log(
			`Transaction successful with hash: ${createReceipt.transactionHash}`
			);
			var sticoinsbal = await checkSTICOINBal(app.get('STICPubKey'));
			res.send({"sticoin":sticoinsbal,"Transaction":"Success"});

			}
		
			}
		sendFunc();
});

let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);

}
const ConvertToETH_Response = async (TransactionName,Amount,WalletPubKey,EscrowPrivate,STICPubKey)=> {
	app.set('Amount', Amount);
	app.set('WalletPubKey', WalletPubKey);
	app.set('EscrowPrivate', EscrowPrivate);
	app.set('STICPubKey', STICPubKey);	
	app.all(TransactionName, function (req, res) {
			
		const sendFunc = async ()=> {
			
				const initAmount = parseInt(app.get('Amount'))/10000;
				var STICAmount = parseInt(app.get('Amount'));
				
				//Gather contract details
				const id = await web3.eth.net.getId();
				const deployednetwork = myContract.networks[id];
				const contractAddress = deployednetwork.address;
				const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
				console.log(`Making a call to contract at address: ${contractAddress}`);
				var PrevBalance = await MetaCoin.methods.getBalance(app.get('STICPubKey')).call().then(function(result) {
					
				STICAmount=parseInt(result)-STICAmount;
				
			});
			const MetaCoin_init_Tx = await MetaCoin.methods.setBalance(app.get('STICPubKey'),parseInt(STICAmount));
			//Create tranasaction
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
			value:  web3.utils.toWei(initAmount.toString(), 'ether'),
			},
			app.get('EscrowPrivate')
			);
			const createReceipt = await web3.eth.sendSignedTransaction(
			TransferToEscrow.rawTransaction
			);
			console.log(
			`Transaction successful with hash: ${createReceipt.transactionHash}`
			);
			var sticoinsbal = await checkSTICOINBal(app.get('STICPubKey'));
			res.send({"sticoin":sticoinsbal,"Transaction":"Success"});
			}
		
			
		sendFunc();
});

let server =  app.listen(process.env.PORT || 3000);
setTimeout(function(){ server.close()}, 1000);

}
const GetBalance_Response = async (TransactionName,AccountPublicKey)=> {
app.set('AccountPublicKey', AccountPublicKey);
	app.get(TransactionName, function (req, res,jsondata) {
	
		const sendFunc = async ()=> {
		
		var sticoinsbal = await checkSTICOINBal(app.get('AccountPublicKey'));
		
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
	   if(JSONdata.REQUEST == "ConvertToSTICoin"){
			var decryptedMessage = decrypt(JSONdata.WALLETPRIVATEKEY, encryptionMethod, secret, iv);
			setTimeout(function(){ConvertToSTICOIN_Response('/ConvertToSTICoin',JSONdata.AMOUNT,JSONdata.WALLETPUBKEY,decryptedMessage,JSONdata.ESCROWPUBKEY,JSONdata.PUBKEY)},1000);			
	   }
	   if(JSONdata.REQUEST == "ConvertToETH"){
		  
			var decryptedMessage = decrypt(JSONdata.ESCROWPRIVATE, encryptionMethod, secret, iv);
			
			setTimeout(function(){ ConvertToETH_Response('/ConvertToETH',JSONdata.AMOUNT,JSONdata.WALLETPUBKEY,decryptedMessage,JSONdata.PUBKEY)},1000);	
	   }
	   if(JSONdata.REQUEST == "CheckAccount"){
			setTimeout(function(){ checkAccountInNetwork('/CheckAccount',JSONdata.PUBKEY)},0);			
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


//ConvertToSTICOIN_Response('/ConvertToSTICoin',"1","0x886EE39B4E7a981A84D5e58d413B8700851e3Fe7","ads","0x73fA385076B6e9BEA157Ba6e507E922c2951Dc69","0x33963Ce1286F603579713E7e25e155f7a70085A0")

//ConvertToSTICOIN("c5041f55af0b087834bd2abf0248b32be23fd812377de0c54065ffe1a31fe82b","0x33963Ce1286F603579713E7e25e155f7a70085A0","0x73fA385076B6e9BEA157Ba6e507E922c2951Dc69",1)

//removeRoute(app, '/foo/remove/me');  // all routes with a path /foo/remove/me are removed 

