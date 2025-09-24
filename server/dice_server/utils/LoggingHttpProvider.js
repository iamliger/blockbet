// BlockBet/server/dice_server/utils/LoggingHttpProvider.js

const Web3 = require('web3'); // Web3 모듈을 여기서도 가져와야 합니다.

class LoggingHttpProvider extends Web3.providers.HttpProvider {
    constructor(host, options) {
        super(host, options);
        this.host = host;
        // console.log(`DEBUG: LoggingHttpProvider created for host: ${this.host}`); // 필요하면 활성화
    }

    send(payload, callback) {
        // console.log(`DEBUG: Request to ${this.host} for method: ${payload.method}, ID: ${payload.id}`); // 필요하면 활성화
        // console.log(`DEBUG: Request Payload: ${JSON.stringify(payload)}`); // 필요하면 활성화

        super.send(payload, (error, result) => {
            if (error) {
                // console.error(`DEBUG: Response ERROR from ${this.host} for method: ${payload.method}, ID: ${payload.id}:`, error); // 필요하면 활성화
            } else {
                // console.log(`DEBUG: Response SUCCESS from ${this.host} for method: ${payload.method}, ID: ${payload.id}`); // 필요하면 활성화
                // console.log(`DEBUG: Response Result: ${JSON.stringify(result)}`); // 필요하면 활성화
            }
            callback(error, result);
        });
    }
}

module.exports = LoggingHttpProvider;