<template>
  <div id="app">
    <Header :numCorrect="numCorrect" :numTotal="numTotal" />
    <b-container class="bv-example-row">
      <b-row>
          <b-col sm="6" offset="3">
              <Question v-if="question.length" :currentQuestion="question[index]" :next="next" :increment="increment"  />
          </b-col>
      </b-row> 
    </b-container>

  </div>
</template> 

<script>

import Header from './components/Header'
import Question from './components/QuestionBox'

export default {
  name: "App",
  components: {
    Header,
    Question,
  },
  data(){
    return{
      question:[],
      index:0,
      numCorrect: 0,
      numTotal: 0
    }
  },
  methods:{
      next:function(){
        this.index++
      },
      increment(isCorrect){
        if(isCorrect){
          this.numCorrect++
        }
        this.numTotal++
      }
     
  },

  mounted:function() {
    fetch('https://opentdb.com/api.php?amount=10&category=27&type=multiple',{
      method:'get'
    })

    .then((response) =>{
      return response.json()
    })

    .then((jsonData)=>{
      this.question = jsonData.results
    })

  }
};
</script>

<style>
</style>
