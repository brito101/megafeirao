<?php

namespace LaraCar;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LaraCar\Company;
use LaraCar\Automotive;
use LaraCar\Contract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{

    use Notifiable,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //        'genre',
        //        'document',
        //        'document_secondary',
        //        'document_secondary_complement',
        //        'date_of_birth',
        //        'place_of_birth',
        'cover'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function companies()
    {
        return $this->hasMany(Company::class, 'user', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user', 'id');
    }

    public function automotives()
    {
        return $this->hasMany(Automotive::class, 'user', 'id');
    }

    public function contractsAsAcquirer()
    {
        return $this->hasMany(Contract::class, 'acquirer', 'id');
    }

    /**
     * Scopes
     */
    public function scopeBuyers($query)
    {
        return $query->where('buyer', true);
    }

    public function scopeSellers($query)
    {
        return $query->where('seller', true);
    }

    /**
     * Accerssors and Mutators
     */
    public function getCivilStatusTranslateAttribute(string $status, string $genre)
    {

        if ($genre === 'female') {
            if ($status === 'married') {
                return 'casada';
            } elseif ($status === 'separated') {
                return 'separada';
            } elseif ($status === 'single') {
                return 'solteira';
            } elseif ($status === 'divorced') {
                return 'divorciada';
            } elseif ($status === 'widower') {
                return 'viúva';
            } else {
                return '';
            }
        } else {
            if ($status === 'married') {
                return 'casado';
            } elseif ($status === 'separated') {
                return 'separado';
            } elseif ($status === 'single') {
                return 'solteiro';
            } elseif ($status === 'divorced') {
                return 'divorciado';
            } elseif ($status === 'widower') {
                return 'viúvo';
            } else {
                return '';
            }
        }
    }

    public function getUrlCoverAttribute()
    {
        if (!empty($this->cover)) {
            return Storage::url(Cropper::thumb($this->cover, 500, 500));
        }
        return '';
    }

    public function setSellerAttribute($value)
    {
        $this->attributes['seller'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setBuyerAttribute($value)
    {
        $this->attributes['buyer'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setAdsLimitAttribute($value)
    {
        if (empty($value)) {
            $value = 0;
        }
        $this->attributes['ads_limit'] = $value;
    }

    public function setDocumentAttribute($value)
    {
        $this->attributes['document'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getDocumentAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return
            substr($value, 0, 3) . '.' .
            substr($value, 3, 3) . '.' .
            substr($value, 6, 3) . '-' .
            substr($value, 9, 2);
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function getDateOfBirthAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function setIncomeAttribute($value)
    {
        $this->attributes['income'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getIncomeAttribute($value)
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

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            unset($this->attributes['password']);
            return;
        }
        $this->attributes['password'] = bcrypt($value);
    }

    public function setSpouseDocumentAttribute($value)
    {
        $this->attributes['spouse_document'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getSpouseDocumentAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return
            substr($value, 0, 3) . '.' .
            substr($value, 3, 3) . '.' .
            substr($value, 6, 3) . '-' .
            substr($value, 9, 2);
    }

    public function setSpouseDateOfBirthAttribute($value)
    {
        $this->attributes['spouse_date_of_birth'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function getSpouseDateOfBirthAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function setSpouseIncomeAttribute($value)
    {
        $this->attributes['spouse_income'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getSpouseIncomeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return number_format($value, 2, ',', '.');
    }

    public function setAdminAttribute($value)
    {
        $this->attributes['admin'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setClientAttribute($value)
    {
        $this->attributes['client'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    private function convertStringToDouble(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*     * Aux Function */

    public function reduceAdsLimit()
    {
        $this->ads_limit -= 1;
        $this->save();
    }
}
