<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LoanAmortizationSchedule;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_amount',
        'interest_rate',
        'monthly_payment',
        'fixed_extra_payment',
        'loan_term',
        'user_id'
    ];

    public function amortizationSchedule()
    {
        return $this->hasMany(LoanAmortizationSchedule::class);
    }
}
