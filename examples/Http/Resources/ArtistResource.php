<?php

namespace App\Http\Resources;

use App\Artist;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->load('socials');

        $ret = [
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'on_index' => $this->on_index,
            'photo' => null,
            'additional_photos' => [],
            'socials' => SocialResource::collection($this->socials)
        ];

        if(!empty($this->photo)) {
            $ret['photo'] = Storage::disk('public')->url($this->photo[0]['path']);
            $ret['photo_card'] = Storage::disk('public')->url($this->getResizeName(Artist::ARTIST_LIST_RESIZE, $this->photo[0]['path']));
        }


        if(!empty($this->additional_photos)) {
            foreach($this->additional_photos as $photo) {
                $ret['additional_photos'][] = Storage::disk('public')->url($photo['path']);
            }
        }

        return $ret;

    }
}
