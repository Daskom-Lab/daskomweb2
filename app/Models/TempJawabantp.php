<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TempJawabantp
 * 
 * @property int $id
 * @property int $praktikan_id
 * @property int $soal_id
 * @property int $modul_id
 * @property string $jawaban
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 * @property Praktikan $praktikan
 * @property SoalTp $soal_tp
 *
 * @package App\Models
 */
class TempJawabantp extends Model
{
	protected $table = 'temp_jawabantps';

	protected $casts = [
		'praktikan_id' => 'int',
		'soal_id' => 'int',
		'modul_id' => 'int'
	];

	protected $fillable = [
		'praktikan_id',
		'soal_id',
		'modul_id',
		'jawaban'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function praktikan()
	{
		return $this->belongsTo(Praktikan::class);
	}

	public function soal_tp()
	{
		return $this->belongsTo(SoalTp::class, 'soal_id');
	}
}
