<?php

namespace App\Traits;

/**
 * Trait StorageTrait
 * @package App\Traits
 */
trait StorageTrait
{
    /**
     * @param $path
     * @param $filename
     * @return string
     */
    public function getStorageImages($path, $filename)
    {
        return asset("storage/app/public/" . $path . '/' . $filename);
    }
}