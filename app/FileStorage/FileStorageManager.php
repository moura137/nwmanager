<?php

namespace NwManager\FileStorage;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileStorageManager
{
    /**
     * Construct
     *
     * @param Filesystem $filesystem
     * @param Storage    $storage
     */
    public function __construct(Filesystem $filesystem, Storage $storage)
    {
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    /**
     * Upload File
     *
     * @param UploadedFile $file
     *
     * @return bool
     */
    /**
     * UploadFile
     *
     * @param UploadedFile $file
     * @param string       $name
     * @param string       $folder
     *
     * @return bool
     */
    public function uploadFile(UploadedFile $file, $name = null, $folder = null)
    {
        $data = $this->parseFile($file, $name, $folder);

        $success = $this->storage->put($data['filename'], file_get_contents($file));

        if ($success) {
            return $data;
        }

        return false;
    }

    /**
     * Delete File
     *
     * @param string $name
     * @param string $folder
     *
     * @return bool
     */
    public function deleteFile($name, $folder)
    {
        try {

            $filename = $this->parseFilename($name, $folder);

            return $this->storage->delete($filename);
        } catch (\Exception $e) { }
    }

    /**
     * Read File
     *
     * @param string $name
     * @param string $folder
     *
     * @return string
     */
    public function readFile($name, $folder)
    {
        try {

            $filename = $this->parseFilename($name, $folder);

            return $this->storage->get($filename);

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get MimeType File
     *
     * @param string $name
     * @param string $folder
     *
     * @return bool
     */
    public function mimeType($name, $folder)
    {
        try {

            $filename = $this->parseFilename($name, $folder);

            return $this->storage->mimeType($filename);

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get Size
     *
     * @param string $name
     * @param string $folder
     *
     * @return bool
     */
    public function size($name, $folder)
    {
        try {

            $filename = $this->parseFilename($name, $folder);

            return $this->storage->size($filename);

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get Meta Data
     *
     * @param string $name
     * @param string $folder
     *
     * @return bool
     */
    public function metaData($name, $folder)
    {
        try {

            $filename = $this->parseFilename($name, $folder);

            return $this->storage->getMetadata($filename);

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse Filename
     *
     * @param string $name
     * @param string $folder
     *
     * @return string
     */
    protected function parseFilename($name, $folder)
    {
        $folder = trim($folder, '/');
        $folder = $folder ? "{$folder}/" : "";
        $filename = "{$folder}{$name}";

        return $filename;
    }

    /**
     * Parse Filename
     *
     * @param UploadedFile $file
     * @param string       $name
     * @param string       $folder
     *
     * @return bool|array
     */
    public function parseFile($file, $name = null, $folder = null)
    {
        $folder = trim($folder, '/');
        $folder = $folder ? "{$folder}/" : "";

        $nameOriginal = str_slug($name ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        if (empty($nameOriginal)) {
            $nameOriginal = str_random(10);
        }
        $extension = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        $mime = $file->getClientMimeType();

        $sufix = '';
        $count = 1;
        do {
            $name = "{$nameOriginal}{$sufix}.{$extension}";
            $filename = "{$folder}{$name}";

            if ($count > 100) {
                throw new \Exception("Loop Infinite File Image {$filename}");
            }

            $count += 1;
            $sufix = "({$count})";

        } while ($this->storage->exists($filename));

        return compact('filename', 'name', 'extension', 'size', 'mime');
    }
}