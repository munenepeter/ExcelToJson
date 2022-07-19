let selectedFile;
document.getElementById('inputfile').addEventListener("change", (event) => {
    selectedFile = event.target.files[0];
});

document.getElementById('button').addEventListener("click", () => { 
    if (selectedFile) {
        let fileReader = new FileReader();
        fileReader.readAsBinaryString(selectedFile);
        fileReader.onload = (event) => {
            let data = event.target.result;
            let workbook = XLSX.read(data, { type: "binary" });
            //console.log(workbook);

            var name = selectedFile.name; //filename with .xlsx
            var fullname = name.replace(".xlsx", ""); //filename without .xlsx
            //console.log(fullname);
           
            //TODO: Implement dynamic filename
            
            //initialize an empty variable to hold the data
            var datajson = [];
            datajson.push(fullname);
            workbook.SheetNames.forEach(sheet => {
                let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                datajson.push(rowObject);
                document.getElementById("jsondata").innerHTML = JSON.stringify(rowObject, undefined, 4);

            });

            //added sth to create the 'json' file
            axios.post('http://localhost:8989/src/createFile.php', { datajson },
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
        }
    }
});
