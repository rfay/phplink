<?php

print "This script demonstrates behavior of links\n";

$realfiles = ["targetfile.txt", "targetdir/index.html"];

print "Realfiles:\n";

foreach ($realfiles as $path) {
    printFilenameAndContents($path);
}


$linkedfiles = ["targetfile.txt.symlink_created_on_macos", "targetdir_index.html.symlink_created_on_macos"];

print "Symlinks:\n";

foreach ($linkedfiles as $path) {
    print "   $path: '" . getFileContents($path) . "'\n";
}


print "Symlink contents:\n";

foreach ($linkedfiles as $path) {
    print "   $path: '" . getLinkContents($path) . "'\n";
}

function printFilenameAndContents($path) {
    print "   $path: '" . getFileContents($path) . "'\n";
}

function getFileContents($path) {
    $contents = "";
    if ($fh = fopen($path, 'r')) {
        while (!feof($fh)) {
            $line = fgets($fh);
            $contents = "$contents" . $line;
        }
        fclose($fh);
    }
    return $contents;
}

function getLinkContents($path) {
    $linkContents = readlink($path);
    return $linkContents;
}