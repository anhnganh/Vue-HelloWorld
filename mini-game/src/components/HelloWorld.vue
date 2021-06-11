<template>
  <div id="app"> 
    <div class="scoreTop" v-show="this.seen ==true">
      <div><h2>Top 10 score high</h2></div>
        <table class="table" border="1">
        <tr>
          <th>Name</th>
          <th>Score</th>
          </tr>
          <tr v-for="(user, index) in userTop.user" :key="index">
              <td>{{user.name}}</td>
              <td>{{user.score}}</td>
          </tr>
      </table>
    </div>
    <div id="myModal" class="modal"> <!--v-show="this.answered === 'abc'" --->
      <form action="" method="POST">
        <div id="abc" class="over">Game over! Your score: 
          <div class="score1">
            <input name="correct" v-model="userData.correct" />
          </div>
          <div class="userName">
                <input type="text"  name="name" v-model="userData.name" placeholder="abc..." />
                <input type="button" value="save" @click="save" />
          </div>
        </div>
      </form>
    </div>
  <div class="container">
        <div class="correct" v-show="this.answered == true">Correct</div>
        
        <div class="score">
          Score: {{this.userData.correct}}
     </div>
     <div class="calculation">
       <span v-show="this.seen ==false" > {{currentQuestion.questContent}}</span>
     </div>
     
     <div class="click">
       Click on the correct answer
     </div>
     <div class="answer">
      <ul class="ul" v-show="this.seen ==false">
         <li v-for="(answer, index) in answers" :key="index">
         <div  class="item" @click="CheckAnswer(currentQuestion.questId, answer)" ><span>{{answer}}</span></div>
         </li>
      </ul>
     </div>
     <div class="function">
        <button class="play" v-on:click="toggleSeen"  >
           {{button.text}}
        </button>
     </div>
       <div class="timer">
        Time remaining : {{countDown}}
     </div>
        
  </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: 'HelloWorld',
  props: {
    userTop:Object,
    currentQuestion: Object,
    fetchNewQuest:Function
  },
  data: function() {
    return{
        answered:false,
        button:{
            text:'StartGame'
        },
        seen: true,
        timer: null,
        countDown : 100,
        resetButton: false,
        userData:{
          name:null,
          correct:0
        }
    }
  },
  methods:{
          save:function(){
              let data = new FormData();
              data.append("name",this.userData.name);
              data.append("score",this.userData.correct);
              axios.post('http://localhost:1337/mini-game/src/api/scores.php?action=insert',data).then((res)=>{
                console.log(res.data);
              }).catch((err)=>{
                console.log(err);
              })
          },
           async getCorrect(answer){
            //  let data = new FormData();
              return await fetch('http://localhost:1337/mini-game/src/api/demo.php?url=/answer',{
                method:'POST',
                body: JSON.stringify(answer)
              })
              .then((res)=>{
              return res.json()
              })
              .then(({ok})=>{
               return ok;
              })
          },
           startTimer: function() {
                this.timer = setInterval(()=>this.countdown(), 1000);
                this.resetButton = true;
            },
            stopTimer: function() {
                clearInterval(this.timer);
                this.timer = null;
                this.resetButton = true; 
            },
            countdown: function() {
                if(this.countDown>0){
                  this.countDown--;
                }
                if(this.countDown==0){
                document.getElementById('myModal').style.display="block"
                // document.body.style.pointerEvents='none'
                }
            },
          async CheckAnswer(questID, answer){ 
           let answer1 = {
             questId: questID,
             content: answer
           };
            console.log(answer1);
           let ok = await this.getCorrect(answer1);
           if(ok){
              console.log('dung')
              this.userData.correct++
               this.fetchNewQuest()
               this.answered = true
          }
          else{
            console.log('sai')
            this.stopTimer()
            //  document.body.style.pointerEvents='none'
             document.getElementById('myModal').style.display="block"
          }
        }
        ,
        toggleSeen:function(){
        this.seen = !this.seen;
        this.button.text = this.seen ? 'StartGame' : 'ResetGame';
          this.startTimer()
          console.log(this.seen)
          if(this.seen==true){
            location.reload()
          }
        },

  },
 
  computed:{
   answers(){
     let answers = this.currentQuestion.answers;
     return answers;
   },
    users(){
      let users = this.usertop.user;
      return users;
    }
  },
 
}
</script>
<style>
.body{
  font-family: 'Times New Roman', Times, serif;
}
.scoreTop{
  font-size: 16px;
  width: 200px;
  float: left;
  height: auto;
  margin-left: 150px;
  background-color: #eeab8d;
  border-radius: 10px;
}
.scoreTop .table {
  margin-top: 20px;
  margin-left: 50px;
}
.myModal form input{ 
  width: 30px;
  height: 30px;
}
.modal{
   display: none;   
   position: fixed;
   z-index: 1; /* Sit on top */
  padding-top: 100px;
   left: 0px;
  top: 0;
  width: 100%; /* Full width */
  height: 100%;
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4)
}
.over .score1{
  float: left;
}
.over{
   background-color: #f3996c;
  /* margin: auto; */
  font-size: 60px;
  color: #cee9f5;
  margin-top: 15px;
  margin-left: 495px;
   padding: 120px;
   text-align: center; 
   height: 200px;
  border: 1px solid #888;
  width: 24%;
  float: left;
}
.container{
  float: left;
  margin-left: 10%;
  text-align: center;
  background: #9dd2ea;
  width: 650px;
  height: 500px;
  border-radius: 3%;
  padding: 20px;
}
.score{
  margin-left: 86%;
   width: 80px;
  height: 35px;
  text-align: center;
  color: brown;
  background: #f1ff92;
  padding-top: 13px;
  box-shadow: 0px 3px #454641;
}
.calculation{
  width: 80%;
  height: 34%;
  background: #9da0ea;
  margin-left: 55px;
  margin-top: 10px;
  box-shadow: 0px 4px #7c80cc;
  font-size: 110px;
  padding-top: 40px;
}
.click{
  background: #b481d9;
  width: 80%;
  height: 7%;
  box-shadow: 0px 4px #8153a8;
  margin-top: 10px;
   margin-left: 55px;
   text-align: center;
   padding-top: 18px;
}

.answer li .item{
  background: #cee9f5;
  text-align: center;
   padding-top: 32px;
  height: 57px;
}
.answer li {
  float: left;
  display: block;
  width: 15%;

  margin-left: 15px;
  border-radius:3px;
  margin-left: 18px;
  margin-right: 32.5px;
  box-shadow: 0px 4px #738ea7;
}



.function .play{
  background: #cee9f5;
  margin-top: 15px;
  margin-left: 40%;
  padding-top: 7px;
  width: 19%;
  border-radius: 3px;
   box-shadow: 0px 4px #b0d0df;
  height: 42px;
  float: left;
}
.timer{
    background: #b0e64c;
    margin-top: 121px;
    padding-right: 20x;
    padding-right: 400;
    margin-left: 448px;
    height: 27px;
    width: 190;
    padding-top: 15px;
    box-shadow: 0 4px #b0d0df;
  /* sa background: #b0e64c; */
}
.correct{
  color: white;
  background: #42e252;
  width: 80px;
  height: 40px;
  margin-left: 290px;
  padding-top: 11px;
  float: left;
 text-align: center;
}

</style>
