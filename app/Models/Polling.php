<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Polling
 * 
 * @property int $id
 * @property int $polling_id
 * @property int $asisten_id
 * @property int $praktikan_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property JenisPolling $jenis_polling
 * @property Praktikan $praktikan
 *
 * @package App\Models
 */
class Polling extends Model
{
	protected $table = 'pollings';

	protected $casts = [
		'polling_id' => 'int',
		'asisten_id' => 'int',
		'praktikan_id' => 'int'
	];

	protected $fillable = [
		'polling_id',
		'asisten_id',
		'praktikan_id'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}

	public function jenis_polling()
	{
		return $this->belongsTo(JenisPolling::class, 'polling_id');
	}

	public function praktikan()
	{
		return $this->belongsTo(Praktikan::class);
	}
}
