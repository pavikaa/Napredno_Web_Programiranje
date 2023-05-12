/* 
This code exports an Express router that defines a single route for the /URL. 
When an HTTP GET request is made to this endpoint, the user's session is destroyed using 
req.session.destroy(), and then they are redirected to the login page at /login using 
res.redirect('/login').
*/

var express = require('express'),
    router = express.Router();

router.route('/')
    .get(function (req, res, next) {
        req.session.destroy();
        res.redirect('/login');
    });

module.exports = router;