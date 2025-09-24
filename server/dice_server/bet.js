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

const web3 = new Web3(new Web3.providers.HttpProvider(process.env.WEB3_MAIN_NODE_URL, { timeout: 10000, handleRevert: true }));
//var abi = fs.readFileSync("../dice/build/contracts/DiceOddEven.json", "utf8"); //mainnet
//abi = JSON.parse(abi);

const abiPath = path.resolve(__dirname, '../dice/build/contracts/DiceOddEven.json');
console.log(abiPath);

var abi = fs.readFileSync(abiPath, "utf8");
abi = JSON.parse(abi);

var DiceOddEvenContract = abi.networks['100'].address;
var DiceOddEvenCa = new web3.eth.Contract(abi.abi, DiceOddEvenContract);

const abiPathUnderOver = path.resolve(__dirname, '../dice/build/contracts/DiceUnderOver.json');
console.log(abiPathUnderOver);

var abiUnderOver = fs.readFileSync(abiPathUnderOver, "utf8");
abiUnderOver = JSON.parse(abiUnderOver);

var DiceUnderOverContract = abiUnderOver.networks['100'].address;
var DiceUnderOverCa = new web3.eth.Contract(abiUnderOver.abi, DiceUnderOverContract);

const abiPathUnder = path.resolve(__dirname, '../dice/build/contracts/DiceUnder.json');
console.log(abiPathUnder);

abi = fs.readFileSync(abiPathUnder, "utf8"); //mainnet
abi = JSON.parse(abi);

DiceUnderContract = abi.networks['100'].address;
var DiceUnderCa = new web3.eth.Contract(abi.abi, DiceUnderContract);

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


function bet() {
    setTimeout(() => {
        event.emit('bet');
    }, 500);
}

function TStep() {
    setTimeout(() => {
        event.emit('TStep');
    }, 500);
}

function SStep() {
    setTimeout(() => {
        event.emit('SStep');
    }, 500);
}

