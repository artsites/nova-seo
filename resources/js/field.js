import IndexField from './components/IndexField.vue'
import DetailField from './components/DetailField.vue'
import FormField from './components/FormField.vue'

Nova.booting((Vue, router, store) => {
  Vue.component('index-seo-field', IndexField)
  Vue.component('detail-seo-field', DetailField)
  Vue.component('form-seo-field', FormField)
})
