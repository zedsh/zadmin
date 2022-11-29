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
        if (! empty($this->storageFilePath)) {
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

    public function replicateFiles()
    {
        foreach ($this->fileFields as $field) {
            if ($this->$field !== null) {
                $replace = [];
                foreach ($this->$field as $item) {
                    $newPath = Storage::disk($this->getStorage())->putFile($this->getSavePath(),Storage::disk($this->getStorage())->path($item['path']));
                    $replace[] = $this->getFileArray($item['name'], $newPath);
                }
                $this->$field = $replace;
            }
        }
    }

    public function deleteFile($field, $id)
    {
        if (! $this->isFillableFileField($field)) {
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

    protected function getFileAttributesFieldPostfix()
    {
        return '_attributes';
    }

    protected function getFileAttributesField($field)
    {
        return str_replace($this->getFileAttributesFieldPostfix(), '', $field);
    }

    public function isFillableFileAttributesField($field)
    {
        return stripos($field, $this->getFileAttributesFieldPostfix()) !== false
            && in_array($this->getFileAttributesField($field), $this->fileFields);
    }

    public function addFiles($fields)
    {
        foreach ($fields as $name => $field) {
            if (empty($field)) {
                continue;
            }

            if(is_array($field) && $this->isFillableFileAttributesField($name)) {
               $field_name = $this->getFileAttributesField($name);
               $field_content = $this->{$field_name};
               foreach ($field_content as &$file_item) {
                   foreach ($field as $field_id => $field_attributes) {
                       if($file_item['id'] === $field_id) {
                          $file_item = $field_attributes + $file_item;
                       }
                   }
               }

               unset($file_item);

               $this->{$field_name} = $field_content;
            }

            if ($field instanceof UploadedFile && $this->isFillableFileField($name)) {
                $fileName = $field->getClientOriginalName();
                $filePath = $field->store($this->getSavePath(), $this->getStorage());
                $attributes = $fields[$name . '_attributes'] ?? [];
                $this->$name = [$this->getFileArray($fileName, $filePath)];
            }

            if (is_array($field) && $this->isFillableFileField($name)) {
                $fill = [];
                $original = $this->$name;

                if (! empty($original)) {
                    $fill = $original;
                }

                foreach ($field as $item) {
                    if ($item instanceof UploadedFile) {
                        $fileName = $item->getClientOriginalName();
                        $filePath = $item->store($this->getSavePath(), $this->getStorage());
                        $fill[] = $this->getFileArray($fileName, $filePath);
                    }
                }

                if (! empty($fill)) {
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
            if (empty($field) || ! $this->isFillableFileField($name)) {
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

                if (! empty($fill)) {
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
