// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  modules: ['@nuxtjs/tailwindcss', '@nuxt/icon'],
  css: ['~/assets/css/main.css'],
  pages: true,
  routeRules: {
    '/': { redirect: '/login' }
  },

  tailwindcss: {
    config: {
      theme: {
        extend: {
          fontFamily: {
            paytone: ['"Paytone One"', 'sans-serif']
          }
        }
      }
    }
  },

  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8000/api'
    }
  },

 
})