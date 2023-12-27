<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table='tags';
    protected $fillable=[
        'title',
        'slug',
    ];

    public function posts(){
        return $this->belongsToMany(
            Post::class,
            'post_tag',
            'tag_id',
            'post_id'
        );
    }
    public function sluggable(): array
    {
        return[
            'slug'=>[
                'source'=>'title',
            ],
        ];
    }
}
