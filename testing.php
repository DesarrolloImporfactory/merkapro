<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Subir documento</title>
   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

</head>

<body class="bg-blue-500 min-h-screen grid place-content-center">
   <form enctype="multipart/form-data" class="bg-white p-10 rounded-lg shadow-lg">
      <input type="file" name="file" id="file" class="mb-5">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Subir</button>
   </form>

   <script>
      document.getElementById('file').addEventListener('change', function(e) {
         var file = e.target.files[0];
         var reader = new FileReader();
         reader.onload = function(e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, {
               type: 'array'
            });
            var sheet = workbook.Sheets[workbook.SheetNames[1]];
            var json = XLSX.utils.sheet_to_json(sheet);

            fetch('test.php', {
               method: 'POST',
               headers: {
                  'Content-Type': 'application/json'
               },
               body: JSON.stringify(json)
            }).then(response => response.json()).then(data => {
               console.log(data);
            });
         };
         reader.readAsArrayBuffer(file);
      });
   </script>
</body>

</html>