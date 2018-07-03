<?php
$zip = new ZipArchive;
if ($zip->open('test.zip') === TRUE) {
    $zip->addFile('file1.txt', 'newname.txt');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}
?>