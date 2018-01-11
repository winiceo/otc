<?php



namespace Genv\Otc\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;

class PackageCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'package:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a genvotc+✈️ extension package.';

    /**
     * The composer repository.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $repository;

    /**
     * Run the command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initRepository();

        list($vendor, $name) = explode('/', $packageName = $this->questionName());
        $namespace = sprintf('%s\\%s\\', $this->cameCase($vendor), $this->cameCase($name));
        $namespace = $this->ask('Autoload namespace, default', $namespace);
        $namespace = $this->formatNamespace($namespace);

        $this->repository->set('name', $packageName);
        $this->repository->set('description', sprintf('A "%s" package For genvotc+✈️.', $packageName));
        $this->repository->set('autoload.psr-4', [
            $namespace.'\\' => 'src/',
            $namespace.'\\Seeds\\' => 'database/seeds/',
        ]);
        $this->repository->set('extra.laravel.providers', [
            $this->formatNamespace($namespace.'\\Providers\\AppServiceProvider'),
            $this->formatNamespace($namespace.'\\Providers\\ModelServiceProvider'),
            $this->formatNamespace($namespace.'\\Providers\\RouteServiceProvider'),
        ]);

        $outputPath = $this
            ->getLaravel()
            ->resourcePath(sprintf('repositorie/sources/%s-%s', $vendor, $name));

        if (is_dir($outputPath) && file_exists($outputPath)) {
            throw new \RuntimeException(sprintf('Will the directory "%s" already exist', $outputPath));
        }

        $variable = [
            '{name}' => $name,
            '{studly-name}' => $this->cameCase($name),
            '{vendor}' => $vendor,
            '{namespace}' => preg_replace('/(\\\)+/', '\\', $namespace),
        ];

        $this->putStub($this->findStub(), $outputPath, $variable);
        file_put_contents(
            $outputPath.'/composer.json',
            json_encode($this->repository->all(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        $this->info(sprintf('Create Package to: [%s] success.', $outputPath));
    }

    /**
     * Put stub.
     *
     * @param \Symfony\Component\Finder\Finder $stubs
     * @param string $outputPath
     * @param array $variable
     * @return void
     */
    protected function putStub(Finder $stubs, string $outputPath, array $variable = [])
    {
        $this->getOutput()->progressStart($stubs->count());
        foreach ($stubs as $file) {
            $content = $file->getContents();

            $filenameDir = $outputPath.'/'.$file->getRelativePath();
            $filename = $filenameDir.'/'.$file->getBasename();
            if ($file->getExtension() === 'stub') {
                $filename = $filenameDir.'/'.$file->getBasename('.stub').'.php';
            }

            foreach ($variable as $key => $value) {
                $content = str_replace($key, $value, $content);
                $filename = str_replace($key, $value, $filename);
                $filenameDir = str_replace($key, $value, $filenameDir);
            }

            $filename = str_replace('\\', '/', $filename);
            $filenameDir = str_replace('\\', '/', $filenameDir);
            if (! file_exists($filenameDir)) {
                mkdir($filenameDir, 0777, true);
            }

            file_put_contents($filename, $content);
            $this->getOutput()->progressAdvance(1);
        }

        $this->getOutput()->progressFinish();
    }

    /**
     * Find stubs.
     *
     * @return \Symfony\Component\Finder\Finder
     */
    protected function findStub(): Finder
    {
        $finder = new Finder();

        return $finder->files()
            ->in(resource_path('/stubs/package'))
            ->ignoreVCS(false)
            ->ignoreDotFiles(false);
    }

    /**
     * format namespace.
     *
     * @param string $namespace
     * @return string
     */
    protected function formatNamespace(string $namespace): string
    {
        $namespace = ltrim($namespace, '\\');
        $namespace = rtrim($namespace, '\\');
        $namespace = preg_replace('/(\\\)+/', '\\', $namespace);
        // $namespace = str_replace('\\', '\\\\', $namespace);

        return $namespace;
    }

    /**
     * 格式化名称为驼峰式.
     *
     * @param string $name [description]
     * @return string
     */
    protected function cameCase(string $name): string
    {
        $name = str_replace('.', '', $name);
        $name = str_replace('-', '_', $name);

        return ucfirst(camel_case($name));
    }

    /**
     * Question name.
     *
     * @return string
     */
    protected function questionName(): string
    {
        return $this->getOutput()->ask('Package name (<vendor>/<name>)', null, function ($name) {
            if (! preg_match('{^[a-z0-9_.-]+/[a-z0-9_.-]+$}', $name)) {
                throw new \InvalidArgumentException(
                    'The package name '.$name.' is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name, matching: [a-z0-9_.-]+/[a-z0-9_.-]+'
                );
            }

            return $name;
        });
    }

    /**
     * Init composer repository config.
     *
     * @return void
     */
    protected function initRepository()
    {
        $this->repository = new Repository([
            'name' => 'vendor/name',
            'description' => '✈️The package is a genvotc+ package.',
            'type' => 'library',
            'license' => 'MIT',
            'require' => [
                'php' => '>=7.0',
                'illuminate/console' => '^5.5',
                'illuminate/contracts' => '^5.5',
                'illuminate/database' => '^5.5',
                'illuminate/support' => '^5.5',
            ],
            'autoload' => [],
            'config' => [
                'sort-packages' => true,
            ],
        ]);
    }
}
