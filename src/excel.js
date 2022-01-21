let selectedFile;
console.log(window.XLSX);
document.getElementById('input').addEventListener("change", (event) => {
    selectedFile = event.target.files[0];
})



document.getElementById('button').addEventListener("click", () => {
    // XLSX.utils.json_to_sheet(data, 'out.xlsx');
    if (selectedFile) {
        let fileReader = new FileReader();
        fileReader.readAsBinaryString(selectedFile);
        fileReader.onload = (event) => {
            let data = event.target.result;
            let workbook = XLSX.read(data, { type: "binary" });
            //console.log(workbook);

            var name = selectedFile.name; //with .xlsx
            var fullname = name.replace(".xlsx", "");
            console.log(fullname);
           
            //TODO: Implement dynamic filename
            
            //initialize an empty variable to hold the data
            var datajson = [];

            workbook.SheetNames.forEach(sheet => {
                let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                // console.log(rowObject);
                datajson.push(rowObject);
                document.getElementById("jsondata").innerHTML = JSON.stringify(rowObject, undefined, 4);

            });
            //added sth to create the 'json' file
            // datajson = JSON.stringify(datajson);
            axios.post('http://localhost:3000/src/createFile.php', { datajson },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        "Access-Control-Allow-Headers": "Content-Type"
                    }
                })
                .then(function (response) {
                    //  console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            //   window.location('/createFile.php');


        }
    }
});
