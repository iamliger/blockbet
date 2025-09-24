'use strict';
module.exports = (sequelize, DataTypes) => {
  const OddEven = sequelize.define('OddEven', {    
    
    blocknumber:{
      type:DataTypes.BIGINT,
      allowNull:false,
    },
    blockhash:{
      type:DataTypes.STRING(255),
      allowNull:false,
    },
    result:{
      type:DataTypes.STRING(64),
      allowNull:false,
    }    
  }, {
    underscored: true,
    freezeTableName: true,
    tableName: "oddEven"
});
OddEven.associate = function(models) {
    // associations can be defined here
  };

OddEven.add = function(blocknumber,blockhash,result){
  return OddEven.findOrCreate({where:{blocknumber},defaults:{blockhash,blocknumber,result}});
} 
  return OddEven;
};
