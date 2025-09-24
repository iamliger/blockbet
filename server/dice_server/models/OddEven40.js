'use strict';
module.exports = (sequelize, DataTypes) => {
  const OddEven40 = sequelize.define('OddEven40', {    
    
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
    tableName: "oddEven40"
});
OddEven40.associate = function(models) {
    // associations can be defined here
  };

OddEven40.add = function(blocknumber,blockhash,result){
  return OddEven40.findOrCreate({where:{blocknumber},defaults:{blockhash,blocknumber,result}});
} 
  return OddEven40;
};
