<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'comments';
    const UNPUBLISH=0;
    const PUBLISH=1;
    protected $fillable = [
        'text',
        'slug',
        'user_id',
        'post_id',
        'is_publish',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function publish(): bool
    {
        return $this->is_publish=1;
    }

    public function unpublish(): bool
    {
        return $this->is_publish=0;
    }

    public function togglePublish($switcher=null): bool
    {
        if($switcher!=null) $this->publish();

        return $this->unpublish();
    }

    public function scopePublished($query)
    {
        return $query->where('is_publish','=',1);
    }

    public function scopeUnpublished($query)
    {
        return $query->where('is_publish','=',0);
    }

    public function sluggable(): array
    {
        return[
            'slug'=>[
                'source'=>'text',
            ],
        ];
    }
}
