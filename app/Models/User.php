<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\HasMany, SoftDeletes};

class User extends Model
{
	use SoftDeletes;

	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'surname', 'email', 'password','role','telephone','profile_image','address','city','postal_code'];


	public function cart(): HasMany
	{
		return $this->hasMany(Cart::class);
	}
}
