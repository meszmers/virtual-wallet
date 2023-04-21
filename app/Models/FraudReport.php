<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraudReport extends Model
{
    use HasFactory;

    protected $table = 'fraud_reports';
}
