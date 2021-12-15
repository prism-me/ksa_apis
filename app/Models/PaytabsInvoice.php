<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PaytabsInvoice extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /*
        +"result": "The payment is completed successfully!"
        +"response_code": "100"
        +"pt_invoice_id": "548647"
        +"amount": 100
        +"currency": "USD"
        +"reference_no": "1231231"//order_id
        +"transaction_id": "740459"
        +"card_brand": "Visa"
        +"card_first_six_digits": "400000"
        +"card_last_four_digits": "0051"
    */

}
