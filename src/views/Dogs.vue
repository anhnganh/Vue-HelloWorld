<template>
  <div class="dogs">
      <b-table :fields="fields" :items="dogs">
      <template #cell(name)="data">
        <router-link :to="`/pets/dogs/${data.index}`">{{ data.value }}</router-link>
      </template>
    </b-table>
  </div>
</template>
<script>
// import dogs from '@/data/dogs'
import { mapState } from 'vuex'
export default {
  data () {
    return {}
  },
  computed: {
    ...mapState(['dogs'])
  }
}
</script>
