<?php

namespace App;

use App\Admin\Traits\ResizeTrait;
use App\Admin\Traits\StoreFile;
use App\Traits\FulltextSearchTrait;
use App\Traits\SociablesTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class Artist extends Model
{
    use StoreFile, ResizeTrait, SociablesTrait, FulltextSearchTrait;
    const ARTIST_LIST_RESIZE = 'artist_list';
    protected $fillable = ['name','description','artist_type_id','slug','on_index'];
    protected $fileFields = ['photo', 'additional_photos'];
    protected $casts = [
        'photo' => 'array',
        'additional_photos' => 'array',
        'test_test' => 'array',
        'on_index' => 'boolean',
    ];
    const FILTER_TYPE = 'type';
    const FILTER_SEARCH_NAME = 'name';
    const FILTER_ON_INDEX = 'on_index';
    const ORDER_NAME='name';

    public static function getResizeOptions()
    {
        return [
            self::ARTIST_LIST_RESIZE => [
                'storage' => 'public',
                'resize' => function ($image) {
                   /**
                    * @var \Intervention\Image\Image $image
                    */
                   $image->fit(212, 212);
                },
            ],
        ];
    }

    public function scopeFilter(Builder $query, $params)
    {
        if (!empty($params[self::FILTER_SEARCH_NAME])) {
            $query = $this->fulltextSearch('name', $params[self::FILTER_SEARCH_NAME]);
        }
        if(!empty($params[self::FILTER_TYPE])) {
            $query->where('artist_type_id', $params[self::FILTER_TYPE]);
        }

        if(!empty($params[self::FILTER_ON_INDEX])) {
            $query->where('on_index', 1);
        }

        return $query;
    }


    public function scopeOrder(Builder $query, $params)
    {
        if(empty($params['order'])) {
            return $query;
        }

        $params = $params['order'];
        if (!empty($params[self::ORDER_NAME])) {
            if($params[self::ORDER_NAME] === 'asc') {
                $query->orderBy('name','asc');
            }else{
                $query->orderBy('name','desc');
            }
        }

    }

    public function artistType()
    {
        return $this->belongsTo(ArtistType::class,'artist_type_id');
    }

}
