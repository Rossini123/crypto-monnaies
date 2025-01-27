<template>
  <div v-if="markets" class="container pt-4" id="Markets">
    <div class="row g-2">
      <div class="col-8 mt-1">
        <select v-model="selectedIndex" @click="clickSelect" ref="select" @change="changeSelect" class="form-select mb-2 text-black-50" aria-label="Default select example">
          <option v-for="m in markets" :key="m.id" :value="m.market_cap_rank">
            {{m.name}}
          </option>
        </select>
      </div>
      <div class="col-3 mt-1 position-absolute">
        <input type="text" v-model="inputedName" @click="clickInput" @keyup="changeStartName" class="form-control bg-transparent shadow-none border">
      </div>
      <div class="col-4 mt-1">
        <select v-model="isUSD" class="form-select mb-2 bg-dark text-light" aria-label="Default select example">
          <option :value="false">MAD</option>
          <option :value="true">USD</option>
        </select>
      </div>
    </div>
    <div class="overflow-auto radius">
      <table class="table table-dark table-striped table-hover m-0">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col" class="fixed">{{glob.langData[glob.lang].symbol || "Symbol"}}</th>
            <th scope="col">{{glob.langData[glob.lang].name || "Name"}}</th>
            <th scope="col">{{glob.langData[glob.lang].price || "Price"}}</th>
            <th scope="col">1h %</th>
            <th scope="col">24h %</th>
            <th scope="col">7{{glob.langData[glob.lang].d || "d"}} %</th>
            <th scope="col">{{glob.langData[glob.lang].market_cap || "Market Cap"}}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="m in paginatedMarkets" :key="m.id" class="align-middle">
            <th scope="row">{{m.market_cap_rank}}</th>
            <td class="fixed" @click="clickCoin(m.id)">
              <img :src="m.image" :alt="m.name" width="30" height="30"><br>
              {{m.symbol}}
            </td>
            <td>{{m.name}}</td>
            <td>
              <span v-if="isUSD">{{around(m.current_price,2)}}<span class="monnaie">$</span></span>
              <span v-else>{{around(m.current_price_MAD,2)}}<span class="monnaie">MAD</span></span>
            </td>
            <td :class="[m.price_change_percentage_1h_in_currency>0?'text-success':'text-danger']">{{around(m.price_change_percentage_1h_in_currency,2)}}%</td>
            <td :class="[m.price_change_percentage_24h>0?'text-success':'text-danger']">{{around(m.price_change_percentage_24h,2)}}%</td>
            <td :class="[m.price_change_percentage_7d_in_currency>0?'text-success':'text-danger']">{{around(m.price_change_percentage_7d_in_currency,2)}}%</td>
            <td>
              <span v-if="isUSD">{{around(m.market_cap,2)}}<span class="monnaie">$</span></span>
              <span v-else>{{around(m.market_cap_MAD,2)}}<span class="monnaie">MAD</span></span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Paginate :page-count="markets.length/perPage" :click-handler="pagination"
    :prevLinkClass="'page-link prev'" :nextLinkClass="'page-link next'"/>
    <CoinDetails v-if="coinSelected" @close="close" :id="coinId" />
  </div>
</template>

<script>
import CryptoService from '@/services/CryptoService.js'
import Paginate from '@/components/Paginate.vue'
import CoinDetails from '@/components/CoinDetails.vue'
export default {
  name:"Markets",
  components:{
    Paginate,
    CoinDetails
  },
  data(){
    return{
      timer:null,
      markets:null,
      perPage:10,
      page:1,
      isUSD:false,
      selectedIndex:1,
      inputedName:'',
      inputChange:false,
      coinSelected:false,
      coinId:''
    }
  },
  methods: {
    getMarkets(){
      CryptoService.getMarkets().then(data => {
        if(data["error"] == undefined)
          this.markets = data
      })
    },
    around(value, nbr){
      return value.toFixed(nbr)
    },
    pagination(num){
      this.page = num
      this.inputChange = false
      this.selectedIndex = this.markets[(num*this.perPage)-this.perPage].market_cap_rank
      this.inputedName = ''
    },
    changeStartName(){
      for(var i=0; i<this.markets.length; i++) {
        if(this.markets[i].name.toLowerCase().startsWith(this.inputedName.toLowerCase())) {
          this.selectedIndex = this.markets[i].market_cap_rank
          this.inputedName = this.markets[i].name.substring(0,this.inputedName.length)
          this.inputChange = true
          break
        } else
          this.selectedIndex = 0
      }
    },
    changeSelect(){
      this.inputChange = true
      this.inputedName = ''
    },
    clickSelect(){
      this.$refs.select.classList.remove("text-black-50")
      this.$refs.select.classList.add("text-black")
    },
    clickInput(){
      this.$refs.select.classList.remove("text-black")
      this.$refs.select.classList.add("text-black-50")
    },
    clickCoin(id){
      this.coinSelected = true
      this.coinId = id
    },
    close(){
      this.coinSelected = false
    }
  },
  computed:{
    paginatedMarkets(){
      let s = (this.page-1)*this.perPage
      if(this.inputChange)
        s = this.selectedIndex-1
      let e = s+this.perPage
      return [...this.markets].slice(s, e);
    }
  },
  created() {
    this.getMarkets()
    this.timer = setInterval(()=>{
      this.getMarkets()
    },20000)
  },
  unmounted() {
    clearInterval(this.timer)
  }
}
</script>

<style>
#Markets .radius{
  border-radius: 17px;
}
#Markets .fixed{
  position:sticky;
  left:0px;
}
#Markets td.fixed{
  cursor: pointer;
}
#Markets .page-link{
  color:white;
  background-color: #101820;
}
#Markets .page-item.active .page-link {
  color: #101820;
  background-color: #2DA8D8;
  border-color: #2DA8D8;
}
#Markets .page-item.disabled .page-link {
  color: gray;
}
#Markets .prev{
  border-top-left-radius: 14px;
  border-bottom-left-radius: 14px;
}
#Markets .next{
  border-top-right-radius: 14px;
  border-bottom-right-radius: 14px;
}
#Markets .border{
  border: 1px solid #ffffff00 !important;
}
#Markets select{
  border: 1px solid gray !important;
}
</style>