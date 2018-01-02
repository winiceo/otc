<?php



namespace Genv\Otc\Contracts\Cdn;

use Genv\Otc\Cdn\Refresh;

interface UrlGenerator
{
    /**
     * Generator an absolute URL to the given path.
     *
     * @param string $filename
     * @param array $extra "[float $width, float $height, int $quality]"
     * @return string
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function url(string $filename, array $extra = []): string;

    /**
     * Refresh the cdn files and dirs.
     *
     * @param \Genv\Otc\Cdn\Refresh $refresh
     * @return void
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function refresh(Refresh $refresh);
}
