<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Program extends Model
{
    use HasFactory;
    protected $table = 'programs';

    protected $fillable = [
        'program_name',
        'program_code',
        'campus',
        'start_date',
        'end_date',
        'duration',
        'amount',
        'summary',
        'status',
        'action',
        'created_by',
    ];

    // Automatically cast dates to Carbon instances
    protected $dates = [
        'start_date',
        'end_date',
    ];

    // Accessor to display duration properly
    public function getDurationAttribute($value)
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            return $start->diff($end)->format('%m months %d days');
        }
        return $value;
    }
}
