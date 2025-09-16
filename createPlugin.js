// createPlugin.js

const fs = require('fs');
const path = require('path');
const archiver = require('archiver');
const shell = require('shelljs'); // Use shelljs for cross-platform commands

const pluginName = 'blokki';
const outputZip = path.join(__dirname, `${pluginName}.zip`);
const tempBuildDir = path.join(__dirname, pluginName); // Temp folder for building the zip

// Define exactly what should be in the final plugin zip file
const filesToInclude = [
    'admin',
    'build',
    'includes',
    'languages',
    'public',
    'schema',
    'templates',
    'vendor',
    'blokki.php',
    'CHANGELOG.md',
    'LICENSE.txt',
    'readme.txt',
];

// --- Start of Script ---

// 1. Clean up from previous runs
if (fs.existsSync(outputZip)) {
    shell.rm(outputZip);
}
if (fs.existsSync(tempBuildDir)) {
    shell.rm('-rf', tempBuildDir);
}

// 2. Create the temporary directory for the zip contents
shell.mkdir('-p', tempBuildDir);

// 3. Copy only the necessary files and directories into the temp directory
console.log('Copying plugin files...');
filesToInclude.forEach(fileOrDir => {
    if (shell.test('-e', fileOrDir)) { // Check if file or directory exists
        shell.cp('-R', fileOrDir, tempBuildDir);
    } else {
        console.warn(`Warning: '${fileOrDir}' not found. Skipping.`);
    }
});

// 4. Create the zip file from the contents of the temporary directory
console.log(`Creating ${pluginName}.zip...`);
const output = fs.createWriteStream(outputZip);
const archive = archiver('zip', { zlib: { level: 9 } });

output.on('close', function () {
    console.log(archive.pointer() + ' total bytes');
    console.log('Zip file created successfully.');
    
    // 5. Clean up the temporary directory
    shell.rm('-rf', tempBuildDir);
    console.log('Temporary build directory removed.');
});

archive.on('error', function(err){
    throw err;
});

archive.pipe(output);
archive.directory(tempBuildDir, false); // Add files from temp dir directly into zip root
archive.finalize();