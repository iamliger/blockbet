'use strict';
module.exports = (sequelize, DataTypes) => {
  const Under40 = sequelize.define('Under40', {    
    
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
    tableName: "under40"
});
Under40.associate = function(models) {
    // associations can be defined here
  };

  Under40.add = function(blocknumber,blockhash,result){
    return Under40.findOrCreate({where:{blocknumber},defaults:{blockhash,blocknumber,result}});
  } 
  
  return Under40;
};
