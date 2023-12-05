import { createApp, ref, computed, watch, vuetify } from '../componentes/initVue.js'
import { getMaestro, getMaestros } from '../componentes/maestros.js'
import { getUsers } from '../componentes/user.js'
import { getDocuments } from '../componentes/user.js'

createApp({
    setup()
    {
        let nombreMaestro = ref("")
        let maestros = ref([])
        let alumnos = ref([])
        let puesto = ref("")
        let turno = ref("")
        let buscarAlumno = ref("")
        let sinServicio = ref(false)
        let vista = ref(0)
        let DOCconstancia_temino_servicio = ref([])
        let DOCsolicitud = ref([])
        let DOCcarta_aceptacion = ref([])
        let DOCfirmado = ref([])
        let panel = ref([])
        let nombreAlumnoSeleccionado = ref("")
        let idAlumnoSeleccionado = ref(0)
        let nControlMD = ref("")
        let turnoSelecReport = ref("")
        let condicionReporte = ref("")
        let texto_error = ref("")
        let vistaAddInstitucion = ref("alumnos")
        let showAlertAddIns = ref(false)
        let generarReporteMDL = ref(false)
        let smsError = ref(false)
        let uploadAlumnos = ref(false)
        let DGdeleteTrabajadores = ref(false)
        let especialidadSeleccionada = ref("")
        let statusSolicitud = ref(100)
        let statusCartaAceptacion = ref(100)
        let idDocumentoSolicitud = ref(100)
        let idDocumentoCartaAceptacion = ref(100)
        let DOCcarta_liberacion = ref([])
        let alumnosExcel = ref([])
        let turnos = ref(["Verspertino", "Matutino"])
        let especialidades = ref(["Medios de comunicacion", "Programacion", "Elecricidad", "Laboratorista quimico", "Ventas", "Contabilidad", "Preparacion de alimentos y bebidas"])
        let emailRules = ref([value => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        }])
        let estados = ref([{
            "estado": "Aprobado",
            "value": 2
        },
        {
            "estado": "En espera",
            "value": 1
        },
        {
            "estado": "Rechazado",
            "value": 0
        }])

        let cpmAlumnos = computed(() => {
            if( sinServicio.value ) return alumnos.value.filter(el => el.numero_proceso == 0)
            return alumnos.value.filter(el => el.nombre_completo.toLowerCase().includes(buscarAlumno.value.toLowerCase()))
        })

        let adNombreInstitucion = ref("")
        let adNombreTitular = ref("")
        let adPuestoTitular = ref("")
        let adRfc = ref("")
        let adDireccion = ref("")
        let adTelefono = ref("")
        let adCorreo = ref("")
        let adNombreTestigo = ref("")
        let adPuestoTestigo = ref("")
        let adEntidadFederativa = ref("")
        let adClaveCentro = ref("")
        let adTipoInstitucion = ref("")

        watch(statusSolicitud, (antVal, prevVal) => {
            if ( prevVal == 100 ) return
            let form = new FormData()
            form.append('action', 'update_estatus_documento')
            form.append('estatus', antVal)
            form.append('id', idDocumentoSolicitud.value)

            fetch("../../controladores/informacionUser.php", {
                method: "POST",
                body: form,
            })
        })

        watch(statusCartaAceptacion, (antVal, prevVal) => {
            if ( prevVal == 100 ) return
            let form = new FormData()
            form.append('action', 'update_estatus_documento')
            form.append('estatus', antVal)
            form.append('id', idDocumentoCartaAceptacion.value)

            fetch("../../controladores/informacionUser.php", {
                method: "POST",
                body: form,
            })
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
            DOCcarta_aceptacion.value = TotalFiles.filter(el => el.proceso == "carta_aceptacion") || []
            DOCcarta_liberacion.value = TotalFiles.filter(el => el.proceso == "carta_liberacion") || []
            DOCfirmado.value = TotalFiles.filter(el => el.proceso.includes('firmado')) || []

            if(DOCsolicitud.value.length > 0)
            {
                statusSolicitud.value = parseInt(DOCsolicitud.value[0].estatus)
                idDocumentoSolicitud.value = parseInt(DOCsolicitud.value[0].id)
            }

            if(DOCcarta_aceptacion.value.length > 0)
            {
                statusCartaAceptacion.value = parseInt(DOCcarta_aceptacion.value[0].estatus)
                idDocumentoCartaAceptacion.value = parseInt(DOCcarta_aceptacion.value[0].id)
            }

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

        const getAlumnoSelected = (id, nameAlumno, numeroControl) =>
        {
            idAlumnoSeleccionado.value = id
            nombreAlumnoSeleccionado.value = nameAlumno
            nControlMD.value = numeroControl
            vista.value = 2
        }

        const actualizarAlumno = () =>
        {
            if( nControlMD.value.trim() == '' )
            {
                Swal.fire("El número de control no puede ser vacío", "", "info");
            }
            else
            {
                Swal.fire({
                title: `¿Quieres actualizar a ${nombreAlumnoSeleccionado.value}?`,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Actualizar",
                denyButtonText: `No actualizar`
                }).then((result) => {
                    if (result.isConfirmed)
                    {
                        const formData = new FormData();
                        formData.append('action', 'update_alumno')
                        formData.append('id', idAlumnoSeleccionado.value)
                        formData.append('nombre', nombreAlumnoSeleccionado.value)
                        formData.append('numeroControl', nControlMD.value)
                        
                        fetch('../../controladores/informacionUser.php', {
                            method: 'POST',
                            body : formData
                        }).then(res => res.text()).then( async () => {
                            Swal.fire(`Se actualizo correctamente a ${nombreAlumnoSeleccionado.value}`, "", "success");
                            vista.value = 0
                            alumnos.value = await getUsers()
                        })
                    }
                    else if (result.isDenied)
                    {
                        Swal.fire("Accion cancelada", "", "info");
                    }
                })
            }
        }

        const eliminarAlumno = () =>
        {
            Swal.fire({
            title: `¿Quieres eliminar a ${nombreAlumnoSeleccionado.value}?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Eliminar",
            denyButtonText: `No eliminar`
            }).then((result) => {
                if (result.isConfirmed)
                {
                    const formData = new FormData();
                    formData.append('action', 'delete_alumno')
                    formData.append('id', idAlumnoSeleccionado.value)
                    
                    fetch('../../controladores/informacionUser.php', {
                        method: 'POST',
                        body : formData
                    }).then(res => res.text()).then( async () => {
                        alumnos.value = alumnos.value.filter(el => el.id != idAlumnoSeleccionado.value)
                        vista.value = 0
                        alumnos.value = await getUsers()
                    })
                    Swal.fire(`Se elimino correctamente a ${nombreAlumnoSeleccionado.value}`, "", "success");
                }
                else if (result.isDenied)
                {
                    Swal.fire("Accion cancelada", "", "info");
                }
            })
        }

        const goToFiles = () =>
        {
            window.location.href = "gestionPlantillas.php"
        }

        const guardarInstitucion = () =>
        {
            showAlertAddIns.value = false
          const data = new FormData()
          data.append("action", "guardar_institucion")
          data.append("adNombreInstitucion", adNombreInstitucion.value)
          data.append("adNombreTitular", adNombreTitular.value)
          data.append("adPuestoTitular", adPuestoTitular.value)
          data.append("adRfc", adRfc.value)
          data.append("adDireccion", adDireccion.value)
          data.append("adTelefono", adTelefono.value)
          data.append("adCorreo", adCorreo.value)
          data.append("adNombreTestigo", adNombreTestigo.value)
          data.append("adPuestoTestigo", adPuestoTestigo.value)
          data.append("adEntidadFederativa", adEntidadFederativa.value)
          data.append("adClaveCentro", adClaveCentro.value)
          data.append("adTipoInstitucion", adTipoInstitucion.value)
    
          fetch("../../controladores/stepSection.php",{
              method: "POST",
              body: data,
          })
          .then(res => res.text())
          .then(() => {
            Swal.fire(`Se agrego correctamente`, "", "success");
            showAlertAddIns.value = true
            adNombreInstitucion.value = ""
            adNombreTitular.value = ""
            adPuestoTitular.value = ""
            adRfc.value = ""
            adDireccion.value = ""
            adTelefono.value = ""
            adCorreo.value = ""
            adNombreTestigo.value = ""
            adPuestoTestigo.value = ""
            adEntidadFederativa.value = ""
            adClaveCentro.value = ""
            adTipoInstitucion.value = ""
          })
        }

        const generarReporteAlumnos = () =>
        {
            let form = new FormData()
            form.append("action", "generar_reporte_alumnos")
            form.append("turno", turnoSelecReport.value)
            form.append("condicion", condicionReporte.value)

            fetch("../../controladores/informacionUser.php", {
                method: "POST",
                body: form
            })
            .then(res => res.text())
            .then(nameDocument => {
                if( nameDocument == 1 )
                {
                    smsError.value = true
                    texto_error.value = "No hay registros para esta consulta"
                }
                else
                {
                    fetch(`../../templatesDocumentos/${nameDocument}`)
                    .then(res => res.blob())
                    .then(async (data) => {
                        const url = window.URL.createObjectURL(new Blob([data]))
                        const link = document.createElement('a')
                        link.href = url
                        link.setAttribute('download', nameDocument);
                        document.body.appendChild(link)
                        link.click()
            
                        let form = new FormData()
                        form.append("action", "eliminar_documento")
                        form.append("archivo", nameDocument)
                        fetch(`../../controladores/stepSection.php`,{
                          method: "POST",
                          body: form,
                        })
                    })
                }
            })
        }

        const guardarAlumnos = () =>
        {
            const data = new FormData()
            data.append("action", "agregar_alumnos")
            data.append("file", alumnosExcel.value[0])
            data.append("turno", turnoSelecReport.value)
            data.append("especialidad", especialidadSeleccionada.value)

            fetch("../../controladores/informacionUser.php", {
                method: "POST",
                body: data
            })
            .then(res => res.text())
            .then( async (nameDocument) => {
                uploadAlumnos.value = false
                alumnosExcel.value = []
                turnoSelecReport.value = ""
                especialidadSeleccionada.value = ""
                alumnos.value = await getUsers()

                let form = new FormData()
                form.append("action", "eliminar_documento")
                form.append("archivo", nameDocument)
                fetch(`../../controladores/stepSection.php`,{
                  method: "POST",
                  body: form,
                })
            })
        }

        const deleteMaestro = ( id, puesto, nombre ) =>
        {
            Swal.fire({
            title: `¿Quieres eliminar al ${puesto} ${nombre}?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Eliminar",
            denyButtonText: `No eliminar`
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('action', 'delete_maestro')
                    formData.append('id', id)
                    
                    fetch('../../controladores/informacionUser.php', {
                        method: 'POST',
                        body : formData
                    }).then(res => res.text()).then( async () => {
                        Swal.fire(`Se elimino correctamente a ${nombre}`, "", "success");
                        maestros.value = maestros.value.filter(el => el.id != id)
                    })
                } else if (result.isDenied) {
                    Swal.fire("Accion cancelada", "", "info");
                }
            })
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
            DOCcarta_aceptacion,
            nombreAlumnoSeleccionado,
            idAlumnoSeleccionado,
            nControlMD,
            DOCfirmado,
            statusSolicitud,
            estados,
            statusCartaAceptacion,
            vistaAddInstitucion,
            adTipoInstitucion,
            adClaveCentro,
            adEntidadFederativa,
            adPuestoTestigo,
            adNombreTestigo,
            adCorreo,
            adTelefono,
            adDireccion,
            adRfc,
            adPuestoTitular,
            adNombreTitular,
            adNombreInstitucion,
            emailRules,
            showAlertAddIns,
            DOCcarta_liberacion,
            generarReporteMDL,
            turnoSelecReport,
            condicionReporte,
            turnos,
            smsError,
            texto_error,
            especialidades,
            especialidadSeleccionada,
            uploadAlumnos,
            DGdeleteTrabajadores,
            alumnosExcel,
            maestros,
            CerrarSesion,
            seeDocuments,
            downloadDocument,
            getAlumnoSelected,
            actualizarAlumno,
            goToFiles,
            guardarInstitucion,
            generarReporteAlumnos,
            guardarAlumnos,
            eliminarAlumno,
            deleteMaestro,
        }
    },
    async created()
    {
        let maestro = await getMaestro()
        this.alumnos = await getUsers()
        this.maestros = await getMaestros()
        this.nombreMaestro = maestro[0].nombre
        this.puesto = maestro[0].puesto
        this.turno = maestro[0].turno
    }
}).use(vuetify).mount("#gestion")