# Twig WordPress

## Requirements

| Prerequisite    | How to check | How to install
| --------------- | ------------ | ------------- |
| NVM 8.15.1  | `nvm list`    | [NVM](https://github.com/coreybutler/nvm-windows), `nvm install 8.15.1`, this will handle your NODE and NPM packages for you! |
| PHP >= 7.x.x    | `php -v`     | [php.net](http://php.net/manual/en/install.php), if not using a local environment tool|
| MySql >= 5.6.x  |  ---   | --- |

## Features

* [Timber](https://www.upstatement.com/timber/) a faster, easier and more powerful way to build themes, it basically makes sure you can use all the WordPress magic with TWIG 
* [Twig, templating engine](https://twig.symfony.com/),
* [Timber, adds Twig to WordPress!](https://timber.github.io/docs/)
* [Webpack 4](https://webpack.js.org/), bundling assets
* [Boostrap 4](https://getbootstrap.com/), front-end framework

### Additional Features that are availble if needed!
* [Axios](https://github.com/axios/axios), Promise based HTTP client for the browser and node.js
* [AOS Scroll](https://github.com/michalsnik/aos),  Animate on Scroll

## Documentation

### Change your proxy url
* build > webpack.config.js > BrowserSyncPlugin > update to use your currently proxy URL for your local install 

### From the command line
* cd into theme directory
    * npm: `npm install`
        * will install all your npm packages
    * watch: `npm run watch`
        * builds dev assets to public directory and watches assets for changes!
        * sets up browsersync
    * dev: `npm run dev`
        * builds dev assets to public directory
    * prod: `npm run prod`
        * builds production assets to public directory

### Assets Folder
* scripts / css / fonts / images will go inside the /assets directory
    * You'll see multple folders inside of /assets containing said files
* JS is used along side Dom - Based routing, 
    * You can see this inside of /assets/scripts/pages.js
