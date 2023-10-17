import { createApp, ref, vuetify } from '../componentes/initVue.js'


createApp({
    setup()
    {
        let step = ref(0)
        let respuestaPrimerPregunta = ref('')
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
        const siguientePaso = () =>
        
        {
            step.value ++
        }

        return {
            step,
            tituloApartados,
            respuestaPrimerPregunta,
            CerrarSesion,
            siguientePaso
        }
    }

}).use(vuetify).mount("#paginaPrincipal")