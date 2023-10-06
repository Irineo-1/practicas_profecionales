const { createApp, ref } = Vue
const { createVuetify } = Vuetify

const vuetify = createVuetify({
    icons: {
        iconfont: 'mdi',
    },
})

export{
    createApp,
    ref,
    vuetify
}