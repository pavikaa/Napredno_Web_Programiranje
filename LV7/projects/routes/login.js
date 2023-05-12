/*
This code defines a router object for user authentication routes, including a GET route for 
rendering a login form and a POST route for handling login attempts. It uses the Express framework, 
Mongoose for database operations with MongoDB, body-parser for parsing request bodies, and 
method-override for allowing HTTP methods other than GET and POST to be used in forms.

The GET "/login" route renders a login page with an empty email and password field.

The POST "/login" route retrieves the email and password from the request body, 
queries the "User" model in MongoDB for a matching user, and either sets a session ID for 
the user and redirects to the home page or returns an error message if the user is not found.

If there is an error during the query, it logs the error and sends an HTTP 500 error response.
*/
var express = require('express'),
    router = express.Router(),
    mongoose = require('mongoose'),
    bodyParser = require('body-parser'),
    methodOverride = require('method-override');

router.use(bodyParser.urlencoded({
    extended: true
}))
router.use(methodOverride(function (req, res) {
    if (req.body && typeof req.body === 'object' && '_method' in req.body) {
        var method = req.body._method
        delete req.body._method
        return method
    }
}))

router.route('/')
    .get(function (req, res, next) {
        const data = {
            "email": "",
            "password": ""
        }

        res.render('login/index', {
            "data": data,
            "title": "Login",
        });
    })
    .post(async function (req, res) {
        const email = req.body.email;
        const password = req.body.password;

        const data = {
            "email": email,
            "password": password
        }

        try {
            const user = await mongoose.model('User').findOne({
                email: email,
                password: password
            });
            if (user) {
                req.session.uid = user.id;
                res.redirect('/');
            } else {
                const error = "Invalid credentials. Try again."
                res.format({
                    html: function () {
                        res.render('login/index', {
                            "error": error,
                            "data": data,
                            "title": "Login",
                        });
                    }
                });
            }
        } catch (err) {
            console.error(err);
            res.sendStatus(500);
        }
    });

module.exports = router;