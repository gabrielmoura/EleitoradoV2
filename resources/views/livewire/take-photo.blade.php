<div onfocus="loadCamera()">
    <video id="webCamera" width="{{$width}}" height="{{$height}}" autoplay></video>

    @error('photo') <span class="error">{{ $message }}</span> @enderror
    <button onclick="takeSnapShot()">Take Photo</button>

    <script>
        function loadCamera() {
            //Captura elemento de vídeo
            var video = document.querySelector("#webCamera");
            //As opções abaixo são necessárias para o funcionamento correto no iOS
            video.setAttribute('autoplay', '');
            video.setAttribute('muted', '');
            video.setAttribute('playsinline', '');
            //--

            //Verifica se o navegador pode capturar mídia
            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({audio: false, video: {facingMode: 'user'}})
                    .then(function (stream) {
                        //Definir o elemento vídeo a carregar o capturado pela webcam
                        video.srcObject = stream;
                    })
                    .catch(function (error) {
                        alert("Oooopps... Falhou :'(");
                    });
            }
        }

        function takeSnapShot() {
            //Captura elemento de vídeo
            var video = document.querySelector("#webCamera");

            //Criando um canvas que vai guardar a imagem temporariamente
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            var ctx = canvas.getContext('2d');

            //Desenhando e convertendo as dimensões
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            //Criando o JPG
            var dataURI = canvas.toDataURL('image/jpeg'); //O resultado é um BASE64 de uma imagem.
            document.querySelector("#base_img").value = dataURI;

            // livewire emit dataURI
            Livewire.emit('fileUpload', dataURI);

            // close mediaDevices
            video.srcObject.getTracks().forEach(function (track) {
                track.stop();
            });
        }
    </script>
</div>
