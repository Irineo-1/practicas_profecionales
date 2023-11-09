import { createApp, ref, computed, vuetify } from '../componentes/initVue.js'
import { getUser } from '../componentes/user.js'
import { getEmpresas } from '../componentes/instituciones.js'
import { getDirectores } from '../componentes/maestros.js'

createApp({
  setup()
  {
    let step = ref(0)
    let respuestaPrimerPregunta = ref('')
    let userName = ref('')
    let archivo = ref([])
    let tituloApartados = ["Servicio social",
    "Constancia de termino",
    "Institucion donde deseas hacer tus practicas",
    "Solicitud de practicas profecionales",
    "Carta de precentación", "Final"]
    let meses = ref(["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"])
    let directorAcargo = ref('')
    let instituciones = ref([])
    let solicitudFile = ref([])
    let buscarEmpresa = ref("")
    let verInformacionEmpresa = ref(false)
    let directores = ref([])
    let fechaInicio = ref("")
    let fechaFin = ref("")
    let showFormAddInstitucion = ref(false)
    let emailRules = ref([value => {
      const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return pattern.test(value) || 'Invalid e-mail.'
    }])
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
    
    let mensajeStatusDocumentos = ref("")
    let statusSolicitud = ref(0)
    let statusCartaAceptacion = ref(0)
    let idDocumentoSolicitud = ref(0)
    let nombreDocumentoSolicitud = ref("")
    let idDocumentoCartaAceptacion = ref(0)
    let nombreDocumentoCartaAceptacion = ref("")

    let resolveInstituciones = computed(() => {
      return instituciones.value.filter( el => el.nombre_empresa.toLowerCase().includes(buscarEmpresa.value.toLowerCase()) )
    })

    const CerrarSesion = () =>{ 

      const formData = new FormData();
      formData.append('action','CerrarSesion');

      fetch('controladores/loginSection.php', {
          method: 'POST',
          body : formData
      }).then(res => res.text()).then(data => {
          window.location.href = "index.php"
      })

    }
    
    const subirArchivo = ( proceso ) =>
    {
      const data = new FormData()
      data.append("action", "subir_archivo")
      data.append("file", archivo.value[0])
      data.append("step", step.value + 1)
      data.append("proceso", proceso)

      fetch("controladores/stepSection.php",{
          method: "POST",
          body: data,
      })
      .then(res => res.text())
      .then(async () => {
        archivo.value = []
        
        if( proceso != "solicitud" && proceso != "carta_aceptacion" ) step.value ++
        
        let statusSD = await getStatusDocumento(proceso)
        statusSolicitud.value = statusSD[0].estatus
        idDocumentoSolicitud.value = statusSD[0].id
        nombreDocumentoSolicitud.value = statusSD[0].nombre_documento

        let statusCAD = await getStatusDocumento(proceso)
        statusCartaAceptacion.value = statusCAD[0].estatus
        idDocumentoCartaAceptacion.value = statusCAD[0].id
        nombreDocumentoCartaAceptacion.value = statusCAD[0].nombre_documento

        statusSD = []
        mensajeStatusDocumentos.value = "Para poder continuar una persona ahotorizada tendra que revisar el documento proporcionado"
      })
    }
 
    const seleccionarEmpresa = id =>
    {
      let form = new FormData()
      form.append("action", "generar_solicitud")
      form.append("id", id)
      form.append("step", step.value + 1)
      fetch("controladores/stepSection.php", {
        method: "POST",
        body: form,
      })
      .then(res => res.text())
      .then(nameDocument => {
        fetch(`templatesDocumentos/${nameDocument}`)
        .then(res => res.blob()).then((data) => {
            const url = window.URL.createObjectURL(new Blob([data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `PPSolicitudPracticasProfecionales.doc`);
            document.body.appendChild(link)
            link.click()

            let form = new FormData()
            form.append("action", "eliminar_documento")
            form.append("archivo", nameDocument)
            fetch(`controladores/stepSection.php`,{
              method: "POST",
              body: form,
            })
            statusSolicitud.value = 3
            step.value ++
        })
      })
    }
 
    const descargarCartaPrecentacion = () =>
    {
      let today = new Date()
      let formatoToday = `${today.getDate()}/${today.getMonth() + 1}/${today.getFullYear()}`
      let arrFechaFinDes = fechaFin.value.split("-")
      let arrFechaInicioDes = fechaInicio.value.split("-")
      let fechaFinWF = `${arrFechaFinDes[2]} de ${meses.value[parseInt(arrFechaFinDes[1])-1]} del ${arrFechaFinDes[0]}`
      let fechaInicioWF = `${arrFechaInicioDes[2]} de ${meses.value[parseInt(arrFechaInicioDes[1])-1]} del ${arrFechaInicioDes[0]}`
      let form = new FormData()

      form.append("action", "generar_carta_presentacion")
      form.append("hoy", formatoToday)
      form.append("inicio", fechaInicioWF)
      form.append("fin", fechaFinWF)
      form.append("director", directorAcargo.value)
      form.append("nombreAlumno", userName.value)
      fetch("controladores/stepSection.php", {
        method: "POST",
        body: form,
      })
      .then(res => res.text())
      .then(nameDocument => {
        fetch(`templatesDocumentos/${nameDocument}`)
        .then(res => res.blob())
        .then((data) => {
            const url = window.URL.createObjectURL(new Blob([data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `CPCartaDePresentacion.doc`);
            document.body.appendChild(link)
            link.click()

            let form = new FormData()
            form.append("action", "eliminar_documento")
            form.append("archivo", nameDocument)
            fetch(`controladores/stepSection.php`,{
              method: "POST",
              body: form,
            })
        })
      })
    }

    const generarConvenio = () =>
    {
      const data = new FormData()
      data.append("action", "generar_convenio")
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

      fetch("controladores/stepSection.php",{
          method: "POST",
          body: data,
      })
      .then(res => res.text())
      .then((nameDocument) => {
        fetch(`templatesDocumentos/${nameDocument}`)
        .then(res => res.blob())
        .then(async (data) => {
            const url = window.URL.createObjectURL(new Blob([data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `Convenio.doc`);
            document.body.appendChild(link)
            link.click()

            let form = new FormData()
            form.append("action", "eliminar_documento")
            form.append("archivo", nameDocument)
            fetch(`controladores/stepSection.php`,{
              method: "POST",
              body: form,
            })
            showFormAddInstitucion.value = false
            instituciones.value = await getEmpresas()
        })
      })
    }

    const updateStep = () =>
    {
      let form = new FormData()
      form.append("action", "update_step")
      form.append("step", step.value + 1)

      fetch("controladores/stepSection.php", {
        method: "POST",
        body: form,
      })
      
      step.value ++
    }

    const cleanProcess = ( proceso ) =>
    {
      let form = new FormData()
      form.append("action", "clean_process")
      form.append("proceso", proceso)
      if( proceso == "solicitud" )
      {
        form.append("nombreArchivo", nombreDocumentoSolicitud.value)
      }
      else
      {
        form.append("nombreArchivo", nombreDocumentoCartaAceptacion.value)
      }

      fetch("controladores/stepSection.php", {
        method: "POST",
        body: form,
      })

      statusSolicitud.value = 3
      idDocumentoSolicitud.value = 0
      nombreDocumentoSolicitud.value = ""

      statusCartaAceptacion.value = 3
      idDocumentoCartaAceptacion.value = 0
      nombreDocumentoCartaAceptacion.value = ""
    }

    const getStatusDocumento = ( proceso ) =>
    {
      return new Promise((resolve) => {
        let form = new FormData()
        form.append("action", "get_status_document")
        form.append("process", proceso)
  
        fetch("controladores/stepSection.php", {
          method: "POST",
          body: form,
        })
        .then(res => res.text())
        .then(data => {
          resolve(JSON.parse(data))
        })
      })
    }

    const goToInformes = () =>
    {
      window.location.href = "src/vistas/informes.php"
    }

    const goToDocumentos = () =>
    {
      window.location.href = "src/vistas/documentosAlumno.php"
    }

    return {
      step,
      tituloApartados,
      respuestaPrimerPregunta,
      userName,
      archivo,
      instituciones,
      buscarEmpresa,
      resolveInstituciones,
      verInformacionEmpresa,
      solicitudFile,
      directores,
      fechaInicio,
      fechaFin,
      directorAcargo,
      showFormAddInstitucion,
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
      statusSolicitud,
      idDocumentoSolicitud,
      nombreDocumentoSolicitud,
      statusCartaAceptacion,
      mensajeStatusDocumentos,
      idDocumentoCartaAceptacion,
      nombreDocumentoCartaAceptacion,
      CerrarSesion,
      seleccionarEmpresa,
      subirArchivo,
      descargarCartaPrecentacion,
      goToInformes,
      goToDocumentos,
      generarConvenio,
      updateStep,
      cleanProcess,
      getStatusDocumento
    }
  },
  async beforeCreate()
  {
    let smsInfo = "Para poder continuar una persona ahotorizada tendrá que revisar el documento proporcionado, puedes acercarte a una persona ahotorizada para que revise tu documento."
    let smsRechasado = "Lo sentimos, el documento fue rechazado porque no cumple con las características requeridas."
    let smsAceptado = "Tu documento fue aceptado."

    let user = await getUser("controladores/informacionUser.php")
    this.userName = user[0].nombre_completo
    this.step = parseInt(user[0].numero_proceso)
    user = []

    let statusSD = await this.getStatusDocumento("solicitud")
    let statusCAD = await this.getStatusDocumento("carta_aceptacion")
    
    if( statusSD.length == 0 )
    {
      this.statusSolicitud = 3
    }
    else
    {
      this.statusSolicitud = statusSD[0].estatus
      this.idDocumentoSolicitud = statusSD[0].id
      this.nombreDocumentoSolicitud = statusSD[0].nombre_documento
      this.mensajeStatusDocumentos = (this.statusSolicitud == 1) ? smsInfo : (this.statusSolicitud == 0) ? smsRechasado : (this.statusSolicitud == 2) ? smsAceptado : ''
      statusSD = []
    }

    if( statusCAD.length == 0 )
    {
      this.statusCartaAceptacion = 3
    }
    else
    {
      this.statusCartaAceptacion = statusCAD[0].estatus
      this.idDocumentoCartaAceptacion = statusCAD[0].id
      this.nombreDocumentoCartaAceptacion = statusCAD[0].nombre_documento
      this.mensajeStatusDocumentos = (this.statusCartaAceptacion == 1) ? smsInfo : (this.statusCartaAceptacion == 0) ? smsRechasado : (this.statusCartaAceptacion == 2) ? smsAceptado : ''
    }

    this.directores = await getDirectores()
    this.instituciones = await getEmpresas()
  }

}).use(vuetify).mount("#paginaPrincipal")