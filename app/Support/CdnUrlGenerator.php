<?php



namespace Genv\Otc\Support;

use Genv\Otc\Models\File;
use Genv\Otc\Contracts\Cdn\UrlGenerator as FileUrlGeneratorContract;

abstract class CdnUrlGenerator implements FileUrlGeneratorContract
{
    /**
     * File data model.
     *
     * @var \Genv\Otc\Models\File
     */
    protected $file;

    /**
     * Get file data model.
     *
     * @return \Genv\Otc\Models\File
     */
    protected function getFile(): File
    {
        return $this->file;
    }

    /**
     * Set file data model.
     *
     * @param \Genv\Otc\Models\File $file
     */
    protected function setFile(File $file)
    {
        $this->file = $file;

        return $this;
    }
}
