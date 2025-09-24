require('dotenv').config();

const Web3 = require('web3');
const fs = require('fs');
const EventEmitter = require('events');
const db = require('./models')
const event = new EventEmitter();
var Tx = require('ethereumjs-tx');
var BN = require('bignumber.js');
const Sequelize = require('sequelize');
const path = require('path'); // path 모듈 추가


const web3 = new Web3(new Web3.providers.HttpProvider(process.env.WEB3_MAIN_NODE_URL, { timeout: 10000 }));
//var abi = fs.readFileSync("../dice/build/contracts/BBT.json", "utf8"); //mainnet
//abi = JSON.parse(abi);

const abiPath = path.resolve(__dirname, '../dice/build/contracts/BBT.json');
console.log(abiPath);

var abi = fs.readFileSync(abiPath, "utf8");
abi = JSON.parse(abi);

var contract = abi.networks['100'].address;
var ca = new web3.eth.Contract(abi.abi, contract);


function runR() {
    setTimeout(() => {
        event.emit('R');
    }, 1000);
}


function runS() {
    setTimeout(() => {
        event.emit('S');
    }, 1000);
}

event.on('S', () => {
    db.Transfer.findAll({ where: { status: 'S' } }).then(rows => {
        if (rows) {
            let promises = [];
            for (let x in rows) {
                let row = rows[x];
                let promise = new Promise((resolve, reject) => {
                    web3.eth.getTransactionReceipt(row.tid).then(receipt => {
                        if (receipt) {
                            if (receipt.status === true) {
                                row.status = 'F';
                                row.save();
                            } else {
                                row.status = 'C';
                                row.save();
                            }
                        } else {
                            row.status = 'C';
                            row.save();
                        }

                        resolve(true)

                    }).catch(e => {
                        console.log(e);
                        row.status = 'C';
                        row.save();
                        reject(false);

                    })
                });

                promises.push(promise);
            }

            Promise.all(promises).then(values => {
                runS();
            });
        }
    }).catch(e => {
        runS();
    });
});


event.on('R', () => {
    db.Transfer.findAll({ where: { status: 'R' } }).then(rows => {
        if (rows) {
            let promises = [];
            for (let x in rows) {
                let row = rows[x];
                let promise = new Promise((resolve, reject) => {
                    db.User.findOne({ where: { name: row.fromName } }).then(user => {
                        transfer(user.address, user.privateKey, row.toAddress, row.amount).then(hash => {
                            row.tid = hash;
                            row.status = 'S';
                            row.save();
                            resolve(true)
                        }).catch(e => {
                            console.log(e);
                            row.status = 'C';
                            row.save();
                            reject(false);
                        });
                    }).catch(e => {
                        console.log(e);
                        row.status = 'C';
                        row.save();
                        reject(false);
                    })
                });

                promises.push(promise);
            }

            Promise.all(promises).then(values => {
                runR();
            });
        }
    }).catch(e => {
        runR();
    });
});

function transfer(fromAddress, privateKey, toAddress, amount) {

    fromAddress = fromAddress.replace('0x', '');
    toAddress = toAddress.replace('0x', '');

    amount = new BN(amount, 10)
    amount = amount.times(1e8);
    return new Promise(async (resolve, reject) => {
        let src = "0x" + fromAddress;
        var transfer = ca.methods.transfer("0x" + toAddress, amount.toFixed());
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(src, 'pending');
        console.log(res_nonce);
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: src,
            to: contract, //dst,
            value: 0, //web3.utils.toWei('1', 'ether')
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer(privateKey, 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();


        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                resolve(hash);
            })
            .on('error', (e) => {
                reject(e);
            })

    })
}

event.emit('R');
event.emit('S');
