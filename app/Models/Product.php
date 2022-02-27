<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'categories' => 'array',
    ];

    /**
     * Get the phone associated with the user.
     */
    public function merchant()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


}
