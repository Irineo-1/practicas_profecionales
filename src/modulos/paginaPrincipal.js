import { createApp, ref, vuetify } from '../componentes/initVue.js'


createApp({
    setup()
    {
        let step = ref(0)
        let respuestaPrimerPregunta = ref('')
        let tituloApartados = ["Servicio social"]

        const siguientePaso = () =>
        {
            step.value ++
        }

        return {
            step,
            tituloApartados,
            respuestaPrimerPregunta,
            siguientePaso
        }
    }
}).use(vuetify).mount("#paginaPrincipal")