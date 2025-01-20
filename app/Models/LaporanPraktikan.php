<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LaporanPraktikan
 * 
 * @property int $id
 * @property string $pesan
 * @property float $rating_asisten
 * @property float $rating_praktikum
 * @property int $praktikan_id
 * @property int $asisten_id
 * @property int $modul_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property Modul $modul
 * @property Praktikan $praktikan
 *
 * @package App\Models
 */
class LaporanPraktikan extends Model
{
	protected $table = 'laporan_praktikans';

	protected $casts = [
		'praktikan_id' => 'int',
		'asisten_id' => 'int',
		'modul_id' => 'int'
	];

	protected $fillable = [
		'pesan',
		'praktikan_id',
		'asisten_id',
		'modul_id'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
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
