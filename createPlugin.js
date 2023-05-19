const shell = require('shelljs');
const fs = require('fs');
const archiver = require('archiver');

// If 'blokki.zip' exists, delete it
if (fs.existsSync('blokki.zip')) {
    fs.unlinkSync('blokki.zip');
}

// Move 'createPlugin.js' to a temporary location
shell.mv('createPlugin.js', '../createPlugin.js');

// Create a directory if it doesn't exist already
if (!fs.existsSync('blokki')) {
    fs.mkdirSync('blokki');
}

// Copy all files and folders to 'blokki', except the 'blokki', 'node_modules', and '.git' folders
shell.exec('robocopy . blokki /e /xd blokki node_modules .git');

// Move 'createPlugin.js' back to its original location
shell.mv('../createPlugin.js', './createPlugin.js');

// Create a file to stream archive data to.
const output = fs.createWriteStream('./blokki.zip');
const archive = archiver('zip', {
    zlib: { level: 9 } // Sets the compression level.
});

// Pipe archive data to the file
archive.pipe(output);

// Append files from a directory
archive.directory('blokki/', 'blokki');

// Listen for all archive data to be written
output.on('close', () => {
    console.log(archive.pointer() + ' total bytes');
    console.log('Archiver has been finalized and the output file descriptor has closed.');

    // Remove 'blokki' directory
    fs.rmSync('blokki', { recursive: true, force: true });
});

// Finalize the archive (the archive is created and can no longer be modified)
archive.finalize();
