<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdfExport extends Model
{
    protected $fillable = [
        'user_id',
        'cv_form_id',
        'filename',
        'template',
        'file_size'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cv_form()
    {
        return $this->belongsTo(CVForm::class);
    }
}
