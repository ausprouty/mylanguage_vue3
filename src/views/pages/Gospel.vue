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
      var resp = await ContentService.get('GospelPage', params)
      console.log(resp)
      if (typeof resp.data['link'] !== 'undefined') {
        window.location.href = resp.data.link
      } else {
        this.text = resp.data.text
      }
    } catch (error) {
      LogService.consoleLogError('There was an error in Gospel.vue:', error) // Logs out the error
    }
  },
}
</script>
