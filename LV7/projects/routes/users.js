/* 
This is a basic routing module in Node.js using the Express web framework.
It exports a router object that handles HTTP GET requests made to the root
of the application ("/"). When such a request is received, the server responds
with a simple message "respond with a resource".
*/

var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
    res.send('respond with a resource');
});

module.exports = router;