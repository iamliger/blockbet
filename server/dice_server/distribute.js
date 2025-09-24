require('dotenv').config();

/*
Under       637c1c2d22c3926be916e80a96650f4149df7e1590c5be17945a6361c32d740c    d42cc10b24e11b4eb58db29e9f6052d3b4576464
OddEven     23511a72c5b6f9edbdf32b40bc03c48a48d10b16b80112785f536efe60fe2de1    f5c09e2e3d8cfa48084d5de9ed9bc43ec76b9849
UnderOver   ff227958936874a08ea63c1f4fe1e768264b7b8ac5164232af1c9f470a63be47    5ce7f4f65cbfc52d99ec35b12982e4ec7f16acf6

OddEven40     a3f501a9416ca44d217c79d0fc1c936107b27fb23e1c6b320da6957437be8ce4    6EB2f370Bd783569220bA050643cD725C0BE0EA4
UnderOver40   df135ad032f84dd97d9110101e4a1b99517b8cddfc3f062f88fd1110cd1fd0d3    3Cd51513d9697c19ee91b29a8c57442E7e80a2be
Under40       ff02295a9addf134394e39691cb8022a1fc074135955f5cda0b95644edda0153    132fFa0BfF83B9FE7BE4abd2e3b406DB7f83DFB4
*/
const Web3 = require('web3');
var Tx = require('ethereumjs-tx');

var ethUtils = require('ethereumjs-util');
var fs = require('fs');
var BN = require('bignumber.js');
const EventEmitter = require('events');
const path = require('path'); // path 모듈 추가

const event = new EventEmitter();


const web3TxUrl = process.env.WEB3_GAME_TX_NODE_URL;
console.log(`DEBUG: distribute.js is connecting to WEB3_GAME_TX_NODE_URL: ${web3TxUrl}`);

//const web3 = new Web3(new Web3.providers.HttpProvider(process.env.WEB3_GAME_TX_NODE_URL, { timeout: 10000, handleRevert: true }));
const web3 = new Web3(new Web3.providers.HttpProvider(web3TxUrl, { timeout: 10000, handleRevert: true }));

//var abi = fs.readFileSync("../dice/build/contracts/DiceUnder.json", "utf8"); //mainnet
//abi = JSON.parse(abi);

const abiPath = path.resolve(__dirname, '../dice/build/contracts/DiceUnder.json');
console.log(abiPath);

var abi = fs.readFileSync(abiPath, "utf8");
abi = JSON.parse(abi);

var DiceUnderContract = abi.networks['100'].address;
var DiceUnderCa = new web3.eth.Contract(abi.abi, DiceUnderContract);

abi = fs.readFileSync("../dice/build/contracts/DiceOddEven.json", "utf8"); //mainnet
abi = JSON.parse(abi);

var DiceOddEvenContract = abi.networks['100'].address;
var DiceOddEvenCa = new web3.eth.Contract(abi.abi, DiceOddEvenContract);

abi = fs.readFileSync("../dice/build/contracts/DiceUnderOver.json", "utf8"); //mainnet

abi = JSON.parse(abi);
var DiceUnderOverContract = abi.networks['100'].address;
var DiceUnderOverCa = new web3.eth.Contract(abi.abi, DiceUnderOverContract);

/** 40 sec */
var abi = fs.readFileSync("../dice/build/contracts/DiceUnder40.json", "utf8"); //mainnet
abi = JSON.parse(abi);

var DiceUnder40Contract = abi.networks['100'].address;
var DiceUnder40Ca = new web3.eth.Contract(abi.abi, DiceUnder40Contract);

abi = fs.readFileSync("../dice/build/contracts/DiceOddEven40.json", "utf8"); //mainnet
abi = JSON.parse(abi);

var DiceOddEven40Contract = abi.networks['100'].address;
var DiceOddEven40Ca = new web3.eth.Contract(abi.abi, DiceOddEven40Contract);

abi = fs.readFileSync("../dice/build/contracts/DiceUnderOver40.json", "utf8"); //mainnet

abi = JSON.parse(abi);
var DiceUnderOver40Contract = abi.networks['100'].address;
var DiceUnderOver40Ca = new web3.eth.Contract(abi.abi, DiceUnderOver40Contract);
/** 40 sec */

function DiceUnder() {

    return new Promise(async (resolve, reject) => {
        let src = "0xd42cc10b24e11b4eb58db29e9f6052d3b4576464";
        var transfer = DiceUnderCa.methods.distribute();
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, "pending");
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: DiceUnderContract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer('637c1c2d22c3926be916e80a96650f4149df7e1590c5be17945a6361c32d740c', 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();

        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                //   console.log('transactionHash', hash)
            })
            .on('receipt', function (receipt) {
                //  console.log('receipt', receipt)
            })
            .on('error', console.error);

        resolve(true);
    });
}

