<template>
  <div class="question-box-container">
    <b-jumbotron>
      <template #lead>
        {{ currentQuestion.question }}
      </template>

      <hr class="my-4" />

      <b-list-group v-for="(answer, index) in answers" :key="index" >
        <b-list-group-item @click.prevent="selectAnswer(index)" :class="answerClass(index)" >
          {{ answer }}</b-list-group-item
        >
      </b-list-group>

      <b-button @click="submitAnswer" :disabled="selectedIndex === null || answered"  variant="primary" href="#"
        >Submit</b-button
      >&emsp;
      <b-button @click="next" variant="success" href="#">Next</b-button>
    </b-jumbotron>
  </div>
</template>

<script>
 import _ from 'lodash'

export default {
  props: {
    currentQuestion: Object,
    next: Function,
    increment: Function,
  },
  data: function () {
    return {
      selectedIndex: null,
      correctIndex: null,
      nswered: false,
        shuffledAnswers: [],
    };
  },
  watch: {
    currentQuestion: {
      immediate: true,
      handler() {
        this.selectedIndex = null;
        this.answered = false;
        this.shuffleAnswers()
      },
    },
  },
  methods: {
    selectAnswer(index) {
     this.selectedIndex = index;
      console.log(index);
    },
    submitAnswer() {
      let isCorrect = false;
        
      if (this.selectedIndex === this.correctIndex) {
        isCorrect = true;
      }
      this.answered = true
      this.increment(isCorrect);
    },
    shuffleAnswers() {
      let answers = [...this.currentQuestion.incorrect_answers, this.currentQuestion.correct_answer]
      this.shuffledAnswers = _.shuffle(answers)
      this.correctIndex = this.shuffledAnswers.indexOf(this.currentQuestion.correct_answer)
    },
     answerClass(index) {
      let answerClass = ''
      if (!this.answered && this.selectedIndex === index) {
        answerClass = 'selected'
      } else if (this.answered && this.correctIndex === index) {
        answerClass = 'correct'
      } else if (this.answered &&
        this.selectedIndex === index &&
        this.correctIndex !== index
      ) {
        answerClass = 'incorrect'
      }
      return answerClass
    }
  },
  computed: {
    answers() {
      let answers = [...this.currentQuestion.incorrect_answers];
      answers.push(this.currentQuestion.correct_answer);
      return answers;
    },
  },
};
</script>




<style scoped>
.question-box-container {
  text-align: center;
  background-color: rgb(173, 168, 168);
  height: 400px;
  padding-top: 30px;
}
.btn-primary {
  margin-top: 30px;
}
.btn-success {
  margin-top: 30px;
}
.list-group {
  margin-bottom: 3px;
}
.list-group-item:hover {
  background: rgb(250, 166, 136);
  cursor: pointer;
}
.selected {
  background-color: lightblue;
}
.correct {
  background-color: lightgreen;
}
.incorrect {
  background-color: red;
}
</style>