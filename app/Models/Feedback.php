<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * 
 * @property int $id
 * @property int $asisten_id
 * @property int $praktikan_id
 * @property string $pesan
 * @property int $kelas_id
 * @property bool|null $read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property Kelas $kelas
 * @property Praktikan $praktikan
 *
 * @package App\Models
 */
class Feedback extends Model
{
	protected $table = 'feedback';

	protected $casts = [
		'asisten_id' => 'int',
		'praktikan_id' => 'int',
		'kelas_id' => 'int',
		'read' => 'bool'
	];

	protected $fillable = [
		'asisten_id',
		'praktikan_id',
		'pesan',
		'kelas_id',
		'read'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class);
	}

	public function kela()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}

	public function praktikan()
	{
		return $this->belongsTo(Praktikan::class);
	}
}
