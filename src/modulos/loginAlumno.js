import { createApp, ref, vuetify } from "../componentes/initVue.js"

createApp({

    setup()
    {
        let tab = ref(null)
        let nControlLogin = ref('')
        let smsError = ref(false)
        let texto_error = ref("")

        const iniciarSession = () =>
        {
            const formData = new FormData();
            formData.append('action','iniciar_Secion');
            formData.append('Numero_usuario',nControlLogin.value);

            fetch('controladores/loginSection.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data =>  {
                if (data == 1)
                {
                    window.location.href = "index.php"             
                }
                else
                {
                    texto_error.value = "Numero de control erroneo"
                    smsError.value = true 
                }
            })

        }

        return{
            tab,
            nControlLogin,
            smsError,
            texto_error,
            iniciarSession,
        }

    }

}).use(vuetify).mount("#login")