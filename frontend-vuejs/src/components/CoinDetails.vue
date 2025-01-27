<template>
  <div id="CoinDetails">
    <div class="modal fade show m-auto d-block" @click.self="close" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="coin" class="modal-title" id="exampleModalLabel">
              <img :src="coin.image.large" :alt="coin.name" width="30" height="30">
              {{coin.name}}
            </h5>
            <button @click="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div v-if="coin" class="row">
              <div class="col-6 pe-0 border-e">
                <label class="mb-1">{{glob.langData[glob.lang].symbol || "Symbol"}} : <span class="text-black">{{coin.symbol}}</span></label><br>
                <label class="mb-1">1h % : 
                  <span :class="[coin.market_data.price_change_percentage_1h_in_currency.usd>0?'text-success':'text-danger']">
                    {{coin.market_data.price_change_percentage_1h_in_currency.usd.toFixed(4)}}
                  </span>
                </label><br>
                <label class="mb-1">24h % : 
                  <span :class="[coin.market_data.price_change_percentage_24h>0?'text-success':'text-danger']">
                    {{coin.market_data.price_change_percentage_24h.toFixed(4)}}
                  </span>
                </label><br>
                <label class="mb-1">7{{glob.langData[glob.lang].d || "d"}} % : 
                  <span :class="[coin.market_data.price_change_percentage_7d>0?'text-success':'text-danger']">
                    {{coin.market_data.price_change_percentage_7d.toFixed(4)}}
                  </span>
                </label><br>
                <label class="mb-1">30{{glob.langData[glob.lang].d || "d"}} % : 
                  <span :class="[coin.market_data.price_change_percentage_30d>0?'text-success':'text-danger']">
                    {{coin.market_data.price_change_percentage_30d.toFixed(4)}}
                  </span>
                </label><br>
                <label class="mb-1">{{glob.langData[glob.lang].market_cap_rank || "Market Cap Rank"}} : <span class="text-black">{{coin.market_data.market_cap_rank}}</span></label><br>
              </div>
              <div class="col-6">
                <select v-model="isUSD" class="form-select mb-2 bg-dark text-light" aria-label="Default select example">
                  <option :value="false">MAD</option>
                  <option :value="true">USD</option>
                </select>
                <label v-if="isUSD" class="mb-1">{{glob.langData[glob.lang].price || "Price"}} : <span class="text-black">{{coin.market_data.current_price.usd.toFixed(2)}}<span class="monnaie">$</span></span><br></label>
                <label v-else class="mb-1">{{glob.langData[glob.lang].price || "Price"}} : <span class="text-black">{{coin.market_data.current_price['MAD'].toFixed(2)}}<span class="monnaie">MAD</span></span><br></label>
                <label v-if="isUSD" class="mb-1">{{glob.langData[glob.lang].market_cap || "Market Cap"}} : <span class="text-black">{{coin.market_data.market_cap.usd.toFixed(2)}}</span><span class="monnaie">$</span><br></label>
                <label @click="cha" v-else class="mb-1">{{glob.langData[glob.lang].market_cap || "Market Cap"}} : <span class="text-black">{{coin.market_data.market_cap['MAD'].toFixed(2)}}</span><span class="monnaie">MAD</span><br></label>
              </div>
            </div>
            <div v-if="monthData">
              <div class="text-center">{{glob.langData[glob.lang].last_month_p_ch || "Last month price change"}}</div>
              <LineChart v-if="showChart && isUSD" :labels="monthData.labels" :values="monthData.valuesUSD"/>
              <LineChart v-if="showChart && !isUSD" :labels="monthData.labels" :values="monthData.valuesMAD"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" @click="close" style="opacity: 0.4;"></div>
  </div>
</template>

<script>
import CryptoService from '@/services/CryptoService.js'
import LineChart from './LineChart.vue'

export default {
  name: "CoinDetails",
  props:['id'],
  components:{
    LineChart
  },
  data(){
    return{
      timer:null,
      coin:null,
      isUSD:false,
      showChart:true,
      monthData:null
    }
  },
  methods: {
    close(){
      this.$emit('close')
      clearInterval(this.timer)
    },
    getCoin(id){
      CryptoService.getCoin(id).then(data => {
        if(data["error"] == undefined)
          this.coin = data
      })
    },
    getPastMonth(id){
      CryptoService.getPastMonth(id).then(data => {
        if(data["error"] == undefined)
          this.monthData = data
      })
    },
  },
  created() {
    this.getPastMonth(this.id)
    this.getCoin(this.id)
    this.timer = setInterval(()=>{
      this.getPastMonth(this.id)
      this.getCoin(this.id)
      this.showChart = false
      setTimeout(() => {
        this.showChart = true
      }, 1);
    },30000)
  },
  unmounted() {
    clearInterval(this.timer)
  },
}
</script>

<style>
#CoinDetails .border-e{
  border-right: 1px solid black !important;
}
</style>