event.on("SStep", () => {
    db.Bet.findAll({ where: { status: 'S' } }).then(rows => {
        if (rows) {
            let promises = [];
            for (let x in rows) {
                let row = rows[x];
                let promise = new Promise((resolve, reject) => {
                    web3.eth.getBlockNumber().then(blockNumber => {

                        if (blockNumber > row.blockNumber + 1) {
                            db.User.findOne({ where: { name: row.name } }).then(user => {
                                if (user) {
                                    if (row.status === 'S') {

                                        if (row.game === 'oddeven') {
                                            DiceOddEvenCa.methods.getResult(row.blockNumber).call().then(res => {
                                                row.result = res;
                                                row.status = 'L';

                                                if (row.pick % 2 === res % 2) row.status = 'W';

                                                if (row.status === 'W') {
                                                    let a = new BN(row.amount).times(row.rate);
                                                    row.result_amount = a.toPrecision(8);
                                                }
                                                row.save();
                                                // update parter user
                                                if (user.store) {
                                                    db.User.findOne({ where: { name: user.store } }).then(store => {
                                                        if (store) {
                                                            if (store.odds > 0) {
                                                                let result_odds = new BN(store.odds).minus(user.odds).toPrecision(8);
                                                                let request = new BN(result_odds).times(row.amount).toPrecision(8);
                                                                let previous = store.point;
                                                                db.User.update({ point: Sequelize.literal('point + ' + request) }, { where: { id: store.id } });
                                                                db.Point.create({
                                                                    fromName: user.name,
                                                                    toName: store.name,
                                                                    type: 'game',
                                                                    bid: row.id,
                                                                    game: row.game,
                                                                    amount: row.amount,
                                                                    odds: store.odds,
                                                                    result_odds: result_odds,
                                                                    previous: previous,
                                                                    request: request,
                                                                    result: (new BN(store.point)).plus(request).toPrecision(8)
                                                                });
                                                            }
                                                        }
                                                        resolve(true);
                                                    });
                                                } else resolve(true);

                                            }).catch(e => {
                                                resolve(true);
                                            });
                                        } else if (row.game === 'underover') {

                                            DiceUnderOverCa.methods.getResult(row.blockNumber).call().then(res => {

                                                row.result = res;
                                                row.status = 'L';

                                                if (row.pick < 51 && res < 51) row.status = 'W';
                                                if (row.pick > 50 && res > 50) row.status = 'W';

                                                if (row.status === 'W') {
                                                    let a = new BN(row.amount).times(row.rate);
                                                    row.result_amount = a.toPrecision(8);
                                                }
                                                row.save();

                                                // update parter user                                                
                                                if (user.store) {
                                                    db.User.findOne({ where: { name: user.store } }).then(store => {
                                                        if (store) {
                                                            if (store.odds > 0) {
                                                                let result_odds = new BN(store.odds).minus(user.odds).toPrecision(8);
                                                                let request = new BN(result_odds).times(row.amount).toPrecision(8);
                                                                let previous = store.point;
                                                                db.User.update({ point: Sequelize.literal('point + ' + request) }, { where: { id: store.id } });
                                                                db.Point.create({
                                                                    fromName: user.name,
                                                                    toName: store.name,
                                                                    type: 'game',
                                                                    bid: row.id,
                                                                    game: row.game,
                                                                    amount: row.amount,
                                                                    odds: store.odds,
                                                                    result_odds: result_odds,
                                                                    previous: previous,
                                                                    request: request,
                                                                    result: (new BN(store.point)).plus(request).toPrecision(8)
                                                                });
                                                            }
                                                        }
                                                        resolve(true);
                                                    });
                                                } else resolve(true);
                                            }).catch(e => {
                                                console.log(e);
                                                resolve(true);
                                            });
                                        } else if (row.game === 'under') {
                                            DiceUnderCa.methods.getResult(row.blockNumber).call().then(res => {
                                                row.result = res;
                                                row.status = 'L';

                                                if (row.pick > res) row.status = 'W';


                                                if (row.status === 'W') {
                                                    let a = new BN(row.amount).times(row.rate);
                                                    row.result_amount = a.toPrecision(8);
                                                }
                                                row.save();

                                                // update parter user
                                                if (user.store) {
                                                    db.User.findOne({ where: { name: user.store } }).then(store => {
                                                        if (store) {
                                                            if (store.odds > 0) {
                                                                let result_odds = new BN(store.odds).minus(user.odds).toPrecision(8);
                                                                let request = new BN(result_odds).times(row.amount).toPrecision(8);
                                                                let previous = store.point;
                                                                db.User.update({ point: Sequelize.literal('point + ' + request) }, { where: { id: store.id } });
                                                                db.Point.create({
                                                                    fromName: user.name,
                                                                    toName: store.name,
                                                                    type: 'game',
                                                                    bid: row.id,
                                                                    game: row.game,
                                                                    amount: row.amount,
                                                                    odds: store.odds,
                                                                    result_odds: result_odds,
                                                                    previous: previous,
                                                                    request: request,
                                                                    result: (new BN(store.point)).plus(request).toPrecision(8)
                                                                });
                                                            }
                                                        }
                                                        resolve(true);
                                                    });
                                                } else resolve(true);
                                            }).catch(e => {
                                                resolve(true);
                                            });
                                        } else if (row.game === 'oddeven40') {
                                            DiceOddEven40Ca.methods.getResult(row.blockNumber).call().then(res => {
                                                row.result = res;
                                                row.status = 'L';

                                                if (row.pick % 2 === res % 2) row.status = 'W';

                                                if (row.status === 'W') {
                                                    let a = new BN(row.amount).times(row.rate);
                                                    row.result_amount = a.toPrecision(8);
                                                }
                                                row.save();
                                                // update parter user
                                                if (user.store) {
                                                    db.User.findOne({ where: { name: user.store } }).then(store => {
                                                        if (store) {
                                                            if (store.odds > 0) {
                                                                let result_odds = new BN(store.odds).minus(user.odds).toPrecision(8);
                                                                let request = new BN(result_odds).times(row.amount).toPrecision(8);
                                                                let previous = store.point;
                                                                db.User.update({ point: Sequelize.literal('point + ' + request) }, { where: { id: store.id } });
                                                                db.Point.create({
                                                                    fromName: user.name,
                                                                    toName: store.name,
                                                                    type: 'game',
                                                                    bid: row.id,
                                                                    game: row.game,
                                                                    amount: row.amount,
                                                                    odds: store.odds,
                                                                    result_odds: result_odds,
                                                                    previous: previous,
                                                                    request: request,
                                                                    result: (new BN(store.point)).plus(request).toPrecision(8)
                                                                });
                                                            }
                                                        }
                                                        resolve(true);
                                                    });
                                                } else resolve(true);

                                            }).catch(e => {
                                                resolve(true);
                                            });
                                        } else if (row.game === 'underover40') {

                                            DiceUnderOver40Ca.methods.getResult(row.blockNumber).call().then(res => {

                                                row.result = res;
                                                row.status = 'L';

                                                if (row.pick < 51 && res < 51) row.status = 'W';
                                                if (row.pick > 50 && res > 50) row.status = 'W';

                                                if (row.status === 'W') {
                                                    let a = new BN(row.amount).times(row.rate);
                                                    row.result_amount = a.toPrecision(8);
                                                }
                                                row.save();

                                                // update parter user                                                
                                                if (user.store) {
                                                    db.User.findOne({ where: { name: user.store } }).then(store => {
                                                        if (store) {
                                                            if (store.odds > 0) {
                                                                let result_odds = new BN(store.odds).minus(user.odds).toPrecision(8);
                                                                let request = new BN(result_odds).times(row.amount).toPrecision(8);
                                                                let previous = store.point;
                                                                db.User.update({ point: Sequelize.literal('point + ' + request) }, { where: { id: store.id } });
                                                                db.Point.create({
                                                                    fromName: user.name,
                                                                    toName: store.name,
                                                                    type: 'game',
                                                                    bid: row.id,
                                                                    game: row.game,
                                                                    amount: row.amount,
                                                                    odds: store.odds,
                                                                    result_odds: result_odds,
                                                                    previous: previous,
                                                                    request: request,
                                                                    result: (new BN(store.point)).plus(request).toPrecision(8)
                                                                });
                                                            }
                                                        }
                                                        resolve(true);
                                                    });
                                                } else resolve(true);
                                            }).catch(e => {
                                                console.log(e);
                                                resolve(true);
                                            });
                                        } else if (row.game === 'under40') {
                                            DiceUnder40Ca.methods.getResult(row.blockNumber).call().then(res => {
                                                row.result = res;
                                                row.status = 'L';

                                                if (row.pick > res) row.status = 'W';


                                                if (row.status === 'W') {
                                                    let a = new BN(row.amount).times(row.rate);
                                                    row.result_amount = a.toPrecision(8);
                                                }
                                                row.save();

                                                // update parter user
                                                if (user.store) {
                                                    db.User.findOne({ where: { name: user.store } }).then(store => {
                                                        if (store) {
                                                            if (store.odds > 0) {
                                                                let result_odds = new BN(store.odds).minus(user.odds).toPrecision(8);
                                                                let request = new BN(result_odds).times(row.amount).toPrecision(8);
                                                                let previous = store.point;
                                                                db.User.update({ point: Sequelize.literal('point + ' + request) }, { where: { id: store.id } });
                                                                db.Point.create({
                                                                    fromName: user.name,
                                                                    toName: store.name,
                                                                    type: 'game',
                                                                    bid: row.id,
                                                                    game: row.game,
                                                                    amount: row.amount,
                                                                    odds: store.odds,
                                                                    result_odds: result_odds,
                                                                    previous: previous,
                                                                    request: request,
                                                                    result: (new BN(store.point)).plus(request).toPrecision(8)
                                                                });
                                                            }
                                                        }
                                                        resolve(true);
                                                    });
                                                } else resolve(true);
                                            }).catch(e => {
                                                resolve(true);
                                            });
                                        } else resolve(false);


                                    } else resolve(false);
                                } else resolve(false);
                            });
                        } else resolve(false);

                    }).catch(e => {
                        resolve(false);
                    });
                });

                promises.push(promise);
            }
            Promise.all(promises).then(values => {
                SStep();
            });
        } else {
            SStep();
        }
    });
})

