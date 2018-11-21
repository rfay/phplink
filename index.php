<?php

print "This script demonstrates behavior of links\n";


$linkedfiles = [
    // 3 symlinks to file in same directory
    "targetfile.txt.symlink_created_on_macos",
    "targetfile.txt.symlink_created_in_container_on_windows",
    "targetfile.txt.symlink_created_on_msys_winsymlinks",
    // 3 symlinks to a *file* in a symlinked directory
    "targetdir_index.html.symlink_created_on_msys_winsymlinks",
    "targetdir_index.html.symlink_created_on_macos",
    "targetdir_index.html.symlink_created_in_container_on_windows",
    "tmp/targetdir_index.html.symlink_created_by_php",
    ];

$linkedDirs = [
    "targetdir.linked_on_macos",
    "tmp/targetdir.symlink_created_by_php",
];


$result = symlink("../targetdir/index.html", "tmp/targetdir_index.html.symlink_created_by_php");
if (!$result) {
    print "ERROR: symlink createion failed\n";
}
$result = symlink("../targetdir", "tmp/targetdir.symlink_created_by_php");

print "\nSymlinks to files (including via symlinked directories):\n";

foreach ($linkedfiles as $path) {
    print "   $path: '" . getFileContents($path) . "'\n";
}


print "\nSymlink contents (file symlinks):\n";

foreach ($linkedfiles as $path) {
    print "   $path: '" . getLinkContents($path) . "'\n";
}

print "\nSymlink contents (directory contents)\n";
foreach ($linkedDirs as $path) {
    print "   $path: '" . getLinkContents($path) . "'\n";
}




/* ************ Utility functions *********** */
function printFilenameAndContents($path) {
    print "   $path: '" . getFileContents($path) . "'\n";
}

function getFileContents($path) {
    $contents = "";
    if (!is_link($path)) {
        $contents = $contents . "ERROR: $path is not a link\n";
    }
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

function printLinkContents($path) {
    $contents = getLinkContents($path);
    print "    $path: " . $contents . "\n";
}