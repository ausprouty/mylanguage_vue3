<template>
  <div>
    <div class="navbar"><NavBar /></div>
    <div v-html="text"></div>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import ContentService from '@/services/ContentService.js'
import LogService from '@/services/LogService.js'
import NavBar from '@/components/NavBar.vue'

export default {
  props: ['hl_id'],
  components: {
    NavBar,
  },
  data() {
    return {
      page: null,
      text: null,
    }
  },
  computed: mapState(['language']),

  async created() {
    try {
      var params = this.$route.params
      var resp = await ContentService.get('page/Spirit', params)
      this.text = resp.data
    } catch (error) {
      LogService.consoleLogError('There was an error in Spirit.vue:', error) // Logs out the error
    }
  },
}
</script>
