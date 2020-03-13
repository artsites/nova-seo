Nova.booting((Vue, router, store) => {
  Vue.component('index-seo-field', require('./components/IndexField'))
  Vue.component('detail-seo-field', require('./components/DetailField'))
  Vue.component('form-seo-field', require('./components/FormField'))
})
