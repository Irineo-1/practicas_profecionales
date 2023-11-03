const getEmpresas = () =>
{
    return new Promise((resolve, reject) => {
        let formdata = new FormData()
        formdata.append("action", "get_instituciones")
        fetch("controladores/stepSection.php", {
            method: 'POST',
            body: formdata
        })
        .then(res => res.text())
        .then(data => {
            console.log(data)
            try
            {
                resolve(JSON.parse(data))
            }
            catch(e)
            {
                reject("error al obtener los datos de la empresa: ", e)
            }
        })
    })
}

export {
    getEmpresas
}