<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tugaspendahuluan
 * 
 * @property int $id
 * @property int $modul_id
 * @property string $pembahasan
 * @property bool $isActive
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 *
 * @package App\Models
 */
class Tugaspendahuluan extends Model
{
	protected $table = 'tugaspendahuluans';

	protected $casts = [
		'modul_id' => 'int',
		'isActive' => 'bool'
	];

	protected $fillable = [
		'modul_id',
		'pembahasan',
		'isActive'
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}
}
