<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filename = isset($_GET['filename']) ? $_GET['filename'] : '';

    if ($filename !== '') {
        $imagePath = 'images/' . $filename;

        if (file_exists($imagePath)) {
            $mime = mime_content_type($imagePath);
            header('Content-Type: ' . $mime); 
            header('Content-Length: ' . filesize($imagePath));

            readfile($imagePath);
            exit;
        } else {
            header('HTTP/1.0 404 Not Found');
            echo 'Image not found';
            exit;
        }
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad Request';
        exit;
    }
} else {
    header('HTTP/1.0 405 Method Not Allowed');
    echo 'Method Not Allowed';
    exit;
}

?>

