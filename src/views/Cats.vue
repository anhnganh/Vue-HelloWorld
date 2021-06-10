<template>
   <div>
    <b-table :fields="fields" :items="cats">
      <template #cell(name)="data">
        <!-- `data.value` is the value after formatted by the Formatter -->
         <router-link :to="`/pets/cats/${data.index}`">{{ data.value }}</router-link>
      </template>
    </b-table>
  </div>
</template>
<script>
import { mapState } from 'vuex'
// import cats from '@/data/cats'
export default {
  data () {
    return {
    }
  },
  computed: {
    ...mapState(['cats'])
  }
}
</script>
