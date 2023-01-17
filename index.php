<html>

  <head>
    <!-- Instascan, Vue, Webrtc Adapter, Bootstrap -->
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  </head>

  <body>

    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <video id="preview" width=100%></video>
        </div>
        <div class="col-md-6">
          <!-- Label and Textbox -->
          <label>SCAN QR CODE</label>
          <input type="text" name="text" id="text" readonly="" placeholder="scan qrcode" class="form-control">
        </div>
      </div>
    </div>

    <script>
      // Initialize camera scanner 
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});

      Instascan.Camera.getCameras().then(function(cameras) {

        if (cameras.length > 0){
          scanner.start(cameras[0]);
        } else {
          alert('No cameras detected');
        }
      }).catch(function(e) {
        console.error(e);
      });
      
      scanner.addListener('scan', function(c){
        document.getElementById('text').value = c;
      });

    </script>

  </body>

</html>