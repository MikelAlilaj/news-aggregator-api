<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    protected $fillable = ['name', 'service_key'];

    public function scopeByServiceKey($query, $serviceKey)
    {
        return $query->where('service_key', $serviceKey);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

     public function latestArticle()
     {
         return $this->hasOne(Article::class)->latest('published_at');
     }

    public function getServiceClass()
    {
        $serviceConfig = $this->getServiceConfig();
        return app($serviceConfig['class']);
    }

    public function getServiceConfig()
    {
        return config("services.data_sources.$this->service_key");
    }
 
}
