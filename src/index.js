
let selectedFile;
document.getElementById('inputfile').addEventListener("change", (event) => {
    selectedFile = event.target.files[0];
});

// let data = 'ffffff'

document.getElementById('convert').addEventListener('click', function () {
    
    let data = {
        'filename':selectedFile.name       
    };
    
    axios.post('http://localhost:3000/src/handle.php', { data },
        {
            headers: {
                'Content-Type': 'application/json',
                "Access-Control-Allow-Headers": "Content-Type"
            }
        })
        .then(function (response) {
            document.getElementById("response").innerHTML = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
});