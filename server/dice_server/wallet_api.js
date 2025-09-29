// BlockBet/server/dice_server/wallet_api.js
require('dotenv').config(); // 환경 변수 로드
const express = require('express');
const crypto = require('crypto');
const ethUtils = require('ethereumjs-util');
const cors = require('cors'); // CORS 허용

const app = express();
const port = process.env.WALLET_API_PORT || 55557; // 새 포트 (예: 55557)

app.use(cors()); // 모든 출처에서 접근 허용 (개발용)
app.use(express.json());

// 지갑 주소 및 개인 키 생성 API
app.get('/generate-wallet', (req, res) => {
    try {
        let buffer = crypto.randomBytes(32); // 32바이트 랜덤 데이터 (개인 키)
        let privateKey = buffer.toString('hex'); // 개인 키 (HEX 문자열)
        let address = ethUtils.privateToAddress("0x" + privateKey); // 개인 키로 주소 파생
        address = address.toString('hex'); // 주소 (HEX 문자열)

        // 응답 데이터 생성
        const response = {
            success: true,
            address: "0x" + address,
            privateKey: privateKey // 프로덕션 환경에서는 절대 노출 금지!
        };

        // 콘솔에 응답 내용 출력
        console.log("API Response:", response);

        // 클라이언트에 JSON 응답 전송
        return res.json(response);

    } catch (error) {
        console.error("지갑 생성 중 오류 발생:", error);
        return res.status(500).json({ success: false, message: "지갑 생성 실패" });
    }
});

app.listen(port, () => {
    console.log(`Wallet API server listening on port ${port}`);
});