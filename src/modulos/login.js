import { createApp, ref, vuetify } from "../componentes/initVue.js"

createApp({

    setup()
    {
        let tab = ref(null)
        let iconIce = ref("mdi-eye-outline")
        let typeInputPassword = ref("password")
        let pass = ref();
        let samePasssword = ref([ value => value == pass.value || 'Las contraseñas no coinciden'])

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
            pass,
            samePasssword,
            toggleTypeOfInputPassword,
        }

    }

}).use(vuetify).mount("#login")