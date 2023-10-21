import { createApp, ref, vuetify } from '../componentes/initVue.js'
import { getUser } from '../componentes/user.js'
import { getEmpresas } from '../componentes/instituciones.js'

createApp({
    setup()
    {
        let step = ref(0)
        let respuestaPrimerPregunta = ref('')
        let userName = ref('')
        let constanciaFile = ref([])
        let tituloApartados = ["Servicio social", "Constancia de termino", "Empresas donde deseas hacer tus practicas", "Carta de Presentación"]
        let instituciones = ref([{"entidad_federativa": "", "nombre_empresa": "", "tipo_empresa": "", "tipo_institucion": ""}])
        let item = ref({})

        const CerrarSesion = () =>{ 

            const formData = new FormData();
            formData.append('action','CerrarSesion');

            fetch('controladores/loginSection.php', {
                method: 'POST',
                body : formData
            }).then(res => res.text()).then(data => {
                window.location.href = "index.php"
            })

        }
        
        const subirConstancia = () =>
        {
            const data = new FormData()
            data.append("action", "subir_constancia")
            data.append("file", constanciaFile.value[0])
            data.append("step", step.value + 1)

            fetch("controladores/stepSection.php",{
                method: "POST",
                body: data,
            })
            .then(res => res.text())
            .then(() => {
                step.value ++
            })
        }

        return {
            step,
            tituloApartados,
            respuestaPrimerPregunta,
            userName,
            constanciaFile,
            instituciones,
            item,
            CerrarSesion,
            subirConstancia
        }
    },
    async beforeCreate()
    {
        let user = await getUser()
        this.userName = user[0].nombre_completo
        this.step = parseInt(user[0].numero_proceso)

        this.instituciones = await getEmpresas()
        console.log(this.instituciones)
    }

}).use(vuetify).mount("#paginaPrincipal")