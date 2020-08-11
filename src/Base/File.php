<?php


namespace zedsh\zadmin\Base;

use Illuminate\Support\Facades\Storage;

class File
{
    protected $path;
    protected $originalName;
    protected $id;

    public function __construct($id, $path, $originalName)
    {
        $this->id = $id;
        $this->path = $path;
        $this->originalName = $originalName;
    }

    public function url()
    {
        return Storage::url($this->path);
    }

    public function originalName()
    {
        return $this->originalName;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isImage()
    {
        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
        $ext = pathinfo($this->path, PATHINFO_EXTENSION);

        return in_array($ext, $imageExtensions);
    }
}
