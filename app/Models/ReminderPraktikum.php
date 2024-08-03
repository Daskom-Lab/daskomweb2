<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReminderPraktikum
 * 
 * @property int $id
 * @property int $kelas_id
 * @property int $praktikan_id
 * @property string $pesan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Kelas $kelas
 * @property Praktikan $praktikan
 *
 * @package App\Models
 */
class ReminderPraktikum extends Model
{
	protected $table = 'reminder_praktikum';

	protected $casts = [
		'kelas_id' => 'int',
		'praktikan_id' => 'int'
	];

	protected $fillable = [
		'kelas_id',
		'praktikan_id',
		'pesan'
	];

	public function kela()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}

	public function praktikan()
	{
		return $this->belongsTo(Praktikan::class);
	}
}
