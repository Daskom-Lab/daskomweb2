<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nilai
 * 
 * @property int $id
 * @property float $tp
 * @property float $ta
 * @property float $tk
 * @property float $jurnal
 * @property float $skill
 * @property float $diskon
 * @property float $rating
 * @property string $review
 * @property int $modul_id
 * @property int $asisten_id
 * @property int $kelas_id
 * @property int $praktikan_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property Kelas $kelas
 * @property Modul $modul
 * @property Praktikan $praktikan
 *
 * @package App\Models
 */
class Nilai extends Model
{
	protected $table = 'nilais';

	protected $casts = [
		'tp' => 'float',
		'ta' => 'float',
		'tk' => 'float',
		'jurnal' => 'float',
		'skill' => 'float',
		'diskon' => 'float',
		'rating' => 'float',
		'modul_id' => 'int',
		'asisten_id' => 'int',
		'kelas_id' => 'int',
		'praktikan_id' => 'int'
	];

	protected $fillable = [
		'tp',
		'ta',
		'tk',
		'jurnal',
		'skill',
		'diskon',
		'rating',
		'review',
		'modul_id',
		'asisten_id',
		'kelas_id',
		'praktikan_id'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}

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
