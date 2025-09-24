require('cross-fetch/polyfill');
const db = require('./models');
const EventEmitter = require('events');
const event = new EventEmitter();
const Op = require('sequelize').Op;
const crypto = require('crypto');
const ethUtils = require('ethereumjs-util');
const {ApolloClient, gql, InMemoryCache, ApolloLink, HttpLink} = require('apollo-boost');
const client = new ApolloClient(
    {
        link: ApolloLink.from([
            new HttpLink({
                uri: process.env.OTEX_GRAPHQL_URI,
                credentials: 'same-origin'
            })
        ]),
        cache: new InMemoryCache()
    }
);


event.on('check',()=>{

    db.User.findAll({where:{[Op.or]:{address:'',privateKey:''}}}).then(async rows=>{
        if(rows){
            for(let x in rows){
                let row = rows[x];
                let buffer = crypto.randomBytes(32);
                var token = buffer.toString('hex');
                let fromAddress = ethUtils.privateToAddress("0x"+token);
                fromAddress = fromAddress.toString('hex');
                row.address = fromAddress;
                row.privateKey = token;
                row.save();

                client.mutate({
                    mutation: gql`
                        mutation connectBetBBTFromInitUser($email: String!, $address: String!) {
                            connectBetBBTFromInitUser(email: $email, address: $address) {
                                address
                            }
                        }
                    `,
                    variables: {
                        email: row.email,
                        address: "0x" + row.address
                    }
                }).then(({data}) => {
                    console.dir(data);
                }).catch((error) => {
                    console.dir(error);
                })
            }
        }

        run();
    }).catch(e=>{
        run();
    });
});
function run(){
    setTimeout(()=>{
        event.emit('check');
    },1000);
}
event.emit('check');


