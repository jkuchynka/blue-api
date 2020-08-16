<?php

namespace App\Files\Factories;

use App\Files\Models\File;
use App\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Storage;
use Intervention\Image\ImageManager;

class ImageFactory
{
    protected $disk = null;

    protected $manager;

    protected $maxWidth = 1080;

    protected $path = '';

    protected $user;

    /**
     * ImageFactory constructor.
     */
    public function __construct()
    {
        $this->manager = new ImageManager([
            'driver' => 'imagick'
        ]);
    }

    /**
     * Set disk
     *
     * @param string $disk
     * @return $this
     */
    public function setDisk(string $disk)
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * Set max width of image
     *
     * @param int $width
     * @return $this
     */
    public function setMaxWidth(int $width)
    {
        $this->maxWidth = $width;
        return $this;
    }

    /**
     * Set destination path to save image
     *
     * @param string $path
     * @return $this
     */
    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Set the user that owns this image
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Make and convert the image
     *
     * @param UploadedFile $source
     * @return Image
     */
    protected function makeImage($source)
    {
        $image = $this->manager->make($source);
        // Resize to width of maxWidth, maintain aspect ratio,
        // and prevent up-sizing
        $image->resize(null, $this->maxWidth, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $image;
    }

    /**
     * Save image to disk and create the image File model
     *
     * @param UploadedFile $file
     * @return File
     */
    public function makeFromUploadedFile(UploadedFile $file)
    {
        $image = $this->makeImage($file);

        // Get a unique filename for this file
        $filename = $file->hashname($this->path);

        // Store image to disk
        Storage::disk($this->disk)->put($filename, (string) $image->encode());

        // Save image as file model
        // Use set user, or currently authenticated user
        // @todo: Throw exception if unable to get user? Or figure out a way to handle
        // anon uploads
        return File::create([
            'user_id' => $this->user ? $this->user->id : \Auth::user()->id,
            'name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'disk' => $this->disk,
            'mime' => $file->getClientMimeType()
        ]);
    }

}
