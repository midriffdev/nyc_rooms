<?php
$get_file_name = $_GET['file'];
header("Content-Type: application/octet-stream");
$file_url = get_stylesheet_directory_uri() . '/documents/Application_form.docx';
DownloadAnything($file_url, $get_file_name.'.docx','',false);
?>