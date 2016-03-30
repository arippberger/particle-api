module.exports = {
    context: __dirname + "/assets/js/src",
    entry: "./particle-api.js",

    output: {
        filename: "particle-api.js",
        path: __dirname + "/assets/js/dist"
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loaders: ["babel-loader"],
            }
        ],
    },
};