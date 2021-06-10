<template>
  <div class="dogs">
      {{ animal.name }}
  </div>
</template>
<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState(['cats', 'dogs'])
  },
  methods: {
    pet () {
      const animal = this[this.$route.params.species][this.$route.params.id]
      return animal
    }
  }
}
</script>
