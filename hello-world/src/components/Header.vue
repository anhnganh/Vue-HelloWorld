<template>
  <div id="header">
    <div>
      <b-nav tabs>
        <b-nav-item disabled><b>Fancy Quiz App</b></b-nav-item>
        <b-nav-item disabled>Counter: {{numCorrect}}/{{numTotal}}</b-nav-item>
      </b-nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "header",
  props:[
    'numCorrect',
    'numTotal'
  ]
};

</script>

<style scoped>
#header{
    margin-left: 20px;
    margin-top: 10px;
}
</style>