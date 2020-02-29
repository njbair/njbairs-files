#!/bin/bash

pushd node_modules/h5ai
npm install
npm run build
popd
rm -rf public/_h5ai
mv node_modules/h5ai/build/_h5ai public