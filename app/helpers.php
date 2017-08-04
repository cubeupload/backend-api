<?php

/**
 * Because Lumen has no config_path function, we need to add this function
 * to make JWT Auth works.
 */
if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath().'/config'.($path ? '/'.$path : $path);
    }
}

/**
 * Because Lumen has no storage_path function, we need to add this function
 * to make caching configuration works.
 */
if (!function_exists('storage_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function storage_path($path = '')
    {
        return app()->basePath().'/storage'.($path ? '/'.$path : $path);
    }
}

/**
 * So that we don't have a lot of files/images in one folder, this function
 * is used to convert a filename, such as myimage.png, into m/y/i/myimage.png.
 *
 * Many Amazon S3 browsers will treat these as folders which is useful if we
 * manually browse the filestore.
*/
if (!function_exists('split_to_path'))
{
    /**
     * Split a given filename's first 3 characters to directories.
     *
     * @param string $filename
     * 
     * @return string
     */
    function split_to_path($filename)
    {
        $f = str_split($filename, 1);
        return $f[0] . '/' . $f[1] . '/' . $f[2] . '/' . $filename;
    }
}
