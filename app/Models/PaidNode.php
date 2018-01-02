<?php



namespace Genv\Otc\Models;

use Illuminate\Database\Eloquent\Model;

class PaidNode extends Model
{
    use Relations\PaidNodeHasUser;
}
