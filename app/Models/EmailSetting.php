<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use CrudTrait;
    protected $fillable = [
        "mail_mailer",
        "mail_host",
        "mail_port",
        "mail_username",
        "mail_password",
        "mail_encryption",
        "mail_from_address",
        "mail_from_name",
    ];
}
