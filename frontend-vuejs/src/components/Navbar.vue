<template>
<div id="Navbar">
  <nav class="navbar navbar-expand-md fixed-top navbar-dark">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="m-auto">
        <router-link class="navbar-brand d-flex" :to="{ name: 'Markets' }">
          <span class="brand">RTCC</span>
          <span class="brand-2 ms-2 d-none d-md-block">
            Real-time cryptocurrencies
          </span>
        </router-link>
      </div>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="nav nav-pills flex-column flex-sm-column flex-md-row ms-auto mb-2 mb-md-0 mt-2 mt-md-0" role="tablist">
          <li class="nav-item">
            <span :class="[verifyUrl('/markets')? 'nav-link active p-0' : 'nav-link p-0']" aria-current="page" role="presentation" aria-selected="true" data-bs-toggle="pill" data-bs-target="#pills-markets">
              <router-link :to="{ name: 'Markets' }">
                <span data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show">
                  {{glob.langData[glob.lang].market || "Market"}}
                </span>
              </router-link>
            </span>
          </li>
          <li class="nav-item">
            <span :class="[verifyUrl('/graphes')? 'nav-link active p-0' : 'nav-link p-0']" role="presentation" aria-selected="false" data-bs-toggle="pill" data-bs-target="#pills-graphes">
              <router-link :to="{ name: 'About' }">
                <span data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show">
                  {{glob.langData[glob.lang].about || "About"}}
                </span>
              </router-link>
            </span>
          </li>
        </ul>
        <div class="ms-0 ms-md-2 dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img :alt="glob.lang" :src="require('../assets/img/'+glob.lang+'.svg')" width="30">
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li v-for="l in languages" :key="l" @click="changeLang(l.name)">
              <a class="dropdown-item justify-content-center" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show">
                <img :alt="l.name" class="me-3" :src="require('../assets/img/'+l.image)" width="30">
                <span>{{l.name}}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div id="behinav">
    &nbsp;
  </div>
</div>
</template>

<script>
export default {
  name: "Navbar",
  data(){
    return{
      languages:[
        {"name":"en", "image":"en.svg"},
        {"name":"fr", "image":"fr.svg"}
      ]
    }
  },
  methods: {
    verifyUrl(url){
      if(url == this.$route.fullPath)
        return true
      return false
    },
    changeLang(lang){
      this.glob.lang = lang
    }
  },
};
</script>

<style>
#Navbar .navbar {
  background-color: #101820;
}
#Navbar .brand {
  font-weight: 700;
  background: #f2aa4c;
  color: #101820;
  padding: 4px;
  border-radius: 6px;
}
#Navbar .brand-2 {
  font-weight: 700;
  color: #f2aa4c;
  padding: 4px;
}
#Navbar .nav-pills .nav-link.active{
  background-color: #2DA8D8;
  color: #101820;
}
#Navbar .nav-pills .nav-link.active a span{
  color: #101820;
}
#Navbar .nav-item a span{
  color: white;
  text-decoration: none;
  padding: 7px;
  display: inline-block;
  width: 100%;
}
#Navbar #behinav{
  padding: 21px;
}
</style>