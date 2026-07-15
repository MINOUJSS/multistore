<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    protected $disk = 'local';

    protected $backupPath;

    public function __construct()
    {
        $this->backupPath = env('APP_NAME', 'laravel-backup');
    }

    public function index()
    {
        $disk = Storage::disk($this->disk);

        $files = collect($disk->files($this->backupPath))
            ->filter(fn ($file) => str_ends_with($file, '.zip'))
            ->map(function ($file) use ($disk) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => round($disk->size($file) / 1024 / 1024, 2),
                    'last_modified' => date('Y-m-d H:i:s', $disk->lastModified($file)),
                ];
            })
            ->sortByDesc('last_modified');

        return view('admins.admin.backup.index', compact('files'));
    }

    public function download($file)
    {
        $path = $this->backupPath.'/'.$file;

        if (!Storage::disk($this->disk)->exists($path)) {
            abort(404);
        }

        return Storage::disk($this->disk)->download($path);
    }

    public function delete($file)
    {
        $path = $this->backupPath.'/'.$file;

        if (!Storage::disk($this->disk)->exists($path)) {
            return redirect()->back()->with('error', 'Backup file not found.');
        }

        Storage::disk($this->disk)->delete($path);

        return redirect()->back()->with('success', 'Backup deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['string'],
        ]);

        $deleted = 0;

        // return response()->json([
        //     'ok' => true,
        //     'request' => $request['files'],
        // ]);

        foreach ($request['files'] as $file) {
            // حماية من Path Traversal
            $file = basename($file);

            $path = $this->backupPath.'/'.$file;

            if (Storage::disk($this->disk)->exists($path)) {
                Storage::disk($this->disk)->delete($path);

                ++$deleted;
            }
        }

        return back()->with(
            'success',
            "تم حذف {$deleted} ملف بنجاح."
        );
    }
}
