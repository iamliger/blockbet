'use strict';
module.exports = (sequelize, DataTypes) => {
  const UnderOver = sequelize.define('UnderOver', {    
    
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
    tableName: "underOver"
});
UnderOver.associate = function(models) {
   
  };

UnderOver.add = function(blocknumber,blockhash,result){
  return UnderOver.findOrCreate({where:{blocknumber},defaults:{blockhash,blocknumber,result}});
} 
  return UnderOver;
};
