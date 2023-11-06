import { createApp, ref, computed, vuetify } from '../componentes/initVue.js'
import { getUser } from '../componentes/user.js'

createApp({
    setup()
    {
        let userName = ref('')
        let archivo = ref([])
        let informes = ref([])
        let panel = ref([])

        const CerrarSesion = () =>
        {
            const formData = new FormData();
            formData.append('action','CerrarSesion')
      
            fetch('../../controladores/loginSection.php', {
                method: 'POST',
                body : formData
            }).then(res => res.text()).then(() => {
                window.location.href = "../../index.php"
            })
        }
    
        const subirArchivo = ( proceso ) =>
        {
          const data = new FormData()
          data.append("action", "subir_archivo")
          data.append("file", archivo.value[0])
          data.append("step", 5)
          data.append("proceso", proceso)
    
          fetch("../../controladores/stepSection.php",{
              method: "POST",
              body: data,
          })
          .then(res => res.text())
          .then(() => {
            archivo.value = []
            getInformes()
          })
        }

        const getInformes = () =>
        {
            const data = new FormData()
            data.append("action", "get_informes")
      
            fetch("../../controladores/informacionUser.php",{
                method: "POST",
                body: data,
            })
            .then(res => res.text())
            .then((data) => {
                try
                {
                    informes.value = JSON.parse(data)
                }
                catch(e)
                {
                    console.error(e)
                }
            })
        }

        const descargarPInforme = () =>
        {
            fetch(`../../templatesDocumentos/ppinforme.docx`)
            .then(res => res.blob()).then((data) => {
                const url = window.URL.createObjectURL(new Blob([data]))
                const link = document.createElement('a')
                link.href = url
                link.setAttribute('download', `informe.docx`);
                document.body.appendChild(link)
                link.click()
            })
        }

        const downloadDocument = ( nameDocument, proceso ) =>
        {
            fetch(`../../archivosGuardados/${nameDocument}`)
            .then(res => res.blob()).then((data) => {
                const url = window.URL.createObjectURL(new Blob([data]))
                const link = document.createElement('a')
                let extencion = nameDocument.match(/(?:\.([^.]+))?$/)[0]
                link.href = url
                link.setAttribute('download', `${userName.value}_${proceso}${extencion}`);
                document.body.appendChild(link)
                link.click()
            })
        }

        const goToDocumentos = () =>
        {
          window.location.href = "documentosAlumno.php"
        }

        return {
            userName,
            archivo,
            informes,
            panel,
            CerrarSesion,
            descargarPInforme,
            subirArchivo,
            getInformes,
            downloadDocument,
            goToDocumentos
        }
    },
    async created()
    {
        let user = await getUser("../../controladores/informacionUser.php")
        this.userName = user[0].nombre_completo

        this.getInformes()
    }
}).use(vuetify).mount("#informes")