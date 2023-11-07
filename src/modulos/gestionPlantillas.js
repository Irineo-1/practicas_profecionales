import { createApp, ref, computed, vuetify } from '../componentes/initVue.js'
import { getMaestro } from '../componentes/maestros.js'

createApp({

    setup()
    {
        let nombreMaestro = ref("")
        let puesto = ref("")
        let turno = ref("")
        let uploadFile = ref(false)
        let fileToReplace = ref('')
        let archivo = ref([])
        let showAlerta = ref(false)

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

        const downloadDocument = ( nameDocument ) =>
        {
            fetch(`../../templatesDocumentos/${nameDocument}`)
            .then(res => res.blob()).then((data) => {
                const url = window.URL.createObjectURL(new Blob([data]))
                const link = document.createElement('a')
                link.href = url
                link.setAttribute('download', nameDocument);
                document.body.appendChild(link)
                link.click()
            })
        }

        const reemplazarDocumento = () =>
        {
            const formData = new FormData();
            formData.append('action','reemplasar_plantilla')
            formData.append('file', archivo.value[0])
            formData.append('nameFile', fileToReplace.value)
      
            fetch('../../controladores/stepSection.php', {
                method: 'POST',
                body : formData
            }).then(res => res.text()).then(() => {
                archivo.value = []
                uploadFile.value = false
                showAlerta.value = true
            })
        }

        const goToAlumnos = () =>
        {
            window.location.href = "indexm.php"
        }

        return {
            nombreMaestro,
            puesto,
            turno,
            uploadFile,
            archivo,
            fileToReplace,
            showAlerta,
            goToAlumnos,
            CerrarSesion,
            downloadDocument,
            reemplazarDocumento
        }
    },
    async created()
    {
        let maestro = await getMaestro()
        this.nombreMaestro = maestro[0].nombre
        this.puesto = maestro[0].puesto
        this.turno = maestro[0].turno
    }
}).use(vuetify).mount("#gestionPlantillas")
