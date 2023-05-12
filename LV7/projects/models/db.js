/*
This code is using the JavaScript library Mongoose to connect to a
 MongoDB server running on the local machine at the default port of 
 27017, and selecting the "projects" database. This connection allows 
 for further interaction with the database through Mongoose's object
 modeling capabilities.
*/

var mongoose = require('mongoose');
mongoose.connect('mongodb://127.0.0.1:27017/projects');