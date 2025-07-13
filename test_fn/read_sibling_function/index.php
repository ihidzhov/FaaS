<?php

function read_sibling_function()
{
    /**
     * This function attempts to scan the parent directory ('fn') to discover
     * the directories of other functions. The open_basedir sandbox restriction
     * should prevent this from succeeding, causing scandir() to fail and return false.
     */
    $parent_dir = __DIR__ . '/../';
    $files = @scandir($parent_dir);

    if ($files === false) {
        echo "SUCCESS: The sandbox is working. Could not list sibling function directories.";
    } else {
        echo "FAILURE: The sandbox is broken! The 'fn' directory was listed: ";
        print_r($files);
    }
}
