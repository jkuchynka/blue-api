<?php

namespace App\Files\Tests\Unit;

use App\Files\Factories\ImageFactory;
use App\Files\Models\File;
use Base\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Storage;

class ImageFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeFromUploadedFileStoresToDisk()
    {
        $this->asUserByRole('admin');
        $factory = new ImageFactory;
        $factory
            ->setDisk('foo')
            ->setPath('qux');
        Storage::fake('foo');
        $file = UploadedFile::fake()->image('bar.jpg');

        $image = $factory->makeFromUploadedFile($file);

        Storage::disk('foo')->assertExists($image->filename);
    }

    public function testMakeFromUploadedFileCreatesFileModel()
    {
        $this->asUserByRole('admin');
        $factory = new ImageFactory;
        $factory
            ->setDisk('foo')
            ->setPath('qux');

        Storage::fake('foo');
        $file = UploadedFile::fake()->image('bar.jpg');

        $image = $factory->makeFromUploadedFile($file);

        $this->assertInstanceOf(File::class, $image);
        $this->assertEquals($this->user->id, $image->user_id);
        $this->assertEquals($file->getClientOriginalName(), $image->name);
        $this->assertEquals('foo', $image->disk);
        $this->assertEquals($file->getClientMimeType(), $image->mime);
    }
}
