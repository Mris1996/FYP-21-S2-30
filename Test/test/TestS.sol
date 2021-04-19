pragma solidity >=0.4.22 <0.7.0;

import "truffle/Assert.sol";
import "truffle/DeployedAddresses.sol";
import "../contracts/Testing.sol";

contract TestTesting {

  function testSet() public {
    Testing meta = Testing(DeployedAddresses.Testing());

    uint expected = 1000;
	meta.setTheInt(expected);
	uint val = meta.getTheInt();
    Assert.equal(val, expected, "wrong");
  }

 

}

