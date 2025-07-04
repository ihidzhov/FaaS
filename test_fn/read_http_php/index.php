<?php

function read_http_php()
{
    /**
     * This function attempts to read http.php from the project root.
     * The open_basedir sandbox restriction should prevent this from succeeding,
     * causing file_get_contents() to fail and return false.
     */
    $content = @file_get_contents(__DIR__ . '/../../../http.php');

    if ($content === false) {
        echo "SUCCESS: The sandbox is working. Could not read http.php.";
    } else {
        echo "FAILURE: The sandbox is broken! The contents of http.php were read.";
    }
}
