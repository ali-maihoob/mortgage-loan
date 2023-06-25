<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;

class LoanAmortizationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'month_number',
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'ending_balance',
        'loan_id'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
