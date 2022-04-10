<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	protected $table = 'Feedback';
	protected $fillable = ['text', 'page'];
    public $timestamps = false;
}