'use strict';
module.exports = (sequelize, DataTypes) => {
  const Transfer = sequelize.define('Transfer', {    
        id:{
            type:DataTypes.BIGINT,
            primaryKey:true,
            autoIncrement:true,
            unique:true,
        },
        fromName:{
            type:DataTypes.STRING,
            field:"fromName",
            allowNull:false,
        },
        fromAddress:{
            type:DataTypes.STRING,
            field:"fromAddress",
            allowNull:false,
        },
        toName:{
            type:DataTypes.STRING,
            field:"toName",
            allowNull:false,
        },
        toAddress:{
            type:DataTypes.STRING,
            field:"toAddress",
            allowNull:false,
        },
        amount:{
            type:DataTypes.DOUBLE,
            defaultValue:0,
            allowNull:false,
        },
        tid:{
            type:DataTypes.STRING,            
            allowNull:false,
        },
        status:{
            type:DataTypes.CHAR(1),
            defaultValue:'R', 
            allowNull:false,
        },         
  }, {
    underscored: true,
    freezeTableName: true,
    tableName: "transfers"
});
Transfer.associate = function(models) {
    // associations can be defined here
  };
  
  return Transfer;
};
