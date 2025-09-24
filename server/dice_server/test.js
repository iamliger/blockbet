const crypto = require('crypto');
const ethUtils = require('ethereumjs-util');

crypto.randomBytes(32, function(err, buffer) {
    var token = buffer.toString('hex');
    console.log(token);
    let fromAddress = ethUtils.privateToAddress("0x"+token);    
    fromAddress = fromAddress.toString('hex');
    console.log(fromAddress);    
});