event.on("TStep", () => {
    db.Bet.findAll({ where: { status: 'T' } }).then(rows => {
        if (rows) {
            let promises = [];
            for (let x in rows) {
                let row = rows[x];
                let promise = new Promise((resolve, reject) => {
                    db.User.findOne({ where: { name: row.name } }).then(user => {
                        if (user) {
                            if (row.status === 'T') {
                                //console.log(row.transaction);
                                web3.eth.getTransactionReceipt(row.transaction).then(receipt => {
                                    if (receipt) {

                                        if (row.game === "oddeven40" || row.game === "under40" || row.game === "underover40") {
                                            let betBlock = receipt.blockNumber % 15;
                                            row.blockNumber = receipt.blockNumber - betBlock + 15;

                                        } else {
                                            row.blockNumber = receipt.blockNumber;
                                        }


                                        row.blockhash = receipt.blockHash;
                                        row.status = 'S';
                                        row.save();
                                    }
                                    resolve(true);
                                }).catch(e => {
                                    console.log(e);
                                    console.log(row.name + " error Transaction " + row.transaction)
                                    row.status = 'C';
                                    row.save();
                                    resolve(true);
                                });
                            } else resolve(false);
                        } else resolve(false)
                    });
                });
                promises.push(promise);
            }

            Promise.all(promises).then(values => {
                TStep();
            });

        } else {
            TStep();
        }
    });
})

