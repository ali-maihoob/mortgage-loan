<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;

class ExtraRepaymentSchedule extends Model
{
    use HasFactory;
    protected $table = 'extra_repayment_schedule';
    protected $fillable = [
        'loan_id',
        'month_number',
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'extra_repayment_made',
        'ending_balance',
        'remaining_loan_term',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
