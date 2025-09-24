const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const app = express();
const db = require('./models');
const EventEmitter = require('events');
event = new EventEmitter();

app.use(express.json());
app.use(cors());

var oddEvenResult = [];
var underOverResult = [];
var underResult = [];

var oddEven40Result = [];
var underOver40Result = [];
var under40Result = [];

var oddEven40InitResult = [];
var underOver40InitResult = [];
var under40INitResult = [];

app.get('/oddeven',(req,res)=>{
    res.json(oddEvenResult);
});

app.get('/underover',(req,res)=>{
    res.json(underOverResult);
});

app.get('/under',(req,res)=>{
    res.json(underResult);
});


app.get('/oddeven40/init',(req,res)=>{
    res.json(oddEven40InitResult);
});

app.get('/underover40/init',(req,res)=>{
    res.json(underOver40InitResult);
});

app.get('/under40/init',(req,res)=>{
    res.json(under40InitResult);
});


app.get('/oddeven40',(req,res)=>{
    res.json(oddEven40Result);
});

app.get('/underover40',(req,res)=>{
    res.json(underOver40Result);
});

app.get('/under40',(req,res)=>{
    res.json(under40Result);
});

event.on('listen',()=>{
    db.OddEven.findAll({            
            limit:1,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                oddEvenResult = result;
            }
            setTimeout(()=>{
                event.emit('listen');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listen');
            },1000)
        })
});

event.on('listen2',()=>{
    db.UnderOver.findAll({            
            limit:1,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                underOverResult = result;
            }
            setTimeout(()=>{
                event.emit('listen2');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listen2');
            },1000)
        })
});

event.on('listen3',()=>{
    db.Under.findAll({            
            limit:1,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                underResult = result;
            }
            setTimeout(()=>{
                event.emit('listen3');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listen3');
            },1000)
        })
});


event.on('listen40',()=>{
    db.OddEven40.findAll({            
            limit:1,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                oddEven40Result = result;
            }
            setTimeout(()=>{
                event.emit('listen40');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listen40');
            },1000)
        })
});

event.on('listen402',()=>{
    db.UnderOver40.findAll({            
            limit:1,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                underOver40Result = result;
            }
            setTimeout(()=>{
                event.emit('listen402');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listen402');
            },1000)
        })
});

event.on('listen403',()=>{
    db.Under40.findAll({            
            limit:1,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                under40Result = result;
            }
            setTimeout(()=>{
                event.emit('listen403');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listen403');
            },1000)
        })
});


/**
 * 
 * 
 */

event.on('listeninit40',()=>{
    db.OddEven40.findAll({            
            limit:110,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                oddEven40InitResult = result;
            }
            setTimeout(()=>{
                event.emit('listeninit40');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listeninit40');
            },1000)
        })
});

event.on('listeninit402',()=>{
    db.UnderOver40.findAll({            
            limit:110,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                underOver40InitResult = result;
            }
            setTimeout(()=>{
                event.emit('listeninit402');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listeninit402');
            },1000)
        })
});

event.on('listeninit403',()=>{
    db.Under40.findAll({            
            limit:110,
            order:[['blocknumber','desc']],
            attributes:['blocknumber','blockhash','result']
        }).then(rows=>{
            if(rows){
                let result = [];
                for(let x in rows){
                    let row = rows[x];
                    result.push({
                        blocknumber:row.blocknumber,
                        blockhash:row.blockhash,
                        result:row.result,
                    })                    
                }
                under40InitResult = result;
            }
            setTimeout(()=>{
                event.emit('listeninit403');
            },1000)
        }).catch(e=>{
            setTimeout(()=>{
                event.emit('listeninit403');
            },1000)
        })
});

event.emit('listen');
event.emit('listen2');
event.emit('listen3');

event.emit('listen40');
event.emit('listen402');
event.emit('listen403');

event.emit('listeninit40');
event.emit('listeninit402');
event.emit('listeninit403');


app.listen(55555);
