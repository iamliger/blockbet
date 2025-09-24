'use strict';
module.exports = (sequelize, DataTypes) => {
  const Balance = sequelize.define('Balance', {    
        id:{
            type:DataTypes.BIGINT,
            primaryKey:true,
            autoIncrement:true,
            unique:true,
        },
        type:{
            type:DataTypes.INTEGER,
            allowNull:false,
        },
        name:{
            type:DataTypes.STRING,            
            allowNull:false,
        },
        status:{
            type:DataTypes.CHAR(1),
            defaultValue:'R', 
            allowNull:false,
        },  
        amount:{
            type:DataTypes.DOUBLE,
            defaultValue:0,
            allowNull:false,
        },
        address:{
            type:DataTypes.STRING,            
            allowNull:false,
        },        
        tid:{
            type:DataTypes.STRING,            
            defaultValue:'',
            allowNull:false,
        },
        resulted_at:DataTypes.DATE,
  }, {
    underscored: true,
    freezeTableName: true,
    tableName: "balances"
});
Balance.associate = function(models) {
    // associations can be defined here
  };
  
  return Balance;
};
