<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 * 
 * @property int $id
 * @property int $modul_id
 * @property string $modul_link
 * @property string $ppt_link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Modul $modul
 *
 * @package App\Models
 */
class Resource extends Model
{
	protected $table = 'resources';

	protected $casts = [
		'modul_id' => 'int'
	];

	protected $fillable = [
		'modul_id',
		'modul_link',
		'ppt_link',
		'video_link',
	];

	public function modul()
	{
		return $this->belongsTo(Modul::class);
	}
}
