<?php

namespace LaraCar;

use Illuminate\Database\Eloquent\Model;
use LaraCar\User;
use LaraCar\AutomotiveImage;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use \Kyslik\ColumnSortable\Sortable;

class Automotive extends Model
{

    use Sortable;

    protected $fillable = [
        'sale',
        'rent',
        'category',
        'type',
        'status',
        'user',
        'sale_price',
        'rent_price',
        'tribute',
        'description',
        'model',
        'brand',
        'year',
        'mileage',
        'gear',
        'doors',
        'fuel',
        'power',
        'direction',
        'color',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'air_conditioning',
        'electric_glass',
        'eletric_lock',
        'sound',
        'title',
        'slug',
        'headline',
        'experience',
        'airbag',
        'armored',
        'electric_steering',
        'hydraulic_steering',
        'abs_brakes',
        'electric_rear_view',
        'rain_sensor',
        'parking_sensor',
        'headlight_sensor',
        'sunroof',
        'traction',
        'electric_trio',
        'electric_front',
        'steering_wheel',
        'spotlight',
        'youtube_link'
    ];

    public $sortable = [
        'id',
        'sale_price',
        'year',
        'mileage',
        'created_at'
    ];

    /**
     * Relacionamentos
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function ownerObject()
    {
        $user = User::where('id', $this->user)->first();
        return $user;
    }

    public function images()
    {
        return $this->hasMany(AutomotiveImage::class, 'automotive', 'id')
            ->orderBy('cover', 'ASC');
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        //        return $query->where('status', 1);
        return $query->whereDate('active_date', '>=', Carbon::now()->subDays(30));
    }

    public function scopeUnavailable($query)
    {
        //        return $query->where('status', 0);
        return $query->whereDate('active_date', '<', Carbon::now()->subDays(30));
    }

    public function scopeSale($query)
    {
        return $query->where('sale', 1);
    }

    public function scopeRent($query)
    {
        return $query->where('rent', 1);
    }

    public function scopeSpotlight($query)
    {
        return $query->where('spotlight', 1);
    }

    /**
     * Accerssors and Mutators
     */
    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if (!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if (empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return url(asset('frontend/assets/images/share.png'));
        }

        return Storage::url(Cropper::thumb($cover['path'], 1366, 768));
    }

    public function coverFront()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if (!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if (empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return url(asset('frontend/assets/images/default.png'));
        }

        return Storage::url(Cropper::thumb($cover['path'], 1366, 1019));
    }

    public function setSaleAttribute($value)
    {
        $this->attributes['sale'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function setSalePriceAttribute($value)
    {
        $this->attributes['sale_price'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getSalePriceAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setRentPriceAttribute($value)
    {
        $this->attributes['rent_price'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getRentPriceAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setTributeAttribute($value)
    {
        $this->attributes['tribute'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setSpotlightAttribute($value)
    {
        $this->attributes['spotlight'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function getTributeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
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

    public function setSlug()
    {
        if (!empty($this->title)) {
            $this->attributes['slug'] = Str::slug($this->title) . '-' . $this->id;
            $this->save();
        }
    }

    public function setAirConditioningAttribute($value)
    {
        $this->attributes['air_conditioning'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setElectricGlassAttribute($value)
    {
        $this->attributes['electric_glass'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setEletricLockAttribute($value)
    {
        $this->attributes['eletric_lock'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setSoundAttribute($value)
    {
        $this->attributes['sound'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setAirbagAttribute($value)
    {
        $this->attributes['airbag'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setArmoredAttribute($value)
    {
        $this->attributes['armored'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setElectricSteeringAttribute($value)
    {
        $this->attributes['electric_steering'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setHydraulicSteeringAttribute($value)
    {
        $this->attributes['hydraulic_steering'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setAbsBrakesAttribute($value)
    {
        $this->attributes['abs_brakes'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setElectricRearViewAttribute($value)
    {
        $this->attributes['electric_rear_view'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setRainSensorAttribute($value)
    {
        $this->attributes['rain_sensor'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setParkingSensorAttribute($value)
    {
        $this->attributes['parking_sensor'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setHeadlightSensorAttribute($value)
    {
        $this->attributes['headlight_sensor'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setSunroofAttribute($value)
    {
        $this->attributes['sunroof'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setTractionAttribute($value)
    {
        $this->attributes['traction'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setElectricTrioAttribute($value)
    {
        $this->attributes['electric_trio'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setElectricFrontAttribute($value)
    {
        $this->attributes['electric_front'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setSteeringWheelAttribute($value)
    {
        $this->attributes['steering_wheel'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setUserAttribute($value)
    {
        $this->attributes['user'] = $value;
    }

    private function convertStringToDouble($param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
