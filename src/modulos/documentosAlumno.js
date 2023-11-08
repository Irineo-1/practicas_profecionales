import { createApp, ref, computed, vuetify } from '../componentes/initVue.js'
import { getUser } from '../componentes/user.js'
import { getDocuments } from '../componentes/user.js'

createApp({
    setup()
    {
        let userName = ref('')
        let archivo = ref([])
        let panel = ref([])
        let DOCfirmado = ref([])
        let DOCcarta_aceptacion = ref([])
        let DOCsolicitud = ref([])
        let DOCconstancia_temino_servicio = ref([])
        let step = ref(0)

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

        const goToInformes = () =>
        {
          window.location.href = "informes.php"
        }

        const goToProceso = () =>
        {
          window.location.href = "../../index.php"
        }

        return {
            userName,
            archivo,
            panel,
            DOCfirmado,
            DOCcarta_aceptacion,
            DOCsolicitud,
            DOCconstancia_temino_servicio,
            step,
            CerrarSesion,
            downloadDocument,
            goToInformes,
            goToProceso
        }
    },
    async created()
    {
        let user = await getUser("../../controladores/informacionUser.php")
        this.userName = user[0].nombre_completo
        this.step = parseInt(user[0].numero_proceso)

        let TotalFiles = await getDocuments("desdeAlumno")
        this.DOCconstancia_temino_servicio = TotalFiles.filter(el => el.proceso == "constancia_termino") || []
        this.DOCsolicitud = TotalFiles.filter(el => el.proceso == "solicitud") || []
        this.DOCcarta_aceptacion = TotalFiles.filter(el => el.proceso == "carta_aceptacion") || []
        this.DOCfirmado = TotalFiles.filter(el => el.proceso.includes('firmado')) || []
    }
}).use(vuetify).mount("#documentosAlumno")