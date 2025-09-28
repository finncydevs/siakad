namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirSyarat extends Model
{
    use HasFactory;

    protected $table = 'formulir_syarat';

    protected $fillable = ['formulir_id', 'syarat_id', 'is_checked'];

    public function formulir()
    {
        return $this->belongsTo(FormulirPendaftaran::class, 'formulir_id');
    }

    public function syarat()
    {
        return $this->belongsTo(SyaratPendaftaran::class, 'syarat_id');
    }
}
