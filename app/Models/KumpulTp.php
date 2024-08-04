<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KumpulTp
 * 
 * @property int $id
 * @property int $modul_id
 * @property int $kelas_id
 * @property int $praktikan_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Kelas $kelas
 * @property Modul $modul
 * @property Praktikan $praktikan
 *
 * @package App\Models
 */
class KumpulTp extends Model
{
	protected $table = 'kumpul_tps';

	protected $casts = [
		'modul_id' => 'int',
		'kelas_id' => 'int',
		'praktikan_id' => 'int'
	];

	protected $fillable = [
		'modul_id',
		'kelas_id',
		'praktikan_id'
	];

	public function kela()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function praktikan()
	{
		return $this->belongsTo(Praktikan::class);
	}
}
