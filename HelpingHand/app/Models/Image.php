<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['name','path'];
    public $timestamps= true;

    // Define the polymorphic relationship
    public function imagable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($image) {
            // Delete the image file from storage when the Image model is deleted
            $imagePath = $image->path . $image->name;
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        });
    }
}
