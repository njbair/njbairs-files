<?php

function get_file_listing($glob)
{
    $files = glob('*');
    $files = preg_grep($glob, $files);

    return $files;
}

function normalize_string($string, $glob)
{
    try
    {
        $string = preg_replace($glob, '', $string);
        $string = preg_replace('/[\s-_]+/', '', $string);
        $string = strtolower($string);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }

    return $string;
}

function find_file($query, $glob)
{
    $files = get_file_listing($glob);

    foreach ($files as $file)
    {
        $f = normalize_string($file, $glob);
        $q = normalize_string($query, $glob);

        if (strpos($f, $q) !== FALSE)
        {
            return $file;
        }
    }

    return FALSE;
}

if (isset($_GET['q']))
{
    $glob = '/\.(gif|jpg|jpeg|png)$/i';
    $max_age = 31536000; // 1 year

    $match = find_file($_GET['q'], $glob);

    if ($match)
    {
        $mime_type = image_type_to_mime_type(exif_imagetype($match));

        header("Content-Type: " . $mime_type);
        header("Content-Disposition: inline; filename=\"$match\"");
        header("Cache-Control: public, max-age=$max_age");
        header("Expires: " . date('r', time() + $max_age));
        readfile($match);
    }
    else
    {
        die('File not found.');
    }
}
else
{
    die('No query specified.');
}
