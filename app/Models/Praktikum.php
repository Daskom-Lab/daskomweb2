<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Praktikum
 * 
 * @property int $id
 * @property int $modul_id
 * @property int $kelas_id
 * @property int $pj_id
 * @property int $laporan_id
 * @property bool $isActive
 * @property Carbon|null $start_time
 * @property Carbon|null $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Kelas $kelas
 * @property LaporanPj $laporan_pj
 * @property Modul $modul
 * @property Asisten $asisten
 *
 * @package App\Models
 */
class Praktikum extends Model
{
	protected $table = 'praktikums';

	protected $casts = [
		'modul_id' => 'int',
		'kelas_id' => 'int',
		'pj_id' => 'int',
		'laporan_id' => 'int',
		'isActive' => 'bool',
		'start_time' => 'datetime',
		'end_time' => 'datetime'
	];

	protected $fillable = [
		'modul_id',
		'kelas_id',
		'pj_id',
		'laporan_id',
		'isActive',
		'start_time',
		'end_time'
	];

	public function kela()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}

	public function laporan_pj()
	{
		return $this->belongsTo(LaporanPj::class, 'laporan_id');
	}

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function asisten()
	{
		return $this->belongsTo(Asisten::class, 'pj_id');
	}
}
