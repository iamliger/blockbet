'use strict';
module.exports = (sequelize, DataTypes) => {
  const UnderOver40 = sequelize.define('UnderOver40', {    
    
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
    tableName: "underOver40"
});
UnderOver40.associate = function(models) {
   
  };

UnderOver40.add = function(blocknumber,blockhash,result){
  return UnderOver40.findOrCreate({where:{blocknumber},defaults:{blockhash,blocknumber,result}});
} 
  return UnderOver40;
};
