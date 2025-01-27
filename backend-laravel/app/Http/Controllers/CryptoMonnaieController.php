<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Throwable;

class CryptoMonnaieController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new CoinGeckoClient();
    }
    
    public function getMarkets($pages){
        $res = array();
        try{
            for($i=0; $i<$pages; $i++){
                $data = $this->client->coins()->getMarkets('usd',[
                    'per_page'=>250,
                    'page'=>$i+1,
                    'price_change_percentage'=>'1h,7d'
                ]);
                $res = array_merge($res, $data);
            }
            for($i=0; $i<count($res); $i++){
                $res[$i]["current_price_MAD"] = MonnaieController::fromUSDToMAD($res[$i]["current_price"]);
                $res[$i]["market_cap_MAD"] = MonnaieController::fromUSDToMAD($res[$i]["market_cap"]);
            }
        } catch (Throwable $e) {
            $res = ["error"=>"many requests or server error"];
        }
        return $res;
    }

    public function getCoin($id){
        $c = "";
        try{
            $c = $this->client->coins()->getCoin($id, [
                'tickers' => 'false'
            ]);
            $c["market_data"]["current_price"]["MAD"] = MonnaieController::fromUSDToMAD($c["market_data"]["current_price"]["usd"]);
            $c["market_data"]["market_cap"]["MAD"] = MonnaieController::fromUSDToMAD($c["market_data"]["market_cap"]["usd"]);
        } catch (Throwable $e) {
            $c = ["error"=>"many requests or server error"];
        }
        return $c;
    }

    public function getPastMonth($id){
        $labels=array();
        $valuesUSD=array();
        $valuesMAD=array();
        $data = null;
        try {
            $c = $this->client->coins()->getMarketChart($id, 'usd', 91);
            for($i=0;$i<=30;$i++)
                if($i != 1){
                    array_push($labels,gmdate("d-m",$c["prices"][sizeof($c["prices"])-$i-1][0]/1000));
                    array_push($valuesUSD,$c["prices"][sizeof($c["prices"])-$i-1][1]);
                    array_push($valuesMAD,MonnaieController::fromUSDToMAD($c["prices"][sizeof($c["prices"])-$i-1][1]));
                }
            $data = [
                "labels"=>array_reverse($labels),
                "valuesUSD"=>array_reverse($valuesUSD),
                "valuesMAD"=>array_reverse($valuesMAD)
            ];
        } catch (Throwable $e) {
            $data = ["error"=>"many requests or server error"];
        }
        return response()->json($data);
    }

    public function getCoinHistory($id, $date){
        $res = "";
        try{
            $res = $this->client->coins()->getHistory($id, $date);
        } catch (Throwable $e) {
            $res = ["error"=>"many requests or server error"];
        }
        return $res;
    }

    public function getList(){
        $res = "";
        try{
            $res = $this->client->coins()->getList();
        } catch (Throwable $e) {
            $res = ["error"=>"many requests or server error"];
        }
        return $res;
    }
}
