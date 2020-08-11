<?php


namespace zedsh\zadmin\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ResizeTrait
{
    public static function getResizeOptions()
    {
        return [
            'test' => [
                'storage' => 'public',
                'resize' => function ($field) {
                },
            ],
        ];
    }

    public function getResizeName($alias, $path)
    {
        $options = static::getResizeOptions();
        if (empty($options[$alias])) {
            return null;
        }

        $config = $options[$alias];
        $storage = $config['storage'];

        if (empty($path)) {
            return null;
        }
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $resizeInfo = $storage . '_' . $alias;

        return implode('/', [$dir, $filename . '_' . $resizeInfo . '.' . $extension]);
    }

    public function resize($alias, $path)
    {
        $options = static::getResizeOptions();
        if (empty($options[$alias])) {
            return null;
        }
        $config = $options[$alias];
        $image = Image::make(Storage::disk('public')->path($path));
        $config['resize']($image);
        $image->save(Storage::disk('public')->path($this->getResizeName($alias, $path)));
    }
}
