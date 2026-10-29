class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // Harus 'pelanggan', bukan 'pelanggans'
    protected $primaryKey = 'pelanggan_id';

    protected $fillable = [
        'first_name', 'last_name', 'birthday', 'gender', 'email', 'phone'
    ];
}
