const webpack = require('webpack');
const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const config = {
    entry: {
        'cookieconsent-init': './src/index.js',
        'gtag-consent-init': './src/gtag-consent-init.js',
    },
    output: {
        path: path.resolve(__dirname, '../views/js'),
        filename: '[name].min.js',
        clean: true
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader'
                ]
            },
            {
                test: /\.scss|sass$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'sass-loader',
                    }
                ]
            }
        ]
    },
    externals: {    
        prestashop: 'prestashop',
        $: '$',
        jquery: 'jQuery',
    },
    plugins: [
        new MiniCssExtractPlugin({ filename: path.join('..', 'css', '[name].css') })
    ]
};

module.exports = (env, argv) => {
    if (argv.mode === 'development') {
        config.devtool = 'eval-source-map';
        config.plugins = [
            new BundleAnalyzerPlugin({
                analyzerMode: 'static',
                openAnalyzer: false,
            }),
        ]
    }

    if (argv.mode === 'production') {
        config.optimization = {
            minimize: true,
            chunkIds: 'deterministic',
            removeEmptyChunks: true,
            splitChunks: {
                cacheGroups: {
                    defaultVendors: {
                        name: 'vendors',
                        test: path.resolve('node_modules'),
                        reuseExistingChunk: true
                    }
                }
            }
        }
    }

    return config;
}

//module.exports = config;