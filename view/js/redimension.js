// from an input element
var filesToUpload = input.files;
// from drag-and-drop
function onDrop(e) {
  filesToUpload = e.dataTransfer.files;
}

if (!file.type.match(/image.*/)) {
  // this file is not an image.
};

var img = document.createElement("img");
img.src = window.URL.createObjectURL(file);

var img = document.createElement("img");
var reader = new FileReader();
reader.onload = function(e) {img.src = e.target.result}
reader.readAsDataURL(file);

var ctx = canvas.getContext("2d");
ctx.drawImage(img, 0, 0);

var MAX_WIDTH = 800;
var MAX_HEIGHT = 600;
var width = img.width;
var height = img.height;
 
if (width > height) {
  if (width > MAX_WIDTH) {
    height *= MAX_WIDTH / width;
    width = MAX_WIDTH;
  }
} else {
  if (height > MAX_HEIGHT) {
    width *= MAX_HEIGHT / height;
    height = MAX_HEIGHT;
  }
}
canvas.width = width;
canvas.height = height;
var ctx = canvas.getContext("2d");
ctx.drawImage(img, 0, 0, width, height);

var imgData = ctx.createImageData(width, height);
var data = imgData.data;
var pixels = ctx.getImageData(0, 0, width, height);
for (var i = 0, ii = pixels.data.length; i < ii; i += 4) {
    var r = pixels.data[i + 0];
    var g =pixels.data[i + 1];
    var b = this.pixels.data[i + 2];
    data[i + 0] = (r * .393) + (g *.769) + (b * .189);
    data[i + 1] = (r * .349) + (g *.686) + (b * .168)
    data[i + 2] = (r * .272) + (g *.534) + (b * .131)
    data[i + 3] = 255;
}
ctx.putImageData(imgData, 0, 0);

var dataurl = canvas.toDataURL("image/png");

var file = canvas.mozGetAsFile("foo.png");

xhr.upload.addEventListener("progress", function(e) {
  if (e.lengthComputable) {
    var percentage = Math.round((e.loaded * 100) / e.total);
    // do something
}, false);

var fd = new FormData();
fd.append("name", "paul");
fd.append("image", canvas.mozGetAsFile("foo.png"));
fd.append("key", "××××××××××××");
var xhr = new XMLHttpRequest();
xhr.open("POST", "http://your.api.com/upload.json");
xhr.send(fd);

document.addEventListener("message", function(e){
    // retrieve parameters from e.data
    var key = e.data.key;
    var name = e.data.name;
    var dataurl = e.data.dataurl;
    // Upload
}