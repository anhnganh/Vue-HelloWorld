<template>
  <div id="app">
     <div></div>  
    <HelloWorld v-if="question.length" :fetchNewQuest="fetchNewQuest" :userTop="userTop[index]" :currentQuestion="question[index]" />
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
      userTop:[]
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
  },
  mounted:function(){
    fetch('http://localhost:1337/mini-game/src/api/scores.php?action=list',{
      method:'GET'
    })
    .then((res)=>{
      return res.json()
    })
    .then((jsondata)=>{
      console.log(jsondata);
      this.userTop = jsondata;
    })
  }
}
</script>

<style>
#app {
  margin-bottom: 30px;
}

</style>
