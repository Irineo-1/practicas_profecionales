import { createApp, ref, vuetify } from "../componentes/initVue.js"

createApp({

    setup()
    {
        let tab = ref(null)
        let iconIce = ref("mdi-eye-outline")
        let typeInputPassword = ref("password")
        let passRegister = ref('')
        let passRegisterRepeat = ref('')
        let nombreCompleto = ref('')
        let nControlLogin = ref('')
        let nControlRegister = ref('')
        let passLogin = ref('')
        let smsError = ref(false)
        let samePasssword = ref([ value => value == passRegister.value || 'Las contraseñas no coinciden' ])

        const iniciarSession = () =>
        {
            console.log(nControlLogin.value)
            console.log(samePasssword.value)
        }

        const registrarUsuario = () =>
        {
            const formData = new FormData();
            formData.append('action', 'registrar_usuario');
            formData.append('numero_control', nControlRegister.value);
            formData.append('nombre', nombreCompleto.value);
            formData.append('password', passRegister.value);
            
            fetch('controladores/loginSection.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text())
            .then(data => {
                if( data == 0 )
                {
                    window.location.href = "index.php" // ahora que tiene la session se redirege a la pagina principal
                }
                else
                {
                    smsError.value = true
                }
            })
        }

        const toggleTypeOfInputPassword = () =>
        {
            if( iconIce.value == "mdi-eye-outline" )
            {
                typeInputPassword.value = "text"
                iconIce.value = "mdi-eye-off-outline"
            }
            else
            {
                typeInputPassword.value = "password"
                iconIce.value = "mdi-eye-outline"
            }
        }

        return{
            tab,
            iconIce,
            typeInputPassword,
            passRegister,
            passRegisterRepeat,
            nControlLogin,
            nControlRegister,
            passLogin,
            samePasssword,
            nombreCompleto,
            smsError,
            toggleTypeOfInputPassword,
            iniciarSession,
            registrarUsuario,
        }

    }

}).use(vuetify).mount("#login")