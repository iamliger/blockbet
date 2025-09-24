require('dotenv').config();

const db = require('./models');
const Web3 = require('web3');
const fs = require('fs');

const EventEmitter = require('events');
const path = require('path'); // path 모듈 추가

const event = new EventEmitter();

const web3 = new Web3(new Web3.providers.HttpProvider(process.env.WEB3_GAME_READ_NODE_URL, { timeout: 10000 }));
//var abi = fs.readFileSync("../dice/build/contracts/DiceUnderOver.json", "utf8"); 
//abi = JSON.parse(abi);

const abiPath = path.resolve(__dirname, '../dice/build/contracts/DiceUnderOver.json');
console.log(abiPath);

var abi = fs.readFileSync(abiPath, "utf8");
abi = JSON.parse(abi);

var contract = abi.networks['100'].address;
var ca = new web3.eth.Contract(abi.abi, contract);

event.on('trigger', () => {
    web3.eth.getBlock('latest').then(result => {
        web3.eth.getBlock(result.number - 1).then(result => {
            let blockhash = result.hash;
            let blocknumber = result.number;

            ca.methods.getResult(blocknumber).call().then(res => {
                db.UnderOver.add(blocknumber, blockhash, res);
                setTimeout(() => {
                    event.emit('trigger');
                }, 1000);
            }).catch(() => {
                setTimeout(() => {
                    event.emit('trigger');
                }, 1000);
            })
        }).catch(() => {
            setTimeout(() => {
                event.emit('trigger');
            }, 1000);
        });
    }).catch(() => {
        setTimeout(() => {
            event.emit('trigger');
        }, 1000);
    })
});

event.emit('trigger');








//return ca.methods.getResult(blockNumber).call();