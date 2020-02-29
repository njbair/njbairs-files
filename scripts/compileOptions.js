require('dotenv').config();

const fs = require('fs');
const JSON5 = require('json5');
const objectAssignDeep = require('object-assign-deep');

const paths = {
    defaultOptions: "public/_h5ai/private/conf/options.json",
    distOptions: "options.json5"
};

const envOptions = {
    passhash: process.env.PASSHASH,
};

fs.readFile(paths.defaultOptions, 'utf8', function(err, contents) {
    if (err) {
        console.log("error: ", err);
        return;
    }
    const defaultOptions = JSON5.parse(contents);

    fs.readFile(paths.distOptions, 'utf8', (err, contents) => {
        if (err) {
            console.log("error: ", err);
            return;
        }
        const distOptions = JSON5.parse(contents);
        const finalOptions = objectAssignDeep(defaultOptions, distOptions, envOptions);
        const output = JSON.stringify(finalOptions, null, 4);

        process.stdout.write(output);
    });
});