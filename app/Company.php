<?php

namespace LaraCar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaraCar\Automotive;

class Company extends Model
{

    protected $fillable = [
        'user',
        'social_name',
        'alias_name',
        'headline',
        'cover',
        'cover1',
        'document_company',
        'document_company_secondary',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'slug',
        'telephone',
        'cell',
        'email'
    ];

    /*
     * Relacionamentos
     */

    public function ownerObject()
    {
        $user = User::where('id', $this->user)->first();
        return $user;
    }

    /**
     * Accerssors and Mutators
     */
    public function cover()
    {
        $cover = $this->cover;

        if (empty($cover) || !File::exists('../public/storage/' . $cover)) {
            return url(asset('frontend/assets/images/share.png'));
        }

        return Storage::url(Cropper::thumb($cover, 1366, 768));
    }

    public function cover1()
    {
        $cover = $this->cover1;

        if (empty($cover) || !File::exists('../public/storage/' . $cover)) {
            return url(asset('frontend/assets/images/share.png'));
        }

        return Storage::url(Cropper::thumb($cover, 1366, 768));
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user');
    }

    public function getUrlCoverAttribute()
    {
        if (!empty($this->cover)) {
            return Storage::url(Cropper::thumb($this->cover, 1366, 768));
        }
        return '';
    }

    public function getUrlCover1Attribute()
    {
        if (!empty($this->cover1)) {
            return Storage::url(Cropper::thumb($this->cover1, 1366, 768));
        }
        return '';
    }

    public function setUserAttribute($value)
    {
        $this->attributes['user'] = $value;
    }

    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getDocumentCompanyAttribute($value)
    {
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) .
            '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
    }

    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getZipcodeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '-' . substr($value, 5, 3);
    }

    public function setTelephoneAttribute($value)
    {
        $this->attributes['telephone'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getTelephoneAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (Str::length($value) == 11) {
            return '(' . substr($value, 0, 2) . ')  ' . substr($value, 2, 5) . '-' . substr($value, 7, 4);
        } else {
            return '(' . substr($value, 0, 2) . ')  ' . substr($value, 2, 4) . '-' . substr($value, 6, 4);
        }
    }

    public function setCellAttribute($value)
    {
        $this->attributes['cell'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getCellAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (Str::length($value) == 11) {
            return '(' . substr($value, 0, 2) . ')  ' . substr($value, 2, 5) . '-' . substr($value, 7, 4);
        } else {
            return '(' . substr($value, 0, 2) . ')  ' . substr($value, 2, 4) . '-' . substr($value, 6, 4);
        }
    }

    public function setSlug()
    {
        if (!empty($this->slug)) {
            $this->attributes['slug'] = Str::slug($this->slug);
            $this->save();
        }
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

    public function getTotal()
    {
        $sale = Automotive::sale()->available()->where('user', $this->user)->get();
        $rent = Automotive::rent()->available()->where('user', $this->user)->get();
        $ads = (count($sale) + count($rent));
        if ($ads > 1) {
            return $ads . ' anúncios';
        } else {
            return $ads . ' anúncio';
        }
    }

    public function getTotalSale()
    {
        $automotives = Automotive::sale()->available()->where('user', $this->user)->get();
        $ads = count($automotives);
        if ($ads > 1) {
            return $ads . ' vendas';
        } else {
            return $ads . ' venda';
        }
    }

    public function getTotalRent()
    {
        $automotives = Automotive::rent()->available()->where('user', $this->user)->get();
        $ads = count($automotives);
        if ($ads > 1) {
            return $ads . ' locações';
        } else {
            return $ads . ' locação';
        }
    }
}