function DiceOddEven() {

    return new Promise(async (resolve, reject) => {
        let src = "0xf5c09e2e3d8cfa48084d5de9ed9bc43ec76b9849";
        var transfer = DiceOddEvenCa.methods.distribute();
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, "pending");
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: DiceOddEvenContract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer('23511a72c5b6f9edbdf32b40bc03c48a48d10b16b80112785f536efe60fe2de1', 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();


        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                //       console.log('transactionHash', hash)
            })
            .on('receipt', function (receipt) {
                //      console.log('receipt', receipt)
            })
            .on('error', console.error);

        resolve(true);
    });
}

function DiceUnderOver() {

    return new Promise(async (resolve, reject) => {
        let src = "0x5ce7f4f65cbfc52d99ec35b12982e4ec7f16acf6";
        var transfer = DiceUnderOverCa.methods.distribute();
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, "pending");
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: DiceUnderOverContract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer('ff227958936874a08ea63c1f4fe1e768264b7b8ac5164232af1c9f470a63be47', 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();


        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                //    console.log('transactionHash', hash)
            })
            .on('receipt', function (receipt) {
                //    console.log('receipt', receipt)
            })
            .on('error', console.error);

        resolve(true);
    });
}

function DiceUnder40() {

    return new Promise(async (resolve, reject) => {
        let src = "0x132fFa0BfF83B9FE7BE4abd2e3b406DB7f83DFB4";
        var transfer = DiceUnder40Ca.methods.distribute();
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, "pending");
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: DiceUnder40Contract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer('ff02295a9addf134394e39691cb8022a1fc074135955f5cda0b95644edda0153', 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();

        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                //   console.log('transactionHash', hash)
            })
            .on('receipt', function (receipt) {
                //  console.log('receipt', receipt)
            })
            .on('error', console.error);

        resolve(true);
    });
}

function DiceOddEven40() {

    return new Promise(async (resolve, reject) => {
        let src = "0x6EB2f370Bd783569220bA050643cD725C0BE0EA4";
        var transfer = DiceOddEven40Ca.methods.distribute();
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, "pending");
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: DiceOddEven40Contract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer('a3f501a9416ca44d217c79d0fc1c936107b27fb23e1c6b320da6957437be8ce4', 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();


        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                //       console.log('transactionHash', hash)
            })
            .on('receipt', function (receipt) {
                //      console.log('receipt', receipt)
            })
            .on('error', console.error);

        resolve(true);
    });
}

function DiceUnderOver40() {

    return new Promise(async (resolve, reject) => {
        let src = "0x3Cd51513d9697c19ee91b29a8c57442E7e80a2be";
        var transfer = DiceUnderOver40Ca.methods.distribute();
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, "pending");
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: DiceUnderOver40Contract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer('df135ad032f84dd97d9110101e4a1b99517b8cddfc3f062f88fd1110cd1fd0d3', 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();


        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                //    console.log('transactionHash', hash)
            })
            .on('receipt', function (receipt) {
                //    console.log('receipt', receipt)
            })
            .on('error', console.error);

        resolve(true);
    });
}
/*
(async () => {
    await DiceUnder(); // OddEven
    await DiceOddEven();
    await DiceUnderOver(); // DiceUnder
})();
*/


// 블록 읽기용 web3_global 인스턴스도 LoggingHttpProvider로 교체 (필요 시)
const web3ReadUrl = process.env.WEB3_GAME_READ_NODE_URL;
console.log(`DEBUG: distribute.js is connecting to WEB3_GAME_READ_NODE_URL: ${web3ReadUrl}`);
const web3_global = new Web3(new Web3.providers.HttpProvider(web3ReadUrl, { timeout: 10000, handleRevert: true }));
//const web3_global = new Web3(new Web3.providers.HttpProvider('http://52.79.152.189:35000'));

event.on('trigger', (number) => {
    web3_global.eth.getBlock('latest').then(async result => {
        console.log(result.number, number);
        let Promises = []
        if (result.number != number) {
            Promises.push(DiceUnder()); // OddEven
            Promises.push(DiceOddEven());
            Promises.push(DiceUnderOver()); // DiceUnder           
            if ((result.number + 1) % 15 === 0) {
                Promises.push(DiceUnder40()); // OddEven
                Promises.push(DiceOddEven40());
                Promises.push(DiceUnderOver40()); // DiceUnder           
            }

        }
        Promise.all(Promises).then(values => {
            trigger(result.number, 1000);
        });
    }).catch(e => {
        trigger(number, 500);
    });
})

function trigger(number, time) {
    setTimeout(() => {
        event.emit('trigger', number);
    }, time);
}

web3_global.eth.getBlock('latest').then(result => {
    event.emit('trigger', result.number);
});