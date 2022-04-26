<template>
  <div>
    <div class="menu"><navBar /></div>
    <div class="content">Read</div>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import NavBar from '@/components/NavBar.vue'


export default {
  props: ['hl_id'],
  computed: mapState(['language', 'user', 'menu']),
  components: {
    NavBar,
  },
  data() {
    return {
      library: [
        {
          id: '',
          book: '',
          title: '',
          folder: '',
          index: '',
          style: process.env.VUE_APP_SITE_STYLE,
          image: process.env.VUE_APP_SITE_IMAGE,
          format: 'series',
          pages: 1,
          instructions: '',
        },
      ],
      image_dir: null,
      images: null,
      loading: false,
      loaded: null,
      error: null,
    }
  },
}
</script>
