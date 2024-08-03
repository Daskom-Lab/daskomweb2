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

	protected $casts = [
		'shift' => 'int',
		'modul_id' => 'int'
	];

	protected $fillable = [
		'allasisten_id',
		'laporan',
		'hari',
		'shift',
		'modul_id'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}

	public function praktikums()
	{
		return $this->hasMany(Praktikum::class, 'laporan_id');
	}
}
