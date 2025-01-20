<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Deadline
 * 
 * @property int $id
 * @property int $praktikums_id
 * @property Carbon|null $start_TA
 * @property Carbon|null $end_TA
 * @property Carbon|null $start_jurnal
 * @property Carbon|null $end_jurnal
 * @property Carbon|null $start_TM
 * @property Carbon|null $end_TM
 * @property Carbon|null $start_TK
 * @property Carbon|null $end_TK
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Praktikum $praktikum
 *
 * @package App\Models
 */
class Deadline extends Model
{
	protected $table = 'deadlines';

	protected $casts = [
		'praktikums_id' => 'int',
		'start_TA' => 'datetime',
		'end_TA' => 'datetime',
		'start_jurnal' => 'datetime',
		'end_jurnal' => 'datetime',
		'start_TM' => 'datetime',
		'end_TM' => 'datetime',
		'start_TK' => 'datetime',
		'end_TK' => 'datetime'
	];

	protected $fillable = [
		'praktikums_id',
		'start_TA',
		'end_TA',
		'start_jurnal',
		'end_jurnal',
		'start_TM',
		'end_TM',
		'start_TK',
		'end_TK'
	];

	public function praktikum()
	{
		return $this->belongsTo(Praktikum::class, 'praktikums_id');
	}
}
