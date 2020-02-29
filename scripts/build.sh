#!/bin/bash

OPTIONS_PATH=public/_h5ai/private/conf

# build and install h5ai
pushd node_modules/h5ai
npm install
npm run build
popd
rm -rf public/_h5ai
mv node_modules/h5ai/build/_h5ai public

# compile options
node scripts/compileOptions.js > $OPTIONS_PATH/options.json.new
mv $OPTIONS_PATH/options.json $OPTIONS_PATH/options.json.old
mv $OPTIONS_PATH/options.json.new $OPTIONS_PATH/options.json