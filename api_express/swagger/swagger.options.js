let port = process.env.PORT || 5555;
let host = process.env.HOST || 'http://localhost';

// options swagger doc: https://swagger.io/specification/#infoObject
const swaggerOptions = {
    definition: {
        openapi: '3.0.0',
        info: {
            version: "1.0.0",
            title: "Microservices - discussion API",
            description: "`Express js` api made with `mongoose` for microservices chat application",
            license: {
                name: "MIT",
                url: "https://github.com/Leoglme",
            },
            contact: {
                name: "Leoglme",
                url: "https://dibodev.com",
                email: "contact@dibodev.com",
            },
            tags: [
                {
                    name: "Discussion",
                    description: "Discussion api"
                },
            ],
            servers: [
                {url: `http://${host}:${port}`, description: "Development server"},
                {url: `https://${host}:${port}`, description: "Production server"},
            ]
        },
        components: {
            securitySchemes: {
                bearerAuth: {
                    type: "http",
                    scheme: "Bearer"
                }
            }
        },
        security: [
            {
                bearerAuth: [],
            },
        ],
    },
    apis: ['./routes/*.js']
}

module.exports = {swaggerOptions}
