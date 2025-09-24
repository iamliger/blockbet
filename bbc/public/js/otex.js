const client = new Apollo.lib.ApolloClient({
    networkInterface: Apollo.lib.createNetworkInterface({
        // Edit: https://launchpad.graphql.com/nnnwvmq07
        uri: window.APP_GRAPHQL_URI,
        transportBatching: true,
    }),
    connectToDevTools: true,
});

function connectBetBBT(email, password, coinType, address) {
    return client.mutate({
        mutation: Apollo.gql`
            mutation connectBetBBT($email: String!, $password: String!, $coinType:CoinType!, $address: String!) {
                connectBetBBT(email:$email, password:$password, coinType: $coinType, address: $address) {
                    coinType
                    address
                }
            }
        `, variables: {
            email, password, coinType, address
        },
    });
}


function getWalletForBetBBT(email) {
    return client.query({
        query: Apollo.gql`
            query getWalletForBetBBT($email: String) {
                getWalletForBetBBT(email: $email) {
                    address
                }
            }
        `, variables: {
            email
        }
    })
}

const signUp = (email, username, password, phoneNumber) => {
    const roleName = 'ROLE_OTEX_USER';

    return client.mutate({
        mutation: Apollo.gql`
            mutation signUp($email:String!, $username:String!, $password:String!, $roleName: RoleName!, $phoneNumber: String,
                $custodyId: Int, $referrer: String) {
                signUp(email: $email, username: $username, password: $password, roleName: $roleName, phoneNumber: $phoneNumber,
                    custodyId: $custodyId, referrer: $referrer) {
                    id
                    createdAt
                    email
                    phoneNumber
                    roles {
                        name
                    }
                }
            }
        `,
        variables: {
            email, username, password, phoneNumber, roleName
        }
    });
}
