const ConvertLib = artifacts.require("ConvertLib");
const Incrementer = artifacts.require("Incrementer");
const MetaCoin = artifacts.require("MetaCoin");
module.exports = function(deployer) {
  deployer.deploy(ConvertLib);
  deployer.link(ConvertLib, Incrementer);
  deployer.deploy(Incrementer,1);
    deployer.link(ConvertLib, MetaCoin);
  deployer.deploy(MetaCoin,0);
  
};
