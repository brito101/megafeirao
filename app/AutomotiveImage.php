<?php

namespace LaraCar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;

class AutomotiveImage extends Model {

    protected $fillable = [
        'automotive',
        'path',
        'cover'
    ];

    public function getUrlCroppedAttribute() {
        return Storage::url(Cropper::thumb($this->path, 1366, 768));
    }

}
