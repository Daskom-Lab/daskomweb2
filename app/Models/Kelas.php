<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Kela
 * 
 * @property int $id
 * @property string $kelas
 * @property string $hari
 * @property int $shift
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $totalGroup
 * 
 * @property Collection|Feedback[] $feedback
 * @property Collection|JadwalJaga[] $jadwal_jagas
 * @property Collection|KumpulTp[] $kumpul_tps
 * @property Collection|Nilai[] $nilais
 * @property Collection|Praktikan[] $praktikans
 * @property Collection|Praktikum[] $praktikums
 * @property Collection|ReminderPraktikum[] $reminder_praktikums
 *
 * @package App\Models
 */
class Kelas extends Model
{
	protected $table = 'kelas';

	protected $casts = [
		'shift' => 'int',
		'totalGroup' => 'int'
	];

	protected $fillable = [
		'kelas',
		'hari',
		'shift',
		'totalGroup'
	];

	public function feedback()
	{
		return $this->hasMany(Feedback::class, 'kelas_id');
	}

	public function jadwal_jagas()
	{
		return $this->hasMany(JadwalJaga::class, 'kelas_id');
	}

	public function kumpul_tps()
	{
		return $this->hasMany(KumpulTp::class, 'kelas_id');
	}

	public function nilais()
	{
		return $this->hasMany(Nilai::class, 'kelas_id');
	}

	public function praktikans()
	{
		return $this->hasMany(Praktikan::class, 'kelas_id');
	}

	public function praktikums()
	{
		return $this->hasMany(Praktikum::class, 'kelas_id');
	}

	public function reminder_praktikums()
	{
		return $this->hasMany(ReminderPraktikum::class, 'kelas_id');
	}
}
