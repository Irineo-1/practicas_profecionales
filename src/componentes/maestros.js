const getMaestro = () =>
{
    return new Promise((resolve, reject) => {
        let formdata = new FormData()
        formdata.append("action", "get_maestro")
        fetch("../../controladores/informacionUser.php", {
            method: 'POST',
            body: formdata
        })
        .then(res => res.text())
        .then(data => {
            try
            {
                resolve(JSON.parse(data))
            }
            catch(e)
            {
                reject("error al obtener los datos del usuario: ", e)
            }
        })
    })
}

export {
    getMaestro
}