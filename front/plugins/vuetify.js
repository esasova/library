import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

export default {
  theme: {
    options: {
      customProperties: true
    },
    dark: false,
    themes: {
      light: {
        base: '#173753',
        primary: '#258ea6',
        secondary: '##DADAD9',
        accent: '#9E2A2B'
      }
    },
    icons: {
      iconfont: 'md'
    }
  }
}
