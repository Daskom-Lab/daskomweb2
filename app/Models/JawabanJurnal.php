<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JawabanJurnal
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
 * @property SoalJurnal $soal_jurnal
 *
 * @package App\Models
 */
class JawabanJurnal extends Model
{
	protected $table = 'jawaban_jurnals';

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

	public function soal_jurnal()
	{
		return $this->belongsTo(SoalJurnal::class, 'soal_id');
	}
}
