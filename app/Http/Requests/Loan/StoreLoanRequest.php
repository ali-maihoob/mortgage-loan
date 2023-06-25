<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\LoanConstants;

class StoreLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'loan_amount' => 'required|numeric|min:' . LoanConstants::MIN_LOAN_AMOUNT,
            'interest_rate' => 'required|numeric|min:' . LoanConstants::MIN_INTEREST_RATE . '|max:' . LoanConstants::MAX_INTEREST_RATE,
            'monthly_payment' => 'nullable|numeric|min:' . LoanConstants::MIN_MONTHLY_PAYMENT,
            'fixed_extra_payment' => 'nullable|numeric|min:' . LoanConstants::MIN_FIXED_EXTRA_PAYMENT,
            'loan_term' => 'required|integer|min:' . LoanConstants::MIN_LOAN_TERM . '|max:' . LoanConstants::MAX_LOAN_TERM,
        ];
    }
}
