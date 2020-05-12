<?php

namespace Base\Tests\Unit\Helpers;

use Base\Helpers\Common;
use Base\Tests\TestCase;
use Illuminate\Support\Str;

class CommonHelpersTest extends TestCase
{
    protected $loadModules = [];

    public function test_namespace_from_path()
    {
        // Path is directory
        $path = 'Foo/Bar/BazQux';
        $this->assertEquals('Foo\\Bar\\BazQux', Common::namespaceFromPath($path));

        // Path is filename
        $path = 'Foo/Bar/Baz.php';
        $this->assertEquals('Foo\\Bar', Common::namespaceFromPath($path));

        // Empty path should be empty namespace
        $this->assertEquals('', Common::namespaceFromPath(''));

        // Namespace shouldn't lead or end with \
        $this->assertEquals('Foo\\Bar', Common::namespaceFromPath('/Foo/Bar/'));
    }

    public function test_namespace_combine()
    {
        $this->assertEquals('Foo\\Bar\\Baz', Common::namespaceCombine('Foo\\Bar', 'Baz'));
        $this->assertEquals('Foo\\Bar', Common::namespaceCombine('Foo\\Bar', ''));
        $this->assertEquals('Bar', Common::namespaceCombine('', 'Bar'));
        $this->assertEquals('', Common::namespaceCombine('', ''));
    }
}
