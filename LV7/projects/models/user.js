/*
This code defines a Mongoose schema for a user object with properties 
username, email, and password. The schema is then registered as a model 
named "User" using the mongoose.model() method. This allows the application 
to interact with instances of the User model in the database using Mongoose
methods such as .find(), .create(), .update(), etc.
 */

var mongoose = require('mongoose');
var userSchema = new mongoose.Schema({
    username: String,
    email: String,
    password: String,
});
mongoose.model('User', userSchema);