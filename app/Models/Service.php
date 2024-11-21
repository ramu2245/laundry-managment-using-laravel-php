<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';  // The name of your table in the database
    protected $fillable = ['name', 'duration', 'price'];  // The fields you want to allow mass assignment for

    /**
     * Define the relationship between Service and Transaction.
     * Assuming the 'Transaction' model exists.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class); // One service can have many transactions
    }
}
