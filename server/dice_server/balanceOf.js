require('dotenv').config();
const path = require('path');

const Web3 = require('web3');
const fs = require('fs');
const express = require('express');
const app = express();
const cors = require('cors');
var throttle = require("express-throttle");

app.use(express.json());
app.use(cors());

const web3 = new Web3(new Web3.providers.HttpProvider(process.env.WEB3_MAIN_NODE_URL, { timeout: 10000, handleRevert: true }));

const abiPath = path.resolve(__dirname, '../dice/build/contracts/BBT.json');
console.log(abiPath);

var abi = fs.readFileSync(abiPath, "utf8");
abi = JSON.parse(abi);

var contract = abi.networks['100'].address;
var ca = new web3.eth.Contract(abi.abi, contract);

async function getbalance(address) {
    let balance = ca.methods.balanceOf(address).call();
    console.log(balance / 1e8);
}

let blockHeight = 0;

app.get('/balanceOf/:address', throttle({ "rate": "6/s" }), (req, res) => {
    try {
        ca.methods.balanceOf(req.params.address).call().then(balance => {
            res.json({ address: req.params.address, balance: balance / 1e8 });
        }).catch(e => {
            res.json({ address: req.params.address, balance: 0 });
        })
    } catch (e) {
        console.log(e);
        res.json({ address: req.params.address, balance: 0 });
    }
});

app.get('/block', (req, res) => {
    res.json({ blockNumber: blockHeight });
});

let getBlockHeight = () => {
    web3.eth.getBlock('latest').then(result => {
        blockHeight = result.number;

    }).catch(e => {
        console.log(e);
    }).finally(() => {
        setTimeout(() => {
            getBlockHeight();
        }, 1000);
    })
}

getBlockHeight();

// 환경 변수에서 포트 번호를 읽어오고, 환경 변수가 없으면 기본값 55556을 사용합니다.
const port = process.env.BALANCEOF_API_PORT || 55556;
app.listen(port, () => {
    console.log(`BalanceOf API server listening on port ${port}`); // 서버 시작 메시지 추가 (선택 사항)
});