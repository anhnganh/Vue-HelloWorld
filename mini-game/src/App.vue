<template>
  <div id="app">
   
    <HelloWorld v-if="question.length" :next="next" :currentQuestion="question[index]" />

  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'App',
  data(){
    return{
      question:[],
      index:0,
    }
  },
  components: {
    HelloWorld
  },
  methods:{
    next:function(){
      this.index++
    }
  },
 mounted:function() {
    fetch('http://localhost:1337/mini-game/src/api/api.php',{
      method:'get'
    })
    .then((response) =>{
      return response.json()
    })
    .then((jsonData)=>{
      console.log(this)
      this.question = jsonData
    })
  }
}
</script>

<style>
#app {
  margin-bottom: 30px;
}

</style>
