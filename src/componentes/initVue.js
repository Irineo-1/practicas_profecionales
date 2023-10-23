const { createApp, ref, computed } = Vue
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
    vuetify
}