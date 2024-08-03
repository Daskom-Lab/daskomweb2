<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoalMandiri
 * 
 * @property int $id
 * @property int $modul_id
 * @property string $pengantar
 * @property string $kodingan
 * @property string $soal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 * @property Collection|JawabanMandiri[] $jawaban_mandiris
 *
 * @package App\Models
 */
class SoalMandiri extends Model
{
	protected $table = 'soal_mandiris';

	protected $casts = [
		'modul_id' => 'int'
	];

	protected $fillable = [
		'modul_id',
		'pengantar',
		'kodingan',
		'soal'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function jawaban_mandiris()
	{
		return $this->hasMany(JawabanMandiri::class, 'soal_id');
	}
}
