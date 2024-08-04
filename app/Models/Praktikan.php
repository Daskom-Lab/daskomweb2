<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Praktikan
 * 
 * @property int $id
 * @property string $nama
 * @property string $nim
 * @property string $password
 * @property string|null $api_token
 * @property int $kelas_id
 * @property string $alamat
 * @property string $nomor_telepon
 * @property string $email
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Kelas $kelas
 * @property Collection|Feedback[] $feedback
 * @property Collection|JawabanFitb[] $jawaban_fitbs
 * @property Collection|JawabanJurnal[] $jawaban_jurnals
 * @property Collection|JawabanMandiri[] $jawaban_mandiris
 * @property Collection|JawabanTa[] $jawaban_tas
 * @property Collection|JawabanTk[] $jawaban_tks
 * @property Collection|JawabanTp[] $jawaban_tps
 * @property Collection|KumpulTp[] $kumpul_tps
 * @property Collection|LaporanPraktikan[] $laporan_praktikans
 * @property Collection|Nilai[] $nilais
 * @property Collection|Polling[] $pollings
 * @property Collection|ReminderPraktikum[] $reminder_praktikums
 * @property Collection|TempJawabantp[] $temp_jawabantps
 *
 * @package App\Models
 */
class Praktikan extends Model
{
	protected $table = 'praktikans';

	protected $casts = [
		'kelas_id' => 'int'
	];

	protected $hidden = [
		'password',
		'api_token',
		'remember_token'
	];

	protected $fillable = [
		'nama',
		'nim',
		'password',
		'api_token',
		'kelas_id',
		'alamat',
		'nomor_telepon',
		'email',
		'remember_token'
	];

	public function kela()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id');
	}

	public function feedback()
	{
		return $this->hasMany(Feedback::class);
	}

	public function jawaban_fitbs()
	{
		return $this->hasMany(JawabanFitb::class);
	}

	public function jawaban_jurnals()
	{
		return $this->hasMany(JawabanJurnal::class);
	}

	public function jawaban_mandiris()
	{
		return $this->hasMany(JawabanMandiri::class);
	}

	public function jawaban_tas()
	{
		return $this->hasMany(JawabanTa::class);
	}

	public function jawaban_tks()
	{
		return $this->hasMany(JawabanTk::class);
	}

	public function jawaban_tps()
	{
		return $this->hasMany(JawabanTp::class);
	}

	public function kumpul_tps()
	{
		return $this->hasMany(KumpulTp::class);
	}

	public function laporan_praktikans()
	{
		return $this->hasMany(LaporanPraktikan::class);
	}

	public function nilais()
	{
		return $this->hasMany(Nilai::class);
	}

	public function pollings()
	{
		return $this->hasMany(Polling::class);
	}

	public function reminder_praktikums()
	{
		return $this->hasMany(ReminderPraktikum::class);
	}

	public function temp_jawabantps()
	{
		return $this->hasMany(TempJawabantp::class);
	}
}
