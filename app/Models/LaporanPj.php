<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LaporanPj
 * 
 * @property int $id
 * @property string $allasisten_id
 * @property string $laporan
 * @property string $hari
 * @property int $shift
 * @property int $modul_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 * @property Collection|Praktikum[] $praktikums
 *
 * @package App\Models
 */
class LaporanPj extends Model
{
	protected $table = 'laporan_pjs';

	protected $fillable = [
		'allasisten_id',
		'laporan',
		'hari',
		'shift',
		'praktikum_id',
		'pj_id',
	];


	public function history_jagas()
	{
		return $this->hasMany(HistoryJaga::class);
	}
	public function praktikum()
	{
		return $this->belongsTo(Praktikum::class, 'praktikum_id');
	}

	public function asisten()
	{
		return $this->belongsTo(Asisten::class, 'pj_id');
	}
}
