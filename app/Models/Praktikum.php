<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Praktikum
 * 
 * @property int $id
 * @property int $modul_id
 * @property int $kelas_id
 * @property int $pj_id
 * @property int $laporan_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Kelas $kelas
 * @property LaporanPj $laporan_pj
 * @property Modul $modul
 * @property Asisten $asisten
 * @property Collection|Deadline[] $deadlines
 *
 * @package App\Models
 */
class Praktikum extends Model
{
	protected $table = 'praktikums';

	protected $casts = [
		'modul_id' => 'int',
		'kelas_id' => 'int',
		'isActive' => 'int'
	];

	protected $fillable = [
		'modul_id',
		'kelas_id',
		'start_time',
		'end_time',
		'isActive',
	];

	public function kelas()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}

	public function modul()
	{
		return $this->belongsTo(Modul::class, 'modul_id');
	}

	public function laporan_pj()
	{
		return $this->hasMany(LaporanPj::class, 'praktikum_id');
	}

	public function deadlines()
	{
		return $this->hasMany(Deadline::class, 'praktikums_id');
	}
}
