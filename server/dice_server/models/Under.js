'use strict';
module.exports = (sequelize, DataTypes) => {
  const Under = sequelize.define('Under', {    
    
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
    tableName: "under"
});
Under.associate = function(models) {
    // associations can be defined here
  };

  Under.add = function(blocknumber,blockhash,result){
    return Under.findOrCreate({where:{blocknumber},defaults:{blockhash,blocknumber,result}});
  } 
  
  return Under;
};
