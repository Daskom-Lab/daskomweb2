<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pelanggaran
 * 
 * @property int $id
 * @property int $pelanggaran_id
 * @property int $asisten_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property KodePelanggaran $kode_pelanggaran
 *
 * @package App\Models
 */
class Pelanggaran extends Model
{
	protected $table = 'pelanggarans';

	protected $casts = [
		'pelanggaran_id' => 'int',
		'asisten_id' => 'int'
	];

	protected $fillable = [
		'pelanggaran_id',
		'asisten_id'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}

	public function kode_pelanggaran()
	{
		return $this->belongsTo(KodePelanggaran::class, 'pelanggaran_id');
	}
}
