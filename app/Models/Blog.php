<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'content', 'imageUrl', 'tags', 'author',];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}
