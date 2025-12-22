<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'campaign_id',      
        'lead_id',           
        'status',            
        'error_message',
        'email_account_used',
        'sent_at',
    ];
}
