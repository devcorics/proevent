const path = require("path");

module.exports = {
  mode: "development", // change to 'production' for final build
  entry: "./src/index.js", // main JS file
  output: {
    filename: "main.js", // output filename
    path: path.resolve(__dirname, "dist"), // output folder
  },
  devtool: "source-map", // optional, makes debugging easier
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader", // transpile modern JS
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
    ],
  },
  watch: true, // automatically rebuild when files change
};
