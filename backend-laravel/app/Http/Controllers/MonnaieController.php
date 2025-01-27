<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Throwable;

class MonnaieController extends Controller
{

    public function fromUSDTo($monnaie, $amount){
        $res = "";
        try{
            $res = Currency::convert()->from('USD')->to($monnaie)->amount($amount)->get();
        } catch (Throwable $e) {
            $data = ["error"=>"many requests or server error"];
        }
        return $res;
    }

    public function fUSDToMAD(){
        $val = json_decode(file_get_contents(storage_path('/global.json')),true);
        $v = $this->fromUSDTo('MAD', 1);
        if(!isset($v["error"])){
            $val['USD_To_MAD'] = $this->fromUSDTo('MAD', 1);
            file_put_contents(storage_path('/global.json'), json_encode($val));
        }
    }

    public static function fromUSDToMAD($amount){
        $val = json_decode(file_get_contents(storage_path('/global.json')),true)['USD_To_MAD'];
        return $val*$amount;
    }
}
