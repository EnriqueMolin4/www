<?php  include('modelos/loginredirect.php');?>
<!DOCTYPE html>
<html>
 
<head>
 
    <title>Sinttecom_SAS Imagenes</title>
    <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">
</head>
 
<body>
    <div class="container-fluid">
        <div class="clearfix">
            <span class="float-right"><a href="sesiones/logout.php" class="btn btn-success">Salir</a></span>
        </div>
        <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
            <div class="row">
                <div class="col-sm-2"><label for="odt" class="col-form-label-sm">Escribe la ODT</label></div>
                <div class="col-sm-7">
                    <input type="text" class="form-control form-control-sm" id="odt" name="odt" aria-describedby="odt">
                </div>
                <div class="clearfix">
                    <span class="float-right"><a href="#" class="btn btn-warning">Buscar</a></span>
                </div>
            </div>
            <br />
            <div class="row">
                <label for="fileToUpload">Cargar Foto </label><br />
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
            </div>
            <div class="row">
                <div id="details"></div>
            </div>
            <div class="row">
                <input class="btn btn-success" type="button" onclick="uploadFile()" value="Upload" />
            </div>
            <div class="row">
                <div id="progress"></div>
            </div>
            <input type="hidden" id='saveImage'>
        </form>
    </div>
  <script type="text/javascript">
 
 function fileSelected() {

   var count = document.getElementById('fileToUpload').files.length;

         document.getElementById('details').innerHTML = "";

         for (var index = 0; index < count; index ++)

         {

                var file = document.getElementById('fileToUpload').files[index];

                var fileSize = 0;

                if (file.size > 1024 * 1024)

                       fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';

                else

                       fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

                document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;

                document.getElementById('details').innerHTML += '<p>';

         }

 }

 function uploadFile() {

   var fd = new FormData();
   var odt = document.getElementById('odt').value;

         var count = document.getElementById('fileToUpload').files.length;

         for (var index = 0; index < count; index ++)

         {

                var file = document.getElementById('fileToUpload').files[index];

                fd.append('file', file);
                fd.append('name',odt);
                fd.append('module','saveImage');

         }

   var xhr = new XMLHttpRequest();

   xhr.upload.addEventListener("progress", uploadProgress, false);

   xhr.addEventListener("load", uploadComplete, false);

   xhr.addEventListener("error", uploadFailed, false);

   xhr.addEventListener("abort", uploadCanceled, false);

   xhr.open("POST", "modelos/eventos_db.php");

   xhr.send(fd);

 }

 function uploadProgress(evt) {

   if (evt.lengthComputable) {

     var percentComplete = Math.round(evt.loaded * 100 / evt.total);

     document.getElementById('progress').innerHTML = percentComplete.toString() + '%';

   }

   else {

     document.getElementById('progress').innerHTML = 'unable to compute';

   }

 }

 function uploadComplete(evt) {

   /* This event is raised when the server send back a response */

   alert(evt.target.responseText);

 }

 function uploadFailed(evt) {

   alert("There was an error attempting to upload the file.");

 }

 function uploadCanceled(evt) {

   alert("The upload has been canceled by the user or the browser dropped the connection.");

 }

</script>
</body>
 
</html>