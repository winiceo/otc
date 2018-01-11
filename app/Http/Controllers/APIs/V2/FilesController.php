<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Genv\Otc\Models\File as FileModel;
use Genv\Otc\Models\User as UserModel;
use Genv\Otc\Cdn\UrlManager as CdnUrlManager;
use Genv\Otc\Models\FileWith as FileWithModel;
use Genv\Otc\Models\PaidNode as PaidNodeModel;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseContract;
use Genv\Otc\Http\Requests\API2\StoreUploadFile as StoreUploadFileRequest;

class FilesController extends Controller
{
    /**
     * Get file.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Cdn\UrlManager $manager
     * @param \Genv\Otc\Models\FileWith $fileWith
     * @return mixed
     */
    public function show(Request $request, ResponseContract $response, CdnUrlManager $cdn, FileWithModel $fileWith)
    {
        $fileWith->load(['file', 'paidNode']);
        $user = $request->user('api');
        $extra = array_filter([
            'width' => $request->query('w'),
            'height' => $request->query('h'),
            'quality' => $request->query('q'),
            'blur' => $request->query('b'),
        ]);

        if (
            ($fileWith->paidNode instanceof PaidNodeModel &&
            $fileWith->paidNode->paid($user->id ?? 0) === false) &&
            ($fileWith->paidNode->extra === 'read' || (! $extra['width'] && $extra['height']))
        ) {
            $extra['blur'] = (int) config('image.blur', 96);
        }

        $url = $cdn->make($fileWith->file, $extra);

        return $request->query('json') !== null
            ? $response->json(['url' => $url])->setStatusCode(200)
            : $response->redirectTo($url, 302);
    }

    /**
     * 解决用户是否购买过处理.
     *
     * @param \Genv\Otc\Models\User|null $user
     * @param \Genv\Otc\Models\PaidNode  $pay
     * @return void
     */
    protected function resolveUserPaid($user, PaidNodeModel $node): bool
    {
        return $node->paid($user->id ?? 0);
    }

    /**
     * 储存上传文件.
     *
     * @param \Genv\Otc\Http\Requests\API2\StoreUploadFile $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Carbon\Carbon $dateTime
     * @param \Genv\Otc\Models\File $fileModel
     * @param \Genv\Otc\Models\FileWith $fileWith
     * @return mixed
     */
    public function store(StoreUploadFileRequest $request, ResponseContract $response, Carbon $dateTime, FileModel $fileModel, FileWithModel $fileWith)
    {
        $fileModel = $this->validateFileInDatabase($fileModel, $file = $request->file('file'), function (UploadedFile $file, string $md5) use ($fileModel, $dateTime): FileModel {
            list($width, $height) = ($imageInfo = @getimagesize($file->getRealPath())) === false ? [null, null] : $imageInfo;
            $path = $dateTime->format('Y/m/d/Hi');

            if (($filename = $file->store($path, config('cdn.generators.filesystem.disk'))) === false) {
                abort(500, '上传失败');
            }

            $fileModel->filename = $filename;
            $fileModel->hash = $md5;
            $fileModel->origin_filename = $file->getClientOriginalName();
            $fileModel->mime = $file->getClientMimeType();
            $fileModel->width = $width;
            $fileModel->height = $height;
            $fileModel->saveOrFail();

            return $fileModel;
        });

        $fileWith = $this->resolveFileWith($fileWith, $request->user(), $fileModel);

        return $response->json([
            'message' => ['上传成功'],
            'id' => $fileWith->id,
        ])->setStatusCode(201);
    }

    /**
     * Get or create a uploaded file with id.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\File $file
     * @param \Genv\Otc\Models\FileWith $fileWith
     * @param string $hash
     * @return mixed
     */
    public function uploaded(Request $request, ResponseContract $response, FileModel $file, FileWithModel $fileWith, string $hash)
    {
        $file = $file->where('hash', strtolower($hash))->firstOr(function () {
            abort(404);
        });

        // 复用空类型数据～减少资源浪费.
        $fileWith = $this->resolveFileWith($fileWith, $request->user(), $file);

        return $response->json([
            'message' => ['success'],
            'id' => $fileWith->id,
        ])->setStatusCode(200);
    }

    /**
     * Validate and return the file database model instance.
     *
     * @param \Genv\Otc\Models\File $fileModel
     * @param \Illuminate\Http\UploadedFile $file
     * @param callable $call
     * @return \Genv\Otc\Models\File
     */
    protected function validateFileInDatabase(FileModel $fileModel, UploadedFile $file, callable $call): FileModel
    {
        $hash = md5_file($file);

        return $fileModel->where('hash', $hash)->firstOr(function () use ($file, $call, $hash): FileModel {
            return call_user_func_array($call, [$file, $hash]);
        });
    }

    /**
     * 解决数据模型非实例.
     *
     * @param \Genv\Otc\Models\FileWith $fileWith
     * @param \Genv\Otc\Models\User $user
     * @param \Genv\Otc\Models\File $file
     * @return \Genv\Otc\Models\FileWith
     */
    protected function resolveFileWith(FileWithModel $fileWith, UserModel $user, FileModel $file): FileWithModel
    {
        $fileWith->file_id = $file->id;
        $fileWith->channel = null;
        $fileWith->raw = null;
        $fileWith->size = ($size = sprintf('%sx%s', $file->width, $file->height)) === 'x' ? null : $size;
        $user->files()->save($fileWith);

        return $fileWith;
    }
}
