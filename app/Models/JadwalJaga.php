<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JadwalJaga
 * 
 * @property int $id
 * @property int $kelas_id
 * @property int $asisten_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property Kelas $kelas
 *
 * @package App\Models
 */
class JadwalJaga extends Model
{
	protected $table = 'jadwal_jagas';

	protected $casts = [
		'kelas_id' => 'int',
		'asisten_id' => 'int'
	];

	protected $fillable = [
		'kelas_id',
		'asisten_id'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}

	public function kela()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}
}
