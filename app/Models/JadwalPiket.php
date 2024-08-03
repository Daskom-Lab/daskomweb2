<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JadwalPiket
 * 
 * @property int $id
 * @property int $asisten_id
 * @property int $kelas_id
 * @property int $modul_id
 * @property string $pesan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 *
 * @package App\Models
 */
class JadwalPiket extends Model
{
	protected $table = 'jadwal_pikets';

	protected $casts = [
		'asisten_id' => 'int',
		'kelas_id' => 'int',
		'modul_id' => 'int'
	];

	protected $fillable = [
		'asisten_id',
		'kelas_id',
		'modul_id',
		'pesan'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}
}
