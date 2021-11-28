import colors from 'vuetify/es5/util/colors'

export default {
  mode: 'spa',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s - front',
    title: 'front',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      {
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons'
      }
    ]
  },
  dayjs: {
    locales: ['fr'],
    defaultLocale: 'fr',
    defaultTimeZone: 'utc',
    plugins: ['utc', 'timezone', 'isBetween']
  },
  auth: {
    strategies: {
      local: {
        user: {
          property: ''
        },
        endpoints: {
          login: { url: 'http://localhost:8000/api/login_check', method: 'post', propertyName: 'token' },
          user: { url: 'http://localhost:8000/api/users/me', method: 'get', propertyName: 'data' },
          logout: false
        }
      }
    }
  },
  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '~/assets/style/app.scss'
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/dayjs',
    '@nuxtjs/auth-next'
  ],

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: false,
      themes: {
        light: {
          base: '#173753',
          primary: '#258ea6',
          secondary: '##DADAD9',
          accent: '#9E2A2B',
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
