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
            formData.append('numero_control', nControlRegister);
            formData.append('nombre', nombreCompleto);
            formData.append('password', passRegister);
            
            fetch('controladores/loginSection.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error(error));
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
            toggleTypeOfInputPassword,
            iniciarSession,
            registrarUsuario,
        }

    }

}).use(vuetify).mount("#login")