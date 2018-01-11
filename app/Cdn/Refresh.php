<?php



namespace Genv\Otc\Cdn;

class Refresh
{
    /**
     * Files.
     *
     * @var array
     */
    protected $files = [];

    /**
     * Dirs.
     *
     * @var array
     */
    protected $dirs = [];

    /**
     * Create the refresh.
     *
     * @param array $files
     * @param array $dirs
     */
    public function __construct(array $files = [], array $dirs = [])
    {
        $this->files = $files;
        $this->dirs = $dirs;
    }

    /**
     * Get files.
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Set files.
     *
     * @param array $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get dirs.
     *
     * @return array
     */
    public function getDirs(): array
    {
        return $this->dirs;
    }

    /**
     * Set dirs.
     *
     * @param array $dirs
     */
    public function setDirs(array $dirs)
    {
        $this->dirs = $dirs;

        return $this;
    }
}
