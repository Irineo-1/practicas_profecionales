import { createApp, ref, vuetify } from '../componentes/initVue.js'


createApp({
    setup()
    {
        let step = ref(0)
        let respuestaPrimerPregunta = ref('')
        let tituloApartados = ["Servicio social"]
        
        const CerrarSesion = () =>{ 

        const formData = new FormData();
        formData.append('action','CerrarSesion');

        fetch('controladores/loginSection.php', {
            metho: 'POST',
            body : formData
         })
         .then(CerrarSesion => CerrarSesion.text)
         .the(data => {
            if(data == 1){

                window.location.href = "index.php"
            }

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