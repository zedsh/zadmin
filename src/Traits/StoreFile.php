<?php


namespace zedsh\zadmin\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StoreFile
{
    protected $storageFilePath = '';
    protected $storage = 'public';

//    protected $fileFields = []; - in ext

    protected function getSavePath()
    {
        if (!empty($this->storageFilePath)) {
            return $this->storageFilePath;
        }

        return Str::lower(str_replace('\\', '/', static::class));
    }

    protected function getStorage()
    {
        return $this->storage;
    }

    protected function getFileArray($fileName, $filePath)
    {
        return [
            'id' => Str::uuid(),
            'path' => $filePath,
            'name' => $fileName,
        ];
    }

    public function deleteFile($field, $id)
    {
        if (!$this->isFillableFileField($field)) {
            return false;
        }

        $content = $this->$field;
        $remove = null;
        foreach ($content as $i => $file) {
            if ($file['id'] === $id) {
                $remove = $i;

                break;
            }
        }

        if ($remove !== null) {
            Storage::delete($content[$remove]['path']);
            unset($content[$remove]);
            $this->$field = $content;
            $this->save();
        }
    }

    public function isFillableFileField($field)
    {
        return in_array($field, $this->fileFields);
    }

    public function addFiles($fields)
    {
        foreach ($fields as $name => $field) {
            if (empty($field)) {
                continue;
            }

            if ($field instanceof UploadedFile && $this->isFillableFileField($name)) {
                $fileName = $field->getClientOriginalName();
                $filePath = $field->store($this->getSavePath(), $this->getStorage());
                $this->$name = [$this->getFileArray($fileName, $filePath)];
            }

            if (is_array($field) && $this->isFillableFileField($name)) {
                $fill = [];
                $original = $this->$name;

                if (!empty($original)) {
                    $fill = $original;
                }

                foreach ($field as $item) {
                    if ($item instanceof UploadedFile) {
                        $fileName = $item->getClientOriginalName();
                        $filePath = $item->store($this->getSavePath(), $this->getStorage());
                        $fill[] = $this->getFileArray($fileName, $filePath);
                    }
                }

                if (!empty($fill)) {
                    $this->$name = $fill;
                }
            }
        }

        foreach ($this->fileFields as $field) {
            if ($this->$field === null) {
                $this->$field = [];
            }
        }
    }

    /**
     * @param array|string $fields
     * array: fieldName => filePath
     * or fieldName => [fieldPath1, fieldPath2] ....
     */
    public function addLocalFilesFromPath($fields)
    {
        foreach ($fields as $name => $field) {
            if (empty($field) || !$this->isFillableFileField($name)) {
                continue;
            }

            if (is_array($field)) {
                foreach ($field as $item) {
                    if (file_exists($item)) {
                        $pathInfo = pathinfo($item);
                        $fileName = $pathInfo['basename'];
                        $filePath = Storage::disk($this->getStorage())->putFile($this->getSavePath(), $item);
                        $fill[] = $this->getFileArray($fileName, $filePath);
                    }
                }

                if (!empty($fill)) {
                    $this->$name = $fill;
                }
            } else {
                if (file_exists($field)) {
                    $pathInfo = pathinfo($field);
                    $fileName = $pathInfo['basename'];
                    $filePath = Storage::disk($this->getStorage())->putFile($this->getSavePath(), $field);
                    $this->$name = [$this->getFileArray($fileName, $filePath)];
                }
            }
        }

        foreach ($this->fileFields as $field) {
            if ($this->$field === null) {
                $this->$field = [];
            }
        }
    }
}
