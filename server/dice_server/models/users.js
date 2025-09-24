'use strict';
module.exports = (sequelize, DataTypes) => {
  const User = sequelize.define('User', {    
        id:{
            type:DataTypes.BIGINT,
            primaryKey:true,
            autoIncrement:true,
            unique:true,
        },
	email:{
          type:DataTypes.STRING,
          allowNull:false,
        },  
        name:{
          type:DataTypes.STRING,
          allowNull:false,
        },
        privateKey:{
            type:DataTypes.STRING,
            field:"privateKey",
        },
        publicKey:{
            type:DataTypes.STRING,
            field:"publicKey"
        },
        store:{
          type:DataTypes.STRING,
          defaultValue:'',
          allowNull:false,
        },
        odds:{
          type:DataTypes.DOUBLE,
          defaultValue:0,
          allowNull:false,
        },
        point:{
          type:DataTypes.DOUBLE,
          defaultValue:0,
          allowNull:false,
        },
        address:DataTypes.STRING
    
  }, {
    underscored: true,
    freezeTableName: true,
    tableName: "users"
});
User.associate = function(models) {
    // associations can be defined here
  };
  
  return User;
};
