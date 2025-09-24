'use strict';

/*
트랜젝션을 기록하고 W로 변경.
S가 있으면 getResult로 결과를 기록,
W,L 나머지 함
*/
module.exports = (sequelize, DataTypes) => {
  const Bet = sequelize.define('Bet', {    
    id:{
        type:DataTypes.BIGINT,
        primaryKey:true,
        unique:true,
        autoIncrement:true,
    },
    game:DataTypes.STRING,
    name:DataTypes.STRING,
    amount:DataTypes.DOUBLE,    
    pick:DataTypes.INTEGER,    
    status:{
        type:DataTypes.CHAR(1),
        defaultValue:'R', 
        allowNull:false,
    }, 
    blockNumber:{
      type:DataTypes.BIGINT,
      allowNull:false,
      field:"blockNumber"
    },
    blockhash:{
      type:DataTypes.STRING(255),
      allowNull:false,
    },
    transaction:{
        type:DataTypes.STRING(255),
        allowNull:false,
    },    
    rate:{
        type:DataTypes.DOUBLE,
        allowNull:false,
        defaultValue:0,
      },
    result_amount:{
      type:DataTypes.DOUBLE,
      allowNull:false,
      defaultValue:0,
    },
    result :{
        type:DataTypes.INTEGER,
        allowNull:false,
        defaultValue:0,
    }
  }, {
    underscored: true,
    freezeTableName: true,
    tableName: "bets"
});
Bet.associate = function(models) {
    // associations can be defined here
  };

  return Bet;
};
