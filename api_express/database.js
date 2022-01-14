const mongoose = require('mongoose');
require('dotenv').config();
console.log("PROCESS", process.env.MONGODB_URI);



mongoose.connect(process.env.MONGODB_URI, {useNewUrlParser: true}, (e) => {
    console.log("mongoose connect... : ", e);
});
const conn = mongoose.connection;
conn.on('connected', function () {
    console.log('database is connected successfully');
});
conn.on('disconnected', function () {
    console.log('database is disconnected successfully');
})
conn.on('error', console.error.bind(console, 'connection error:'));
module.exports = conn;
