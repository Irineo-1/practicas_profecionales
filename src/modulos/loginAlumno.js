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
        let texto_error = ref("")
        let turnos = ref(["Verspertino", "Matutino"])
        let especialidades = ref(["Medios de comunicacion", "Programacion", "Elecricidad", "Laboratorista quimico", "Ventas", "Contabilidad", "Preparacion de alimentos y bebidas"])
        let turno = ref("")
        let especialidad = ref("")

        const iniciarSession = () =>
        {
            const formData = new FormData();
            formData.append('action','iniciar_Secion');
            formData.append('Numero_usuario',nControlLogin.value);
            formData.append('Contrasena', passLogin.value);

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
                    texto_error.value = "Error de contraseña"
                    smsError.value = true 
                }
            })

        }
         

        const registrarUsuario = () =>
        {
            const formData = new FormData();
            formData.append('action', 'registrar_usuario');
            formData.append('numero_control', nControlRegister.value);
            formData.append('nombre', nombreCompleto.value);
            formData.append('especialidad', especialidad.value);
            formData.append('turno', turno.value);
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
            texto_error,
            turnos,
            turno,
            especialidad,
            especialidades,
            toggleTypeOfInputPassword,
            iniciarSession,
            registrarUsuario,
        }

    }

}).use(vuetify).mount("#login")