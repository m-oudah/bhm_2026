<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ArchiveController extends Controller
{
    private array $archiveBaseUrls = [
        'http://localhost/archive',
        'http://152.53.237.131/archive',
    ];

    public function getFileData($file_number)
    {
        foreach ($this->archiveBaseUrls as $baseUrl) {
            $response = Http::acceptJson()
                ->timeout(20)
                ->get($baseUrl . '/getFileData/' . $file_number);

            if ($response->successful()) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'application/json; charset=UTF-8');
            }
        }

        return response()->json([
            'documents' => [],
            'message' => 'Unable to fetch archive data.',
        ], 502);
    }

    public function getFile($filename)
    {
        $filename = basename($filename);
        $localFilePath = $this->getLocalArchiveFilePath($filename);

        if ($localFilePath) {
            return response()->file($localFilePath, [
                'Cache-Control' => 'private, max-age=86400',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        abort(404);
    }

    private function getLocalArchiveFilePath(string $filename): ?string
    {
        $archiveRoots = array_unique([
            base_path('../archive/fotoupload'),
            base_path('../archive/public/fotoupload'),
            dirname(base_path()) . DIRECTORY_SEPARATOR . 'archive' . DIRECTORY_SEPARATOR . 'fotoupload',
            dirname(base_path()) . DIRECTORY_SEPARATOR . 'archive' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'fotoupload',
            public_path('../../archive/fotoupload'),
            public_path('../../archive/public/fotoupload'),
        ]);

        foreach ($archiveRoots as $archiveRoot) {
            $root = realpath($archiveRoot);

            if (!$root) {
                continue;
            }

            $path = realpath($root . DIRECTORY_SEPARATOR . $filename);

            if ($path && str_starts_with($path, $root . DIRECTORY_SEPARATOR) && is_file($path)) {
                return $path;
            }
        }

        return null;
    }

}
