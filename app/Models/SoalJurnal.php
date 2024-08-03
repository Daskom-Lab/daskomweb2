<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoalJurnal
 * 
 * @property int $id
 * @property int $modul_id
 * @property string $pengantar
 * @property string $kodingan
 * @property string $soal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool|null $isSulit
 * 
 * @property Modul $modul
 * @property Collection|JawabanJurnal[] $jawaban_jurnals
 *
 * @package App\Models
 */
class SoalJurnal extends Model
{
	protected $table = 'soal_jurnals';

	protected $casts = [
		'modul_id' => 'int',
		'isSulit' => 'bool'
	];

	protected $fillable = [
		'modul_id',
		'pengantar',
		'kodingan',
		'soal',
		'isSulit'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function jawaban_jurnals()
	{
		return $this->hasMany(JawabanJurnal::class, 'soal_id');
	}
}
