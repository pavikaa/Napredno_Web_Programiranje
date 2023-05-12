/*
This code exports an Express router instance that redirects the user to the 
/projects route when they visit the root URL (/). The router.get() method 
creates a new GET route for the root URL, and the callback function passed 
to it sends a redirect response to the client's browser using res.redirect().
This means that users accessing the root URL will be automatically redirected
to the /projects page. Finally, the module.exports statement makes this 
router available for use in other parts of the application.
*/
var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
  res.redirect('/projects')
});

module.exports = router;