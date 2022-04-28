function uploadFile() {
  var form = new FormData();
  form.append("file", document.querySelector("#imageFile").files[0]);
  form.append("upload", true);

  var upload = new XMLHttpRequest();
  upload.open("POST", "upload.php");
  console.log("my script file");
  upload.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText != "") {
        document.querySelector("#uploadError").innerText =
          "Image uploaded successfully.";
        document.querySelector("#filename").value = this.responseText;
      } else {
        document.querySelector("#uploadError").innerText =
          "An error occoured when uploading the image";
      }
    }
  };
  upload.send(form);
}
