module.exports = {"context":"/home/local/PASAIA/iibarguren/dev/www/ordezkatu","entry":{"jsApp":"./assets/js/app.js","jsSearch":"./assets/js/search.js","jsEmployee":"./assets/js/employee.js","jsVueApp":"./assets/js/vue/calling/app.js","jsVueAppAddEmployee":"./assets/js/vue/eskeintza/appAddEmployee.js","jsDatepicker":"./assets/js/datepicker.js","cssGlobal":"./assets/css/global.scss","_tmp_copy":"/tmp/tmp-9250DhF31GJEZQ4Y.tmp"},"mode":"development","output":{"path":"/home/local/PASAIA/iibarguren/dev/www/ordezkatu/public/build","filename":"[name].js","publicPath":"/build/","pathinfo":true},"module":{"rules":[{"parser":{"amd":false}},{"test":{},"exclude":{},"use":[{"loader":"babel-loader","options":{"cacheDirectory":true,"sourceType":"unambiguous","presets":[["@babel/preset-env",{"modules":false,"targets":{},"useBuiltIns":"usage","corejs":3}]],"plugins":["@babel/plugin-syntax-dynamic-import"]}}]},{"resolve":{"mainFields":["style","main"],"extensions":[".css"]},"test":{},"oneOf":[{"resourceQuery":{},"use":["/home/local/PASAIA/iibarguren/dev/www/ordezkatu/node_modules/mini-css-extract-plugin/dist/loader.js",{"loader":"css-loader","options":{"sourceMap":true,"importLoaders":0,"modules":true,"localIdentName":"[local]_[hash:base64:5]"}}]},{"use":["/home/local/PASAIA/iibarguren/dev/www/ordezkatu/node_modules/mini-css-extract-plugin/dist/loader.js",{"loader":"css-loader","options":{"sourceMap":true,"importLoaders":0,"modules":false,"localIdentName":"[local]_[hash:base64:5]"}}]}]},{"test":{},"loader":"file-loader","options":{"name":"images/[name].[hash:8].[ext]","publicPath":"/build/"}},{"test":{},"loader":"file-loader","options":{"name":"fonts/[name].[hash:8].[ext]","publicPath":"/build/"}},{"resolve":{"mainFields":["sass","style","main"],"extensions":[".scss",".sass",".css"]},"test":{},"oneOf":[{"resourceQuery":{},"use":["/home/local/PASAIA/iibarguren/dev/www/ordezkatu/node_modules/mini-css-extract-plugin/dist/loader.js",{"loader":"css-loader","options":{"sourceMap":true,"importLoaders":0,"modules":true,"localIdentName":"[local]_[hash:base64:5]"}},{"loader":"resolve-url-loader","options":{"sourceMap":true}},{"loader":"sass-loader","options":{"sourceMap":true,"outputStyle":"expanded"}}]},{"use":["/home/local/PASAIA/iibarguren/dev/www/ordezkatu/node_modules/mini-css-extract-plugin/dist/loader.js",{"loader":"css-loader","options":{"sourceMap":true,"importLoaders":0,"modules":false,"localIdentName":"[local]_[hash:base64:5]"}},{"loader":"resolve-url-loader","options":{"sourceMap":true}},{"loader":"sass-loader","options":{"sourceMap":true,"outputStyle":"expanded"}}]}]},{"test":{},"use":[{"loader":"vue-loader","options":{}}]}]},"plugins":[{"options":{"filename":"[name].css","chunkFilename":"[name].css"}},{"entriesToDelete":["cssGlobal","_tmp_copy"]},{"opts":{"publicPath":null,"basePath":"build/","fileName":"manifest.json","transformExtensions":{},"writeToFileEmit":true,"seed":{},"map":null,"generate":null,"sort":null}},{"definitions":{"$":"jquery","jQuery":"jquery","window.jQuery":"jquery"}},{"paths":["**/*"],"options":{"root":"/home/local/PASAIA/iibarguren/dev/www/ordezkatu/public/build","verbose":false,"allowExternal":false,"dry":false}},{"definitions":{"process.env":{"NODE_ENV":"\"development\""}}},{"options":{"title":"Webpack Encore"},"lastBuildSucceeded":false,"isFirstBuild":true},{},{"compilationSuccessInfo":{"messages":[]},"shouldClearConsole":false,"formatters":[null,null,null,null,null,null],"transformers":[null,null,null,null,null,null],"previousEndTimes":{}},{"outputPath":"public/build","friendlyErrorsPlugin":{"compilationSuccessInfo":{"messages":[]},"shouldClearConsole":false,"formatters":[null,null,null,null,null,null],"transformers":[null,null,null,null,null,null],"previousEndTimes":{}}},{"options":{"filename":"entrypoints.json","prettyPrint":false,"update":false,"fullPath":true,"manifestFirst":true,"useCompilerPath":false,"fileTypes":["js","css"],"includeAllFileTypes":true,"keepInMemory":false,"integrity":false,"path":"/home/local/PASAIA/iibarguren/dev/www/ordezkatu/public/build","entrypoints":true}}],"optimization":{"namedModules":true,"chunkIds":"named","runtimeChunk":"single","splitChunks":{"chunks":"all"}},"watchOptions":{"ignored":{}},"devtool":"inline-source-map","performance":{"hints":false},"stats":{"hash":false,"version":false,"timings":false,"assets":false,"chunks":false,"maxModules":0,"modules":false,"reasons":false,"children":false,"source":false,"errors":false,"errorDetails":false,"warnings":false,"publicPath":false,"builtAt":false},"resolve":{"extensions":[".wasm",".mjs",".js",".json",".jsx",".vue",".ts",".tsx"],"alias":{"vue$":"vue/dist/vue.esm.js"}},"externals":[]}