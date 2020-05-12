<?php

namespace Base\Helpers;

use Illuminate\Support\Traits\Macroable;

class Common
{
    use Macroable;

    /**
     * Gets the namespace of a class from a relative path
     *
     * @param  string $path
     * @return string
     */
    public static function namespaceFromPath(string $path)
    {
        $parts = explode('/', $path);
        // Check if contains filename
        if (pathinfo($path, PATHINFO_EXTENSION)) {
            array_pop($parts);
        }
        return trim(implode('\\', $parts), '\\');
    }

    /**
     * Combine a base and relative namespace
     *
     * @param  string $baseNamespace
     * @param  string $namespace
     * @return string
     */
    public static function namespaceCombine(string $baseNamespace, string $namespace)
    {
        return ltrim($baseNamespace.rtrim('\\'.$namespace, '\\'), '\\');
    }
}
