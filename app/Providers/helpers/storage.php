<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('storage_disk')) {
    /**
     * Return storage disk
     *
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    function storage_disk($disk = null)
    {
        return Storage::disk($disk ?? 'public');
    }
}

if (!function_exists('storage_disk_url')) {
    /**
     * Return storage disk url
     *
     * @return string
     */
    function storage_disk_url($path, $disk = null)
    {
        return $path
            ? storage_disk($disk)->url($path)
            : null;
    }
}
