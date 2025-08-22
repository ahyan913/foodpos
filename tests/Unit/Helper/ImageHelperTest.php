<?php

namespace Tests\Unit\Helper;

use Tests\TestCase;
use App\Helper\ImageHelper;
use Faker;
use Illuminate\Support\Facades\File;

class ImageHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_thumbnail_resolutions(): void
    {
        $dimensions = ImageHelper::getImageTypeResolution("thumbnails");
        $this->assertTrue($dimensions == [200,200]);

    }

    /**
     * A basic unit test example.
     */
    public function test_get_empty_resoltion(): void
    {
        $dimensions = ImageHelper::getImageTypeResolution("");
        $this->assertTrue($dimensions == []);
    }

    public function test_can_generate_thumbnails():void
    {

        $faker = \Faker\Factory::create();

        $path = public_path("images/tests");
        if(!is_dir($path))
            mkdir($path, 0777, true);

        $fakeImage = $faker->image(public_path("images/tests"), 360, 360, "animals");
        $src = "tests/".basename($fakeImage);
        $fakeThumbnail = public_path("/images/thumbnails/$src");
        $this->assertTrue(!file_exists($fakeThumbnail));
        ImageHelper::getFile($src, "thumbnails");
        $this->assertTrue(file_exists($fakeThumbnail));
        File::delete($fakeImage);
        File::delete($fakeThumbnail);
    }
}
