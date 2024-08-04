<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JenisPolling
 * 
 * @property int $id
 * @property string $judul
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Polling[] $pollings
 *
 * @package App\Models
 */
class JenisPolling extends Model
{
	protected $table = 'jenis_pollings';

	protected $fillable = [
		'judul'
	];

	public function pollings()
	{
		return $this->hasMany(Polling::class, 'polling_id');
	}
}
