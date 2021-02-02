<?php

namespace App\Model;

// use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    // use SearchableTrait, Searchable;
    use SearchableTrait;

    protected $fillable = [
		'dealer_id',
		'partner_id',
		'partner2_id',
		'is_carplus',
		'cate_id',
		'ptate_id',
		'name',
		'price',
		'fee',
		'model',
		'plate_no',
		'brandcat_name',
		'brandcat_id',
		'brandin_id',
        'new_car_price',
        'second_hand_price',
		'displacement',
		'year',
		'car_value',
		'progeartype_id',
		'profuel_id',
		'seatnum',
		'procolor_id',
		'milage',
		'proarea_id',
		'proarea2_id',
		'equipment',
		'ord_id',
		'image',
		'sort',
		'status',
		'auto_online_date',
		'online_date',
        'mediate_date',
        'mediate_times',
        'off_times',
        'off_date',
		'is_renting',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.title_tw' => 10,
            'products.content' => 5,
            'products.model' => 2,
            'products.spec01' => 1,
            'products.spec02' => 1,
            'products.spec03' => 1,
        ],
    ];

    public function ord()
    {
        return $this->belongsTo('App\Model\Ord');
    }

    public function ptate()
    {
        return $this->belongsTo('App\Model\Ptate');
    }

    public function brandcat()
    {
        return $this->belongsTo('App\Model\Brandcat');
    }

    public function brandin()
    {
        return $this->belongsTo('App\Model\Brandin');
    }

    public function progeartype()
    {
        return $this->belongsTo('App\Model\Progeartype');
    }

    public function profuel()
    {
        return $this->belongsTo('App\Model\Profuel');
    }

    public function procolor()
    {
        return $this->belongsTo('App\Model\Procolor');
    }

    public function proarea()
    {
        return $this->belongsTo('App\Model\Proarea');
    }

    public function proarea2()
    {
        return $this->belongsTo('App\Model\Proarea','proarea2_id');
    }

    public function presentPrice()
    {
        //return money_format('$%i', $this->price / 100);
        return '$ '.number_format($this->price, 0, '.', ',');//money_format('$%i', $price);
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'cates' => $this->cates->pluck('name')->toArray(),
        ];

        return array_merge($array, $extraFields);
    }

    public function productimages(){
        return $this->hasMany('App\Model\Productimage')->orderBy('sort');
    }

    public function cate() {
        return $this->belongsTo('App\Model\Cate');
    }

    public function partner() {
        return $this->belongsTo('App\Model\Partner');
    }

    public function partner2() {
        return $this->belongsTo('App\Model\Partner','partner2_id');
    }


}
