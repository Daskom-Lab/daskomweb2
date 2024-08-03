<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Configuration
 * 
 * @property int $id
 * @property bool $registrationPraktikan_activation
 * @property bool $registrationAsisten_activation
 * @property bool $tp_activation
 * @property bool $tubes_activation
 * @property bool $secretfeature_activation
 * @property bool $polling_activation
 * @property string $kode_asisten
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Configuration extends Model
{
	protected $table = 'configurations';

	protected $casts = [
		'registrationPraktikan_activation' => 'bool',
		'registrationAsisten_activation' => 'bool',
		'tp_activation' => 'bool',
		'tubes_activation' => 'bool',
		'secretfeature_activation' => 'bool',
		'polling_activation' => 'bool'
	];

	protected $hidden = [
		'secretfeature_activation'
	];

	protected $fillable = [
		'registrationPraktikan_activation',
		'registrationAsisten_activation',
		'tp_activation',
		'tubes_activation',
		'secretfeature_activation',
		'polling_activation',
		'kode_asisten'
	];
}
