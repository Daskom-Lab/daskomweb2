<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KodePelanggaran
 * 
 * @property int $id
 * @property string $pelanggaran
 * @property int $denda
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Pelanggaran[] $pelanggarans
 *
 * @package App\Models
 */
class KodePelanggaran extends Model
{
	protected $table = 'kode_pelanggarans';

	protected $casts = [
		'denda' => 'int'
	];

	protected $fillable = [
		'pelanggaran',
		'denda'
	];

	public function pelanggarans()
	{
		return $this->hasMany(Pelanggaran::class, 'pelanggaran_id');
	}
}
