<template>
  <div id="app">
     <div></div>  
    <HelloWorld v-if="question.length" :fetchNewQuest="fetchNewQuest" :next="next" :currentQuestion="question[index]" />

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
    fetchNewQuest: function() {
      fetch('http://localhost:1337/mini-game/src/api/demo.php?url=/quest',{
      method:'GET'
    })
    .then((response) =>{
      return response.json()
    })
    .then((jsonData)=>{
       this.question = jsonData
    })
    }
  },
 created:function() {
    fetch('http://localhost:1337/mini-game/src/api/demo.php?url=/quest',{
      method:'GET'
    })
    .then((response) =>{
      return response.json()
    })
    .then((jsonData)=>{
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
