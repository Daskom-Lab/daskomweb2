<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Asisten[] $asistens
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';

	protected $fillable = [
		'name',
		'guard_name'
	];

	public function asistens()
	{
		return $this->hasMany(Asisten::class);
	}
}