event.on('bet', () => {
    db.Bet.findAll({ where: { status: 'R' } }).then(rows => {
        if (rows) {
            let promises = [];

            for (let x in rows) {
                let row = rows[x];
                let promise = new Promise((resolve, reject) => {
                    db.User.findOne({ where: { name: row.name } }).then(user => {
                        if (user) {
                            if (row.status === 'R') {
                                if (row.game === 'oddeven') {
                                    if (row.pick % 2 === 1 || row.pick % 2 === 0) {
                                        betUser(DiceOddEvenCa, DiceOddEvenContract, "0x" + user.address, user.privateKey, row.pick, row.amount).then(hash => {
                                            row.status = 'T';
                                            row.transaction = hash;
                                            row.save();
                                            resolve(true);
                                        }).catch(e => {
                                            // error cancel
                                            console.log(e);
                                            row.status = 'C';
                                            row.save();
                                            resolve(true);
                                        })
                                    } else {
                                        row.status = 'C';
                                        row.save();
                                        resolve(true);
                                    }

                                } else if (row.game === 'oddeven40') {
                                    if (row.pick % 2 === 1 || row.pick % 2 === 0) {
                                        betUser(DiceOddEven40Ca, DiceOddEven40Contract, "0x" + user.address, user.privateKey, row.pick, row.amount).then(hash => {
                                            row.status = 'T';
                                            row.transaction = hash;
                                            row.save();
                                            resolve(true);
                                        }).catch(e => {
                                            // error cancel
                                            console.log(e);
                                            row.status = 'C';
                                            row.save();
                                            resolve(true);
                                        })
                                    } else {
                                        row.status = 'C';
                                        row.save();
                                        resolve(true);
                                    }
                                } else if (row.game === 'underover') {
                                    if (row.pick > 0 || row.pick <= 100) {
                                        betUser(DiceUnderOverCa, DiceUnderOverContract, "0x" + user.address, user.privateKey, row.pick, row.amount).then(hash => {
                                            row.status = 'T';
                                            row.transaction = hash;
                                            row.save();
                                            resolve(true);
                                        }).catch(e => {
                                            // error cancel
                                            console.log(e);
                                            row.status = 'C';
                                            row.save();
                                            resolve(true);
                                        })
                                    } else {
                                        row.status = 'C';
                                        row.save();
                                        resolve(true);
                                    }
                                } else if (row.game === 'underover40') {
                                    if (row.pick > 0 || row.pick <= 100) {
                                        betUser(DiceUnderOver40Ca, DiceUnderOver40Contract, "0x" + user.address, user.privateKey, row.pick, row.amount).then(hash => {
                                            row.status = 'T';
                                            row.transaction = hash;
                                            row.save();
                                            resolve(true);
                                        }).catch(e => {
                                            // error cancel
                                            console.log(e);
                                            row.status = 'C';
                                            row.save();
                                            resolve(true);
                                        })
                                    } else {
                                        row.status = 'C';
                                        row.save();
                                        resolve(true);
                                    }
                                } else if (row.game === 'under') {
                                    betUser(DiceUnderCa, DiceUnderContract, "0x" + user.address, user.privateKey, row.pick, row.amount).then(hash => {
                                        row.status = 'T';
                                        row.transaction = hash;
                                        row.save();
                                        resolve(true);
                                    }).catch(e => {
                                        // error cancel
                                        console.log(e);
                                        row.status = 'C';
                                        row.save();
                                        resolve(true);
                                    })
                                } else if (row.game === 'under40') {
                                    betUser(DiceUnder40Ca, DiceUnder40Contract, "0x" + user.address, user.privateKey, row.pick, row.amount).then(hash => {
                                        row.status = 'T';
                                        row.transaction = hash;
                                        row.save();
                                        resolve(true);
                                    }).catch(e => {
                                        // error cancel
                                        console.log(e);
                                        row.status = 'C';
                                        row.save();
                                        resolve(true);
                                    })
                                } else {
                                    row.status = 'C';
                                    row.save();
                                    resolve(true);
                                }
                            } else resolve(false);
                        } else resolve(false);
                    });
                });
                promises.push(promise);
            }

            Promise.all(promises).then(values => {
                bet();
            });

        } else {
            bet()
        }
    });
});

event.emit('bet');
event.emit("TStep");
event.emit("SStep");

function betUser(contract, contractAddress, address, privString, pick, amount) {
    return new Promise(async (resolve, reject) => {
        amount = new BN(amount, 10);
        amount = amount.times(1e8);

        var transfer = contract.methods.bet(pick, amount.toFixed());
        var encodedABI = transfer.encodeABI();
        var res_nonce = await web3.eth.getTransactionCount(address, 'pending');
        var rawTransaction = {
            nonce: res_nonce,
            gas: 4500000,
            gasPrice: 0,
            from: address,
            to: contractAddress,
            value: 0,
            data: encodedABI
        };
        var tx = new Tx(rawTransaction);
        var privKey = new Buffer(privString, 'hex')
        tx.sign(privKey);
        var serializedTx = tx.serialize();


        web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'))
            .on('transactionHash', function (hash) {
                resolve(hash);
            })
            .on('error', () => {
                reject();
            });
    });
}
