<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;
    protected $fillable = ['card_id', 'receptionist_id', 'signs', 'nurse_id', 'patient_data', 'cashier_id', 'price'];
    public function card()
    {
        return $this->belongsTo(HospitalCard::class, 'card_id');
    }
}
