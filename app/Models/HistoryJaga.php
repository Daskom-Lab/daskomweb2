<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryJaga
 * 
 * @property int $id
 * @property string $hari
 * @property int $shift
 * @property bool $pj
 * @property int $asisten_id
 * @property int $modul_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 * @property Modul $modul
 *
 * @package App\Models
 */
class HistoryJaga extends Model
{
	protected $table = 'history_jagas';

	protected $casts = [
		'shift' => 'int',
		'pj' => 'bool',
		'asisten_id' => 'int',
		'modul_id' => 'int'
	];

	protected $fillable = [
		'hari',
		'shift',
		'pj',
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
}
