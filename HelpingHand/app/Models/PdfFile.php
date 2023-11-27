<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfFile extends Model
{
    use HasFactory;
    protected $table ='pdf_file';
    protected $fillable = ['name','path'];
    public $timestamps= true;

    // Define the polymorphic relationship
    public function pdffilable()
    {
        return $this->morphTo();
    }
    public function candidates()
    {
        return $this->morphedByMany(Candidate::class, 'pdffilable');
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($pdf_file) {
            Log::info('PdfFile deleting event triggered');
            $pdfFilePath = $pdf_file->path . $pdf_file->name;
            Log::info('file-path:'.$pdfFilePath);
            // Check if the file exists before attempting to delete it
            if (file_exists($pdfFilePath)) {
                Log::info('PdfFile file exists yes');
                unlink($pdfFilePath);
            }
    
            // Check if the file exists
            if (Storage::exists($pdfFilePath)) {
                // Delete the file using Laravel's Storage
                Log::info('PdfFile file exists yes');
                Log::info($pdfFilePath);
                Storage::delete($pdfFilePath);
            }
        });
    }
}

