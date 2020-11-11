if (window.FileReader) {
  document.getElementById('fileToUpload').addEventListener('change', handleFileSelect, false);
  function handleFileSelect(evt) {
    let files = evt.target.files;
    let f = files[0];
    let reader = new FileReader();
     
      reader.onload = (function(theFile) {
            return function(e) {
              document.getElementById('list').innerHTML = ['<img src="', e.target.result,'" title="', theFile.name, '" width="50" />'].join('');
            };
      })(f);
       
      reader.readAsDataURL(f);
}

} else {
  alert('This browser does not support FileReader');
}
