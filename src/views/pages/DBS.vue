<template>
  <div>
    <div class="menu"><navBar /></div>
    <div class="content">
      <h1 class="centered">{{ this.title }}</h1>

      <div v-html="introText"></div>
      <hr />
      <div id="study_navigation">
        <div id="study_navigation_backwards">
          <img
            src="back_blue_24x24.png"
            @click="changeSession(this.backwards)"
          />
        </div>
        <div id="study_navigation_forwards">
          <img
            src="back_blue_24x24.png"
            @click="changeSession(this.forwards)"
          />
        </div>
      </div>
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
      sessionShown: 1,
      backwards: -1,
      forwards: 1,
    }
  },
  methods: {
    async changeSession(change) {
      this.sessionShown = this.sessionShown + change
      console.log(this.sessionShown)
      var params = {}
      params.hl_id = this.$route.params.hl_id
      params.session = this.sessionShown
      var resp = await ContentService.get('resources/dbs/passage', params)
      this.passage = resp.data
    },
  },
  async created() {
    try {
      var params = this.$route.params
      if (this.$route.params.session !== '') {
        this.sessionShown = this.$route.params.session
      }
      console.log(params)
      var resp = await ContentService.get('page/DBS', params)
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
<style>
.centered {
  text-align: center;
}
</style>
