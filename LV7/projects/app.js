/* 
This is a Node.js app that uses the Express framework to handle HTTP requests.

The code starts by requiring various Node.js modules such as 
http-errors, express, path, cookie-parser, logger, multer, and body-parser
that are used to implement different features of the web application. It also requires certain files such as 
db.js, user.js, and projects.js from the models directory, and routes files such as index.js, register.js
, login.js, logout.js, and projects.js from the routes directory.

An instance of the Express application is created and assigned to a variable named app. The methodOverride
module is used to allow HTTP methods like PUT and DELETE to be used in places where they aren't normally supported. 
The express-session middleware is used to manage user sessions, and the jade template engine is set as the view engine for rendering dynamic content.
Various middleware functions are added to handle different types of requests. The express.static middleware is used to serve static files 
such as CSS and JavaScript files. The logger middleware logs incoming requests to the console. The bodyParser.urlencoded middleware 
is used to parse incoming form data. The cookie-parser middleware is used to parse cookies. Finally, middleware functions are added to
handle different routes defined in the application.

If an incoming request cannot be matched to any of the defined routes, then the last middleware function is executed 
to handle the 404 error. If the application is running in development mode, then a custom error handler middleware function
is added to provide more detailed error information. Otherwise, a generic error handler middleware function is used.

Finally, the app object is exported so that it can be used by other modules or scripts.
*/

var createError = require('http-errors'),
  express = require('express'),
  path = require('path'),
  cookieParser = require('cookie-parser'),
  logger = require('morgan'),
  multer = require('multer'),
  bodyParser = require('body-parser');

var db = require('./models/db'),
  user = require('./models/user'),
  project = require('./models/projects');

var routes = require('./routes/index'),
  register = require('./routes/register'),
  login = require('./routes/login'),
  logout = require('./routes/logout'),
  projects = require('./routes/projects');

var session = require('express-session');
var methodOverride = require('method-override');

var app = express();

app.use(methodOverride('X-HTTP-Method-Override'));
app.use(session({
  secret: '98b347ae0606d2d1bc2c4e19fe3f3db3',
  resave: false,
  saveUninitialized: true,
  cookie: {
    secure: false
  }
}))

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'jade');

app.use('/css', express.static(__dirname + '/node_modules/bootstrap/dist/css'));
app.use(logger('dev'));
app.use(express.json());
app.use(bodyParser.urlencoded({
  extended: true
}));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', routes);
app.use('/projects', projects);
app.use('/register', register);
app.use('/login', login);
app.use('/logout', logout);

app.use(function (req, res, next) {
  var err = new Error('Not Found');
  console.log("poruka");
  err.status = 404;
  next(err);
});

if (app.get('env') === 'development') {
  app.use(function (err, req, res, next) {
    res.status(err.status || 500);
    res.render('error', {
      message: err.message,
      error: err
    });
  });
}

app.use(function (err, req, res, next) {
  res.status(err.status || 500);
  res.render('error', {
    message: err.message,
    error: {}
  });
});

module.exports = app;