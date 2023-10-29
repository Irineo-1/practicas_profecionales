import { createApp, ref, vuetify } from "../componentes/initVue.js"

createApp({
    setup()
    {
        let tab = ref(null)
        let iconIce = ref("mdi-eye-outline")
        let typeInputPassword = ref("password")
        let passLogin = ref("")
        let passRegister = ref("")
        let passRegisterRepeat = ref("")
        let smsError = ref(false)
        let texto_error = ref("")
        let samePasssword = ref([ value => value == passRegister.value || 'Las contraseñas no coinciden' ])

        const iniciarSession = () =>
        {

        }
        
        const registrarUsuario = () =>
        {

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

        return {
            tab,
            iconIce,
            typeInputPassword,
            passLogin,
            passRegister,
            passRegisterRepeat,
            smsError,
            texto_error,
            samePasssword,
            toggleTypeOfInputPassword,
            iniciarSession,
            registrarUsuario
        }
    }
}).use(vuetify).mount("#loginMaestros")