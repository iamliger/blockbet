const wallet = require('ethereumjs-wallet');
const secp256k1 = require('secp256k1');
let a = wallet.generate(true);

console.log(a.getPublicKeyString());

let compressed = secp256k1.publicKeyCreate(a.getPrivateKey(), true);
console.log(compressed.toString('hex'));