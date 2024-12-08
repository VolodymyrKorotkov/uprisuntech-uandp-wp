const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = function override(config, env) {
  const cssModuleRule = config.module.rules.find(
    (rule) => typeof rule.oneOf === 'object'
  );

  // Замініть style-loader на MiniCssExtractPlugin.loader
  cssModuleRule.oneOf.push({
    test: /\.module\.s[ac]ss$/,
    use: [
      MiniCssExtractPlugin.loader,
      {
        loader: 'css-loader',
        options: {
          modules: true,
          importLoaders: 1,
        },
      },
      'sass-loader',
    ],
  });

  // Додайте плагін MiniCssExtractPlugin для створення окремого файлу CSS
  config.plugins.push(
    new MiniCssExtractPlugin({
      filename: process.env.REACT_APP_TYPE == 'modal' ? 'application_modal.css' : 'application.css', // Вказуйте бажану назву вашого CSS файлу
    })
  );

  config.optimization.splitChunks = {
    cacheGroups: {
        default: false,
    },
  };

  config.optimization.runtimeChunk = false;

  // Змініть вихідну папку для зібраного проекту

  if(process.env.REACT_APP_TYPE == 'engineer'){
    config.output.path = path.join(__dirname, 'build_engineer');
  } else if(process.env.REACT_APP_TYPE == 'modal'){
    config.output.path = path.join(__dirname, 'build_modal');
  } else {
    config.output.path = path.join(__dirname, 'build_application');
  }

  
  config.output.filename = process.env.REACT_APP_TYPE == 'modal' ? 'application_modal.js' : 'application.js';
  // ... інші налаштування ...

  return config;
};