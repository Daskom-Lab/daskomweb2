<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KeluhanAslab
 * 
 * @property int $id
 * @property string $pesan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $asisten_id
 * 
 * @property Asisten $asisten
 *
 * @package App\Models
 */
class KeluhanAslab extends Model
{
	protected $table = 'keluhan_aslabs';

	protected $casts = [
		'asisten_id' => 'int'
	];

	protected $fillable = [
		'pesan',
		'asisten_id'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}
}
