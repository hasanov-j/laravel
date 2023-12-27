<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $table = 'posts';
    const DEFAULT_IMAGE = '/uploads/default-image.jpg';
    const PUBLISHED = 1;
    const UNPUBLISHED = 0;
    const RECOMMENDED = 1;
    const UNRECOMMENDED = 0;

    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'user_id',
        'is_publish',
        'is_recommended',
        'views',
        'image',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'post_tag',
            'post_id',
            'tag_id'
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(UploadedFile $file, $attributes) => $attributes['image'],

            set: function (UploadedFile $file) {

                //проверяем нет ли у данного экземпляра модели Post значения у атрибута image, если есть удаляем его
                if ($this->attributes['image'] != null) {
                    Storage::delete('uploads/'. $this->attributes['image']);
                }

                //сохраняем изображение в папке uploads и устанавливаем (новое) значение атрибута
                if ($file != null) {
                    $filename=$file->store('uploads/');
                    $this->attributes['image'] = $filename;
                }

                $this->attributes['image'] = Post::DEFAULT_IMAGE;

            },
        );
    }

    public function publish(): bool
    {
        return $this->is_publish = Post::PUBLISHED;
    }

    public function unpublish(): bool
    {
        return $this->is_publish = Post::UNPUBLISHED;
    }

    public function togglePublish($switcher = null): bool
    {
        if ($switcher != null) {

            return $this->publish();
        }

        return $this->unpublish();

    }

    public function recommend(): bool
    {
        return $this->is_recommended = Post::RECOMMENDED;
    }

    public function unrecommend(): bool
    {
        return $this->is_recommended = Post::UNRECOMMENDED;
    }

    public function toggleRecommend($switcher = null): bool
    {
        if ($switcher != null) {

            return $this->recommend();
        }

        return $this->unrecommend();
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended','=',1);
    }

    public function scopeUnrecommended($query)
    {
        return $query->where('is_recommended','=',0);
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
                'source'=>'title',
            ],
        ];
    }

}
