import { createApp, ref, computed, vuetify } from '../componentes/initVue.js'
import { getUser } from '../componentes/user.js'
import { getEmpresas } from '../componentes/instituciones.js'
const { jsPDF } = jspdf

createApp({
  setup()
  {
    let step = ref(0)
    let respuestaPrimerPregunta = ref('')
    let userName = ref('')
    let constanciaFile = ref([])
    let tituloApartados = ["Servicio social", "Constancia de termino", "Empresas donde deseas hacer tus practicas", "Carta de Presentación"]
    let instituciones = ref([])
    let buscarEmpresa = ref("")

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
    
    const subirConstancia = () =>
    {
      const data = new FormData()
      data.append("action", "subir_constancia")
      data.append("file", constanciaFile.value[0])
      data.append("step", step.value + 1)

      fetch("controladores/stepSection.php",{
          method: "POST",
          body: data,
      })
      .then(res => res.text())
      .then(() => {
          step.value ++
      })
    }

    const test = () =>
    {
      var doc = new jsPDF()

      let test = "<h1>gsdfdsdfs</h1>"

      const parse = new DOMParser()

      let html = parse.parseFromString(test, "text/html")

      console.log(html.documentElement)

      doc.html(html.documentElement, {
        callback: function(doc) {
          doc.save('sample-document.pdf')
      },
      x: 15,
      y: 15,
      width: 170,
      windowWidth: 650
    })
    }

    const seleccionarEmpresa = id =>
    {
      console.log(id)
    }

    return {
      step,
      tituloApartados,
      respuestaPrimerPregunta,
      userName,
      constanciaFile,
      instituciones,
      buscarEmpresa,
      resolveInstituciones,
      CerrarSesion,
      subirConstancia,
      seleccionarEmpresa,
      test
    }
  },
  async beforeCreate()
  {
    let user = await getUser()
    this.userName = user[0].nombre_completo
    this.step = parseInt(user[0].numero_proceso)

    this.instituciones = await getEmpresas()
  }

}).use(vuetify).mount("#paginaPrincipal")