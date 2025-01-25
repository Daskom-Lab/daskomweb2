<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SoalTk
 * 
 * @property int $id
 * @property int $modul_id
 * @property string $pengantar
 * @property string $kodingan
 * @property string $pertanyaan
 * @property string $jawaban_benar
 * @property string $jawaban_salah1
 * @property string $jawaban_salah2
 * @property string $jawaban_salah3
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 * @property Collection|JawabanTk[] $jawaban_tks
 *
 * @package App\Models
 */
class SoalTk extends Model
{
	use HasFactory;
	protected $table = 'soal_tks';

	protected $casts = [
		'modul_id' => 'int'
	];

	protected $fillable = [
		'modul_id',
		'pengantar',
		'kodingan',
		'pertanyaan',
		'jawaban_benar',
		'jawaban_salah1',
		'jawaban_salah2',
		'jawaban_salah3'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function jawaban_tks()
	{
		return $this->hasMany(JawabanTk::class, 'soal_id');
	}
}
