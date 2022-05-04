<template>
  <div>
    <div class="menu"><navBar /></div>
    <div class="content">
      <h1>{{ this.title }}</h1>
      <div v-html="introText"></div>
      <div v-html="questionsBefore"></div>
      <div v-html="passage"></div>
      <div v-html="questionsAfter"></div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import NavBar from '@/components/NavBar.vue'
import ContentService from '@/services/ContentService.js'
import LogService from '@/services/LogService.js'

export default {
  props: ['hl_id', 'session'],
  computed: mapState(['language', 'user']),
  components: {
    NavBar,
  },
  data() {
    return {
      title: null,
      introText: null,
      questionsBefore: null,
      passage: null,
      questionsAfter: null,
    }
  },
  async created() {
    try {
      var params = this.$route.params
      var resp = await ContentService.get('DBSPage', params)
      this.title = resp.data.title
      this.introText = resp.data.introText
      this.questionsBefore = resp.data.questionsBefore
      this.passage = resp.data.passage
      this.questionsAfter = resp.data.questionsAfter
    } catch (error) {
      LogService.consoleLogError('There was an error in DBS.vue:', error) // Logs out the error
    }
  },
}
</script>
