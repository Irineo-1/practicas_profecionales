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
    let especialidad = ref('')
    let directorAcargo = ref('')
    let instituciones = ref([])
    let solicitudFile = ref([])
    let buscarEmpresa = ref("")
    let verInformacionEmpresa = ref(false)
    let directores = ref([])
    let fechaInicio = ref("")
    let fechaFin = ref("")

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
      .then(() => {
        archivo.value = []
        step.value ++
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

      console.log("inicio", fechaInicioWF)
      console.log("fin", fechaFinWF)

      form.append("action", "generar_carta_presentacion")
      form.append("hoy", formatoToday)
      form.append("inicio", fechaInicioWF)
      form.append("fin", fechaFinWF)
      form.append("especialidad", especialidad.value)
      form.append("director", directorAcargo.value)
      form.append("nombreAlumno", userName.value)
      fetch("controladores/stepSection.php", {
        method: "POST",
        body: form,
      })
      .then(res => res.text())
      .then(nameDocument => {
        console.log(nameDocument)
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
      especialidad,
      directorAcargo,
      CerrarSesion,
      seleccionarEmpresa,
      subirArchivo,
      descargarCartaPrecentacion,
      goToInformes,
      goToDocumentos
    }
  },
  async beforeCreate()
  {
    let user = await getUser("controladores/informacionUser.php")
    this.userName = user[0].nombre_completo
    this.step = parseInt(user[0].numero_proceso)
    this.directores = await getDirectores()
    this.instituciones = await getEmpresas()
  }

}).use(vuetify).mount("#paginaPrincipal")