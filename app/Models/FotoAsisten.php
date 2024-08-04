<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FotoAsisten
 * 
 * @property int $id
 * @property string $kode
 * @property string $foto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Asisten $asisten
 *
 * @package App\Models
 */
class FotoAsisten extends Model
{
	protected $table = 'foto_asistens';

	protected $fillable = [
		'kode',
		'foto'
	];

	public function asisten()
	{
		return $this->belongsTo(Asisten::class, 'kode', 'kode');
	}
}
