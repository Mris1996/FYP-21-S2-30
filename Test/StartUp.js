

const fs = require('fs');
const solc = require('solc');
const Web3 = require('web3');
var myContract = require('C:/Users/Ris/Desktop/Test/build/contracts/MetaCoin.json');//JSON FILE OF CONTRACT

const web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
//create a server object:

// Variables
const Escrow_Account = {
   privateKey: '9fadb3c63d66140740461f300f6f65ef0f5f0a3611e72303cecc44e88789e734',
   publicKey: '0x73fA385076B6e9BEA157Ba6e507E922c2951Dc69'//account has key
};
const My_Account = {
   privateKey: '8fb862216fd2831ba5cd6c9a3468c63b1e2164c7160e3858a493396fadaa28e0',
   publicKey: '0x886EE39B4E7a981A84D5e58d413B8700851e3Fe7'//account has key
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
	const Balance = MetaCoin.methods.getBalance(Acc_address).call().then(function(result) {
	console.log("Address:"+Acc_address+"-"+result) // "Some User token"
	});



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



ConvertToSTICOIN(My_Account.privateKey,My_Account.publicKey,Escrow_Account.publicKey,10);
//ConvertToCash(Escrow_Account.privateKey,My_Account.publicKey,Escrow_Account.publicKey,10);