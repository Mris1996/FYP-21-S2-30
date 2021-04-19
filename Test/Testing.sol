pragma solidity ^0.5.1;

contract Testing {
    uint myInt=1000;
    
    function setTheInt(uint _myInt) public {
        myInt = _myInt;
    }
    
    function getTheInt() external view returns(uint) {
        return myInt;
    }
}