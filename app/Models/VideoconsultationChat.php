<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoconsultationChat extends Model
{
    use HasFactory;
    protected $table = 'videoconsultation_chats';

    protected $primaryKey = 'videoconsultation_id';

    protected $guarded = [];

    public $timestamps = false;

    public function addChat($name, Carbon $fecha, $mensaje) {
        $str = "[" . $fecha->format('H:i') . "] $name:\n$mensaje";
        if($this->chat) $this->chat .= "\n";
        $this->chat .= $str;
    }
}
