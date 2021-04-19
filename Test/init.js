const { exec } = require("child_process");
fpath = require('path').dirname(require.main.filename)
var path = require('path'), fs=require('fs');

function ChangePath(){
	exec("cd "+fpath, (error, stdout, stderr) => {
	console.log("Changing path");
	if (error) {
	console.log(`error: ${error.message}`);
	process.exit(1);

	}
	if (stderr) {
	console.log(`stderr: ${stderr}`);
	process.exit(1);

	}
	 });
		
}	

function Clean(){
	console.log("Cleaning network");
	exec("Truffle network --clean", (error, stdout, stderr) => {
	console.log("Network cleaned");
	if (error) {
	console.log(`error: ${error.message}`);
	process.exit(1);

	}
	if (stderr) {
	console.log(`stderr: ${stderr}`);
	process.exit(1);

	}
	 });	
}	

function Compile(){
	console.log("Compiling");
	exec("Truffle compile", (error, stdout, stderr) => {
	console.log("Compiled");
	if (error) {
	console.log(`error: ${error.message}`);
	process.exit(1);

	}
	if (stderr) {
	console.log(`stderr: ${stderr}`);
	process.exit(1);

	}
	});

}	

function Migrate(){
	console.log("Migrating");
	exec("Truffle migrate", (error, stdout, stderr) => {
	console.log("Migrated");
	if (error) {
	console.log(`error: ${error.message}`);
	process.exit(1);

	}
	if (stderr) {
	console.log(`stderr: ${stderr}`);
	process.exit(1);

	}
	});
		
}	
function Deploy(ContractName){
	console.log("Deploying Contract");
	exec('truffle deploy .\contracts\ '+ContractName, (error, stdout, stderr) => {
	console.log("Deployed Contract "+ContractName);
	if (error) {
	console.log(`error: ${error.message}`);
	process.exit(1);

	}
	if (stderr) {
	console.log(`stderr: ${stderr}`);
	process.exit(1);

	}
	});
		
}	

function ExportABI(){
	console.log("Exporting ABI");
	exec("truffle-export-abi", (error, stdout, stderr) => {
	console.log("Exported ABI");
	if (error) {
	console.log(`error: ${error.message}`);
	process.exit(1);

	}
	if (stderr) {
	console.log(`stderr: ${stderr}`);
	process.exit(1);

	}
	
	});
		
}	


ChangePath();
Clean();
Compile();
Migrate();
Deploy("MetaCoin.sol");
ExportABI();

		
			
