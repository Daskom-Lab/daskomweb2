<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoalTp
 * 
 * @property int $id
 * @property int $modul_id
 * @property string $soal
 * @property bool|null $isEssay
 * @property bool|null $isProgram
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 * @property Collection|JawabanTp[] $jawaban_tps
 * @property Collection|TempJawabantp[] $temp_jawabantps
 *
 * @package App\Models
 */
class SoalTp extends Model
{
	protected $table = 'soal_tps';

	protected $casts = [
		'modul_id' => 'int',
		'isEssay' => 'bool',
		'isProgram' => 'bool'
	];

	protected $fillable = [
		'modul_id',
		'soal',
		'isEssay',
		'isProgram'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function jawaban_tps()
	{
		return $this->hasMany(JawabanTp::class, 'soal_id');
	}

	public function temp_jawabantps()
	{
		return $this->hasMany(TempJawabantp::class, 'soal_id');
	}
}
