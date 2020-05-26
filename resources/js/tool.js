Nova.booting((Vue, router, store) => {
    Vue.component('index-custom-action-field', require('./components/CustomAction/Index'))
    Vue.component('custom-action', require('./components/CustomAction/Action'))
    Vue.component('action-modal', require('./components/CustomAction/ActionModal'))
})
