export default {
  url : "http://127.0.0.1:8000/api",
  getMarkets(){
    return fetch(this.url+"/markets/3").then(res => res.json())
  },
  getCoin(id){
    return fetch(this.url+"/coin/"+id).then(res => res.json())
  },
  getPastMonth(id){
    return fetch(this.url+"/past-month/"+id).then(res => res.json())
  }
}