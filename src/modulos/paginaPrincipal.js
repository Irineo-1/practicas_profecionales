import { createApp, ref, vuetify } from '../componentes/initVue.js'
import getUser from '../componentes/user.js'


createApp({
    setup()
    {
        let step = ref(0)
        let respuestaPrimerPregunta = ref('')
        let userName = ref('')
        let constanciaFile = ref([])
        let tituloApartados = ["Servicio social", "Constancia de termino", "Empresas donde deseas hacer tus practicas", "Carta de Presentación"]
        
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
            console.log(constanciaFile.value[0])
            data.append("action", "subir_constancia")
            data.append("file", constanciaFile.value[0])

            fetch("controladores/stepSection.php",{
                method: "POST",
                body: data,
            })
            .then(res => res.text())
            .then((a) => {
                console.log(a)
            })
        }

        return {
            step,
            tituloApartados,
            respuestaPrimerPregunta,
            userName,
            constanciaFile,
            CerrarSesion,
            subirConstancia
        }
    },
    async created()
    {
        let user = await getUser()
        this.userName = user[0].nombre_completo
        this.step = user[0].numero_proceso
    }

}).use(vuetify).mount("#paginaPrincipal")