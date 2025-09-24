// BlockBet/server/mock-graphql-server/server.js
const express = require('express');
const { graphqlHTTP } = require('express-graphql');
const { buildSchema } = require('graphql');
const cors = require('cors'); // CORS 미들웨어 추가

const app = express();
const port = 4000;

// CORS 미들웨어 적용: 모든 출처에서의 요청을 허용 (개발용)
app.use(cors());

// GraphQL 스키마 정의 (otex.js의 모든 쿼리/뮤테이션을 포함)
const schema = buildSchema(`
  enum CoinType {
    BBT # otex.js에서 사용되는 CoinType 예시
    # 필요한 다른 코인 타입도 추가할 수 있습니다.
  }

  enum RoleName {
    ROLE_OTEX_USER
    # 필요한 다른 역할도 추가할 수 있습니다.
  }

  type Role {
    name: String
  }

  type ConnectBetBBTFromInitUserResponse {
    address: String
  }

  type ConnectBetBBTResponse {
    coinType: CoinType
    address: String
  }
  
  type SignUpResponse {
    id: ID
    createdAt: String # 실제 날짜 타입일 수 있지만, 문자열로 간단히
    email: String
    phoneNumber: String
    roles: [Role]
  }

  # Query 타입보다 먼저 정의해야 합니다.
  type GetWalletForBetBBTResponse {
    address: String
  }

  type Query {
    hello: String
    getWalletForBetBBT(email: String): GetWalletForBetBBTResponse # 이제 이 타입을 알게 됩니다.
  }

  type Mutation {
    connectBetBBTFromInitUser(email: String!, address: String!): ConnectBetBBTFromInitUserResponse
    connectBetBBT(email: String!, password: String!, coinType: CoinType!, address: String!): ConnectBetBBTResponse
    signUp(email: String!, username: String!, password: String!, roleName: RoleName!, phoneNumber: String, custodyId: Int, referrer: String): SignUpResponse
  }
`);

// 루트 리졸버
const root = {
    hello: () => 'Hello world!',

    connectBetBBTFromInitUser: ({ email, address }) => {
        console.log(`[Mock GraphQL Server] Received connectBetBBTFromInitUser: email=${email}, address=${address}`);
        return { address: address };
    },

    connectBetBBT: ({ email, password, coinType, address }) => {
        console.log(`[Mock GraphQL Server] Received connectBetBBT: email=${email}, coinType=${coinType}, address=${address}`);
        return { coinType: coinType, address: address };
    },

    getWalletForBetBBT: ({ email }) => {
        console.log(`[Mock GraphQL Server] Received getWalletForBetBBT: email=${email}`);
        if (email === 'test@example.com') {
            return { address: '0xTestUserWalletAddress1234567890' };
        }
        return { address: '0xDummyWalletAddressForBetBBT' };
    },

    signUp: ({ email, username, password, roleName, phoneNumber, custodyId, referrer }) => {
        console.log(`[Mock GraphQL Server] Received signUp: email=${email}, username=${username}, roleName=${roleName}`);
        return {
            id: "mock_id_" + Math.floor(Math.random() * 1000),
            createdAt: new Date().toISOString(),
            email: email,
            phoneNumber: phoneNumber,
            roles: [{ name: roleName }],
        };
    },
};

// GraphQL 엔드포인트 설정
app.use('/graphql', graphqlHTTP({
    schema: schema,
    rootValue: root,
    graphiql: true,
}));

app.listen(port, () => {
    console.log(`Mock GraphQL Server listening on http://127.0.0.1:${port}/graphql`);
    console.log(`Access GraphQL Playground at http://127.0.0.1:${port}/graphql`);
});