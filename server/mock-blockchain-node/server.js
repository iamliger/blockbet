// BlockBet/server/mock-blockchain-node/server.js
const express = require('express');
const bodyParser = require('body-parser');

const app = express();
// 이 라인이 잘 되어 있고, app.use(bodyParser.json());가 가장 위에 있는지 확인
app.use(bodyParser.json());

const port = process.argv[2] || 8545;

let currentBlockNumber = 1000;
const transactionReceipts = {};
const addressNonces = {};

app.post('/', (req, res) => {
    const { jsonrpc, method, params, id } = req.body;

    if (jsonrpc !== '2.0') {
        return res.status(400).json({ jsonrpc: '2.0', id, error: { code: -32600, message: 'Invalid JSON RPC version' } });
    }

    console.log(`[Mock Node:${port}] Received method: ${method}, ID: ${id}`);
    console.log(`[Mock Node:${port}] Request Body: ${JSON.stringify(req.body)}`); // 요청 본문 로깅 추가

    switch (method) {
        case 'eth_blockNumber':
            currentBlockNumber++;
            return res.json({ jsonrpc: '2.0', id: id, result: '0x' + currentBlockNumber.toString(16) }); // id: id 로 수정

        case 'eth_getTransactionCount':
            const address = params[0]; // 요청에서 주소 가져오기
            const blockTag = params[1]; // 'latest', 'pending' 등

            // 해당 주소의 nonce를 관리합니다.
            if (!addressNonces[address]) {
                addressNonces[address] = 0;
            }
            // 'pending' 요청인 경우 nonce를 증가시켜 반환할 수 있습니다.
            // 하지만 여기서는 간단히 현재 nonce를 반환합니다.
            const nonce = addressNonces[address];

            console.log(`[Mock Node:${port}] eth_getTransactionCount for ${address}, tag: ${blockTag}, returning nonce: ${nonce}`);
            return res.json({ jsonrpc: '2.0', id: id, result: '0x' + nonce.toString(16) });

        case 'eth_sendRawTransaction':
            // web3.js가 raw 트랜잭션 데이터를 params[0]에 보냅니다.
            const rawTxData = params[0];
            // 실제 이더리움에서는 rawTxData를 디코딩하여 from 주소 등을 추출하지만,
            // Mock 서버에서는 단순화를 위해 랜덤 해시를 생성합니다.

            const txHash = '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

            // 전송된 트랜잭션에 대한 더미 영수증을 저장합니다.
            // 이 영수증은 나중에 'eth_getTransactionReceipt' 요청 시 사용됩니다.
            transactionReceipts[txHash] = {
                blockHash: '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15), // 더미 블록 해시
                blockNumber: '0x' + currentBlockNumber.toString(16), // 현재 Mock 블록 번호
                contractAddress: null, // 컨트랙트 생성 트랜잭션이 아니므로 null
                cumulativeGasUsed: '0x' + (Math.floor(Math.random() * 100000)).toString(16), // 더미 가스 사용량
                from: '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15), // 더미 from 주소 (실제 디코딩은 복잡)
                gasUsed: '0x' + (Math.floor(Math.random() * 50000)).toString(16), // 더미 가스 사용량
                status: '0x1', // '0x1'은 성공, '0x0'은 실패 (web3.js에서 true/false로 해석)
                to: '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15), // 더미 to 주소 (실제 디코딩은 복잡)
                transactionHash: txHash,
                transactionIndex: '0x0',
                logs: [], // 더미 로그
                logsBloom: '0x' + '0'.repeat(512), // 더미 블룸 필터
            };

            // Mock 서버는 트랜잭션이 전송되면 해당 계정의 nonce를 증가시킬 수 있습니다.
            // 하지만 현재 getTransactionCount에서 이미 증가된 값을 반환하므로 여기서는 생략합니다.
            // 필요하다면 rawTxData를 디코딩하여 실제 from 주소를 얻고 addressNonces[fromAddress]++;를 할 수 있습니다.

            console.log(`[Mock Node:${port}] eth_sendRawTransaction received. Returning txHash: ${txHash}`);
            return res.json({ jsonrpc: '2.0', id: id, result: txHash });

        case 'eth_getTransactionReceipt':
            const requestedTxHash = params[0];
            const receipt = transactionReceipts[requestedTxHash] || null;
            return res.json({ jsonrpc: '2.0', id: id, result: receipt }); // id: id 로 수정

        case 'eth_call':
            return res.json({ jsonrpc: '2.0', id: id, result: '0x' + '0'.repeat(64) }); // id: id 로 수정

        case 'eth_getBlockByNumber':
        case 'eth_getBlockByHash':
        case 'eth_getBlock':
            // 이 부분을 수정: 블록 요청 시에도 블록 번호를 증가시킵니다.
            currentBlockNumber++; // <--- 이 줄을 여기에 추가합니다.
            const blockId = params[0];
            const currentBlockNumHex = '0x' + currentBlockNumber.toString(16);

            return res.json({
                jsonrpc: '2.0',
                id: id,
                result: {
                    number: currentBlockNumHex, // 블록 번호 (16진수)
                    hash: '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
                    parentHash: '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
                    mixHash: '0x' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
                    nonce: '0x' + '0'.repeat(16),
                    sha3Uncles: '0x' + '0'.repeat(64),
                    logsBloom: '0x' + '0'.repeat(512),
                    transactionsRoot: '0x' + '0'.repeat(64),
                    stateRoot: '0x' + '0'.repeat(64),
                    receiptsRoot: '0x' + '0'.repeat(64),
                    miner: '0x' + '0'.repeat(40),
                    difficulty: '0x' + '1',
                    totalDifficulty: '0x' + '1',
                    extraData: '0x',
                    size: '0x' + (1000 + Math.floor(Math.random() * 500)).toString(16),
                    gasLimit: '0x' + (8000000).toString(16),
                    gasUsed: '0x' + (100000 + Math.floor(Math.random() * 50000)).toString(16),
                    timestamp: '0x' + Math.floor(Date.now() / 1000).toString(16),
                    transactions: [],
                    uncles: [],
                }
            });

        case 'eth_chainId':
            return res.json({ jsonrpc: '2.0', id: id, result: '0x64' }); // id: id 로 수정

        case 'net_version':
            return res.json({ jsonrpc: '2.0', id: id, result: '100' }); // id: id 로 수정

        case 'eth_gasPrice':
            return res.json({ jsonrpc: '2.0', id: id, result: '0x0' }); // id: id 로 수정

        case 'eth_syncing':
            return res.json({ jsonrpc: '2.0', id: id, result: false }); // id: id 로 수정

        case 'web3_clientVersion':
            return res.json({ jsonrpc: '2.0', id: id, result: 'MockNode/v1.0.0/node-js' }); // id: id 로 수정

        default:
            console.log(`[Mock Node:${port}] Unhandled method: ${method}. Returning simplest blockNumber.`);
            return res.json({ jsonrpc: '2.0', id: id, result: '0x' + currentBlockNumber.toString(16) });
    }
});

app.listen(port, () => {
    console.log(`Mock Ethereum Node (ID: ${port}) listening on http://127.0.0.1:${port}`);
});