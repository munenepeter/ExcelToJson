async function saveFile() {

    let formData = new FormData();
    formData.append("file", inputfile.files[0]);
    await fetch('src/handle.php', {
            method: "POST",
            body: formData
        })
    // await axios.post('src/handle.php', {
    //         formData
    //     }, {
    //         headers: {
    //             'Content-Type': 'application/json',
    //             "Access-Control-Allow-Headers": "Content-Type"
    //         }
    //     })
        // .then(function (data) {
        //     console.log(data);
        //     //  document.getElementById("response").innerHTML = data;
        // })
        .then(function (response) {
            console.log(response);
            document.getElementById("response").innerHTML = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });

}



document.getElementById('convert').addEventListener('click', function () {
    saveFile();
});