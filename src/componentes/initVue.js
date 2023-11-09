const { createApp, ref, computed, watch } = Vue
const { createVuetify } = Vuetify

const vuetify = createVuetify({
    icons: {
        iconfont: 'mdi',
    },
})

export{
    createApp,
    ref,
    computed,
    vuetify,
    watch
}