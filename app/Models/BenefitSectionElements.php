<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitSectionElements extends Model
{
    use HasFactory;

        protected $fillable = [
        'benefit_section_id',
        'title',
        'description',
        'icon',
        'image',
        'order',
    ];
    //
    public function benefit_section()
    {
        return $this->belongsTo(UserBenefitSection::class, 'benefit_section_id');
    }
}
