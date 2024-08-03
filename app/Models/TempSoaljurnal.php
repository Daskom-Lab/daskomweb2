<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TempSoaljurnal
 * 
 * @property int $id
 * @property string $allJurnal_id
 * @property string $allFitb_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TempSoaljurnal extends Model
{
	protected $table = 'temp_soaljurnals';

	protected $fillable = [
		'allJurnal_id',
		'allFitb_id'
	];
}
