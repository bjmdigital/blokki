const shell = require('shelljs');
const fs = require('fs');
const archiver = require('archiver');

// --- Start of Script ---

const pluginName = 'blokki';
const outputZip = 'blokki.zip';
const tempBuildDir = 'blokki';

// Define directories and files to exclude from the zip
const exclude = [
    tempBuildDir,
    'node_modules',
    '.git',
    '.github',
    '.idea',
    'createPlugin.js',
    '.npmignore',
    '.editorconfig',
    '.gitignore',
];

// 1. Clean up from previous runs
if (shell.test('-e', outputZip)) {
    shell.rm(outputZip);
}
if (shell.test('-e', tempBuildDir)) {
    shell.rm('-rf', tempBuildDir);
}

// 2. Create the temporary directory
shell.mkdir('-p', tempBuildDir);

// 3. Get all files/folders in the root and copy them, respecting the exclude list.
// This is the cross-platform replacement for your robocopy command.
console.log('Copying plugin files...');
const allFiles = shell.ls('-A', '.'); // List all files, including hidden ones
allFiles.forEach(file => {
    if (exclude.indexOf(file) === -1) {
        shell.cp('-R', file, tempBuildDir);
    }
});

// 4. Create the zip file
console.log(`Creating ${outputZip}...`);
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
// The second argument to archive.directory is the path inside the zip.
// We want the contents of our temp folder to be inside a 'blokki' folder in the zip.
archive.directory(tempBuildDir, pluginName);
archive.finalize();