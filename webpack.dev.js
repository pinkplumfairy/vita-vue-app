 const merge = require('webpack-merge');
 const common = require('./webpack.common.js');
 const path = require('path');

 module.exports = merge(common, {
   mode: 'development',
   devServer: {
    historyApiFallback: true,
    noInfo: true,
    overlay: true,
    headers: {
      'Access-Control-Allow-Origin': '*'
    }
  },
  performance: {
    hints: false
  },
  devtool: '#eval-source-map'
 });