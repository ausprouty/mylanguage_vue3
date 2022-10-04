<template>
  <div>
    <div class="menu"><navBar /></div>
    <div class="content">
      <h1>{{ this.title }}</h1>
      <div v-html="questions"></div>
      <div>Form</div>
      <div v-html="text"></div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import NavBar from '@/components/NavBar.vue'
import ContentService from '@/services/ContentService.js'
import LogService from '@/services/LogService.js'

export default {
  props: ['hl_id', 'chapter'],
  computed: mapState(['language', 'user']),
  components: {
    NavBar,
  },
  data() {
    return { title: null, questions: null, text: null }
  },
  async created() {
    try {
      var params = this.$route.params
      var resp = await ContentService.get('page/Bible', params)
      this.text = resp.data.text
      this.title = resp.data.title
      this.questions = resp.data.questions
    } catch (error) {
      LogService.consoleLogError('There was an error in Bible.vue:', error) // Logs out the error
    }
  },
}
</script>
