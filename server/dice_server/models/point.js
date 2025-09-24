'use strict';
module.exports = (sequelize, DataTypes) => {
  const Point = sequelize.define('Point', {    
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
        toName:{
            type:DataTypes.STRING,
            field:"toName",
            allowNull:false,
        },
        bid:{
            type:DataTypes.BIGINT,
            allowNull:false,
            defaultValue:0,
        },
        type:{
            type:DataTypes.STRING(128),            
            allowNull:false,
            defaultValue:'game'
        },
        game:{
            type:DataTypes.STRING(128),            
            allowNull:false,
        },
        amount:{
            type:DataTypes.DOUBLE,
            defaultValue:0,
            allowNull:false,
        },
        odds:{
          type:DataTypes.DOUBLE,
          defaultValue:0,
          allowNull:false,
        },
        result_odds:{
            type:DataTypes.DOUBLE,
            defaultValue:0,
            allowNull:false,
          },
        previous:{
          type:DataTypes.DOUBLE,
          defaultValue:0,
          allowNull:false,
        },
        request:{
            type:DataTypes.DOUBLE,
            defaultValue:0,
            allowNull:false,
        },
        result:{
            type:DataTypes.DOUBLE,
            defaultValue:0,
            allowNull:false,
          },              
  }, {
    underscored: true,
    freezeTableName: true,
    tableName: "points"
});
Point.associate = function(models) {
    // associations can be defined here
  };
  
  return Point;
};
