

const fs = require('fs');
const solc = require('solc');
const Web3 = require('web3');
var AccBalance;
var myContract = require('C:/Users/Ris/Desktop/Test/build/contracts/MetaCoin.json');//JSON FILE OF CONTRACT


const web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));

// Variables
const account_from = {
   privateKey: 'c5041f55af0b087834bd2abf0248b32be23fd812377de0c54065ffe1a31fe82b',
   addressof: '0x6BA6D8b8381EEA5eAbB7c19e8B2dcfCD00b07fA9'//account has key
};
const addressTo = '0x886EE39B4E7a981A84D5e58d413B8700851e3Fe7'; // Change addressTo
const Amount = 100;

const Transfer = async (Reciever,Sender,SenderPkey,Amount) => {
	
//Gather contract details
const id = await web3.eth.net.getId();
const deployednetwork = myContract.networks[id];
const contractAddress = deployednetwork.address;
const MetaCoin = new web3.eth.Contract(myContract.abi,deployednetwork.address);
console.log(`Making a call to contract at address: ${contractAddress}`);

const MetaCoinTx = MetaCoin.methods.sendCoin(Reciever,Amount);
//Create tranasaction
console.log(MetaCoinTx.estimateGas());
const createTransaction = await web3.eth.accounts.signTransaction(
{
to: contractAddress,
data:await MetaCoinTx.encodeABI(),
gas: 22808,
},
'9fadb3c63d66140740461f300f6f65ef0f5f0a3611e72303cecc44e88789e734'
);
const createReceipt = await web3.eth.sendSignedTransaction(
createTransaction.rawTransaction
);

const data2 = MetaCoin.methods.getBalance(Sender).call().then(function(result) {
console.log(result) // "Some User token"
});

const data3 = MetaCoin.methods.getBalance(Reciever).call().then(function(result) {
console.log(result) // "Some User token"
});
 



}
Transfer(addressTo,account_from.addressof,account_from.privateKey,Amount);