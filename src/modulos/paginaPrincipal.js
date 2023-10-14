import { createApp, ref, vuetify } from '../componentes/initVue.js'
import getUser from '../componentes/user.js'


createApp({
    setup()
    {
        let step = ref(0)
        let respuestaPrimerPregunta = ref('')
        let tituloApartados = ["Servicio social"]
        let userName = ref('')

        const siguientePaso = () =>
        {
            step.value ++
        }

        return {
            step,
            tituloApartados,
            respuestaPrimerPregunta,
            userName,
            siguientePaso
        }
    },
    async created()
    {
        let user = await getUser()
        this.userName = user[0].nombre_completo
        this.step = user[0].numero_proceso
    }
}).use(vuetify).mount("#paginaPrincipal")