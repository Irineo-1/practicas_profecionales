import { createApp, ref, vuetify } from "../componentes/initVue.js"

createApp({
    setup()
    {
        let tab = ref(null)
        let iconIce = ref("mdi-eye-outline")
        let typeInputPassword = ref("password")
        let nombreCompleto = ref("")
        let nombreCompletoRegistro = ref("")
        let passLogin = ref("")
        let passRegister = ref("")
        let passRegisterRepeat = ref("")
        let smsError = ref(false)
        let texto_error = ref("")
        let samePasssword = ref([ value => value == passRegister.value || 'Las contraseñas no coinciden' ])
        let emailRules = ref([value => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
        }])
        let correoRegistro = ref("")
        let correoLogin = ref("")
        let puestos = ref(["Director", "Subdirector", "Jefe de vinculación", "Jefe de oficina"])
        let puesto = ref("")
        let turnos = ref(["Verspertino", "Matutino"])
        let turno = ref("")

        const iniciarSession = () =>
        {
            let form = new FormData()
            form.append("action", "iniciar_maestro")
            form.append("email", correoLogin.value)
            form.append("password", passLogin.value)
            fetch("../../controladores/loginSection.php", {
                method: "POST",
                body: form,
            })
            .then(res => res.text())
            .then((data) => {
                if (data == 1)
                {
                    window.location.href = "indexm.php"
                }
                else
                {
                    texto_error.value = "Error de contraseña"
                    smsError.value = true 
                }
            })
        }
        
        const registrarUsuario = () =>
        {
            let form = new FormData()
            form.append("action", "registrar_maestro")
            form.append("nombre", nombreCompletoRegistro.value)
            form.append("puesto", puesto.value)
            form.append("turno", turno.value)
            form.append("password", passRegister.value)
            fetch("../../controladores/loginSection.php", {
                method: "POST",
                body: form,
            })
            .then(res => res.text())
            .then((data) => {
                if( data == 1 )
                {
                    window.location.href = "indexm.php" // ahora que tiene la session se redirege a la pagina principal
                }
                else
                {
                    texto_error.value = `El usuario ${nombreCompleto.value} ya existe`
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
            nombreCompleto,
            puestos,
            turnos,
            puesto,
            turno,
            nombreCompletoRegistro,
            correoRegistro,
            emailRules,
            correoLogin,
            toggleTypeOfInputPassword,
            iniciarSession,
            registrarUsuario
        }
    }
}).use(vuetify).mount("#loginMaestros")