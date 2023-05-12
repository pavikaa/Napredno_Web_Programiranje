/*
This code is creating a schema for a "Project" object using the Mongoose 
library, which is an Object Data Modeling (ODM) library for MongoDB and 
Node.js. The schema defines the structure of the object with various
 properties such as name, description, price, members, finishedWorks, 
 start time, end time, archived status, and author.

The mongoose.Schema constructor is used to define the schema, 
and it takes an object as an argument where each key represents a 
field in the document and its value represents the data type for that field. 
Once the schema is defined, mongoose.model method is used to create a model 
named "Project" based on the schema. This model can be used to perform CRUD 
(Create, Read, Update, Delete) operations on the MongoDB database collection 
associated with it.
Note that this code only defines the schema and model; it does not connect to
 any MongoDB database or create any documents in the database.
*/

var mongoose = require('mongoose');
var projectSchema = new mongoose.Schema({
    name: String,
    description: String,
    price: String,
    members: String,
    finishedWorks: String,
    startTime: String,
    endTime: String,
    archived: Boolean,
    author: String,
});
mongoose.model('Project', projectSchema);