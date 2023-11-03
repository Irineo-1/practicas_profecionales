import { createApp, ref, computed, vuetify } from '../componentes/initVue.js'
import { getMaestro } from '../componentes/maestros.js'
import { getUsers } from '../componentes/user.js'
import { getDocuments } from '../componentes/user.js'

createApp({
    setup()
    {
        let nombreMaestro = ref("")
        let alumnos = ref([])
        let puesto = ref("")
        let turno = ref("")
        let buscarAlumno = ref("")
        let sinServicio = ref(false)
        let vista = ref(0)
        let DOCconstancia_temino_servicio = ref([])
        let DOCsolicitud = ref([])
        let DOCcarta_precentacion = ref([])
        let DOCfirmado = ref([])
        let panel = ref([])
        let nombreAlumnoSeleccionado = ref("")
        let idAlumnoSeleccionado = ref(0)
        let nuevaPassword = ref("")
        let textoAlerta = ref("")
        let infoAccion = ref(false)
        let showAlerta = ref(false)
        let tipoAlerta = ref("")

        let cpmAlumnos = computed(() => {
            if( sinServicio.value ) return alumnos.value.filter(el => el.numero_proceso == 0)
            return alumnos.value.filter(el => el.nombre_completo.toLowerCase().includes(buscarAlumno.value.toLowerCase()))
        })

        const CerrarSesion = () =>
        {
            const formData = new FormData();
            formData.append('action','CerrarSesion')
      
            fetch('../../controladores/loginSection.php', {
                method: 'POST',
                body : formData
            }).then(res => res.text()).then(() => {
                window.location.href = "indexm.php"
            })
        }

        const seeDocuments = async ( nControl, currentAlumno ) =>
        {
            nombreAlumnoSeleccionado.value = currentAlumno
            let TotalFiles = await getDocuments(nControl)
            DOCconstancia_temino_servicio.value = TotalFiles.filter(el => el.proceso == "constancia_termino") || []
            DOCsolicitud.value = TotalFiles.filter(el => el.proceso == "solicitud") || []
            DOCcarta_precentacion.value = TotalFiles.filter(el => el.proceso == "carta_precentacion") || []
            DOCfirmado.value = TotalFiles.filter(el => el.proceso.includes('firmado')) || []

            TotalFiles = []

            vista.value = 1
        }

        const downloadDocument = ( nameDocument, proceso ) =>
        {
            fetch(`../../archivosGuardados/${nameDocument}`)
            .then(res => res.blob()).then((data) => {
                const url = window.URL.createObjectURL(new Blob([data]))
                const link = document.createElement('a')
                let extencion = nameDocument.match(/(?:\.([^.]+))?$/)[0]
                link.href = url
                link.setAttribute('download', `${nombreAlumnoSeleccionado.value}_${proceso}${extencion}`);
                document.body.appendChild(link)
                link.click()
            })
        }

        const getAlumnoSelected = (id, nameAlumno) =>
        {
            idAlumnoSeleccionado.value = id
            nombreAlumnoSeleccionado.value = nameAlumno
            vista.value = 2
        }

        const actualizarAlumno = () =>
        {
            if( nuevaPassword.value.trim() == '' )
            {
                textoAlerta.value = "La contraseña esta vacia"
                infoAccion.value = false
                tipoAlerta.value = "error"
                showAlerta.value = true
            }
            else
            {
                const formData = new FormData();
                formData.append('action', 'update_alumno')
                formData.append('id', 'update_alumno')
                formData.append('nombre', 'update_alumno')
                formData.append('pass', 'update_alumno')
                
                fetch('../../controladores/loginSection.php', {
                    method: 'POST',
                    body : formData
                }).then(res => res.text()).then(() => {
                    infoAccion.value = false
                    textoAlerta.value = "Se actualizo correctamente"
                    tipoAlerta.value = "success"
                    showAlerta.value = true
                })
            }
        }

        return {
            nombreMaestro,
            puesto,
            turno,
            alumnos,
            buscarAlumno,
            cpmAlumnos,
            sinServicio,
            vista,
            panel,
            DOCconstancia_temino_servicio,
            DOCsolicitud,
            DOCcarta_precentacion,
            nombreAlumnoSeleccionado,
            idAlumnoSeleccionado,
            nuevaPassword,
            DOCfirmado,
            infoAccion,
            showAlerta,
            textoAlerta,
            tipoAlerta,
            CerrarSesion,
            seeDocuments,
            downloadDocument,
            getAlumnoSelected,
            actualizarAlumno
        }
    },
    async created()
    {
        let maestro = await getMaestro()
        this.alumnos = await getUsers()
        this.nombreMaestro = maestro[0].nombre
        this.puesto = maestro[0].puesto
        this.turno = maestro[0].turno
    }
}).use(vuetify).mount("#gestion")