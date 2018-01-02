<?php



namespace Genv\Otc\Contracts\Cdn;

use Genv\Otc\Models\File;

interface UrlFactory
{
    /**
     * Get URL generator.
     *
     * @param string $name
     * @return \Genv\Otc\Contracts\Cdn\UrlGenerator
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function generator(string $name = ''): UrlGenerator;

    /**
     * Make a file url.
     *
     * @param \Genv\Otc\Models\File $file
     * @param array $extra
     * @param string $name
     * @return string
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function make(File $file, array $extra = [], string $name = ''): string;
}