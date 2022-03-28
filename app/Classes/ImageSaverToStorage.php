<?php
namespace App\Classes;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageSaverToStorage
 * @package App\Classes
 */
class ImageSaverToStorage
{
    private $image, $path;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function saveImage()
    {
        $file = Storage::disk('public')->put($this->getPath(), $this->getImage(), 'public');

        $file = explode($this->getPath() . '/', $file);

        return  $file[1];
    }

    public function deleteImage()
    {
        Storage::disk('public')->delete($this->getPath() . '/'. $this->getImage());
    }
}