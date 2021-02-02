<?php

namespace App\Model;

use App\Model\Brandcat;
use Illuminate\Database\Eloquent\Model;

class Brandin extends Model
{
    protected $fillable = [
        'cate_id',
        'brandcat_id',
	    'title',
	    'title_en',
	    'descript',
	    'descript',
	    'quote',
	    'quote',
	    'quote_url',
	    'sort',
	    'status',
	    'published_at'
    ];

    public function cate(){
        return $this->belongsTo('App\Model\Cate');
    }

    public function brandcat(){
        return $this->belongsTo('App\Model\Brandcat');
    }

}
