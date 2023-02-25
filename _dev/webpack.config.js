const webpack = require('webpack');
const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');


const config = {
    entry: {
        'cookieconsent-init': './src/index.js',
        'gtag-consent-init': './src/gtag-consent-init.js',
    },
    output: {
        path: path.resolve(__dirname, '../views/js'),
        filename: '[name].js'
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
                        // options: {
                        //     sassOptions: {
                        //         indentedSyntax: true
                        //     }
                        // }
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
        new MiniCssExtractPlugin({ filename: path.join('..', 'css', '[name].css') }),
        // new CleanWebpackPlugin(),
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

module.exports = config;