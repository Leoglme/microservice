const express = require('express');
const bodyParser = require('body-parser');
const swaggerJsDoc = require('swagger-jsdoc');
const cors = require('cors')
const swaggerUI = require('swagger-ui-express');
require('dotenv').config();

let port = process.env.PORT || 5555;
let host = process.env.HOST || 'http://localhost';

// init app
const app = express() ;

// init swagger (open api ui for api docs)
const {swaggerOptions} = require("./swagger/swagger.options");
const swaggerDocs = swaggerJsDoc(swaggerOptions);

app.get('/', function(req, res) {
    res.redirect('/docs');
});

app.use('/docs', swaggerUI.serve, swaggerUI.setup(swaggerDocs, {
    explorer: true,
    customCss: '.opblock-summary-description {user-select: none;} .opblock-summary-control:focus {outline: none !important;}'
}));

// connect MongoDB with mongoose
const database = require('./database');


// Utilisation de body parser
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended:false}));

// Routes
let discussion = require('./routes/discussion.route')
app.use('/discussion', discussion);

// Start App
app.use(cors());
app.listen(port, () => {
    console.log('Server running on : ' + port);
})
