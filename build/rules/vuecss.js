const config = require('../app.config')

module.exports = {
    include: config.paths.scripts,
    exclude: config.paths.sass,
    test: /\.scss$/,
    use: [
        {
            loader: 'vue-style-loader'},
        {
            loader:'css-loader'
        },
        {
            loader: 'sass-loader',
            options: {
                sourceMap: true,
                includePaths: [
                    require('path').resolve(__dirname, 'node_modules')
                ]
            }
        }
    ]
}
