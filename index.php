<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detección de Objetos en Tiempo Real</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        #video-container {
            position: relative;
            margin-bottom: 20px;
        }
        #webcam {
            border: 2px solid #333;
            border-radius: 8px;
        }
        #canvas {
            position: absolute;
            top: 0;
            left: 0;
        }
        #error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Detección de Objetos en Tiempo Real</h1>
    <div id="video-container">
        <video id="webcam" width="640" height="480" autoplay playsinline muted></video>
        <canvas id="canvas" width="640" height="480"></canvas>
    </div>
    <div id="error-message"></div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const errorMessage = document.getElementById('error-message');

        let model;

        // Cargar el modelo COCO-SSD
        async function loadModel() {
            try {
                model = await cocoSsd.load();
                startDetection();
            } catch (error) {
                console.error('Error al cargar el modelo:', error);
                errorMessage.textContent = 'Error al cargar el modelo de detección de objetos.';
            }
        }

        // Iniciar la cámara web
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    video.play();
                    loadModel(); // Cargar el modelo cuando el video esté listo
                };
            } catch (error) {
                console.error('Error al acceder a la cámara:', error);
                errorMessage.textContent = 'Error al acceder a la cámara web. Por favor, asegúrate de que tienes una cámara conectada y has dado permiso para usarla.';
            }
        }

        // Realizar la detección de objetos
        async function detectObjects() {
            if (!model) return;
            
            try {
                const predictions = await model.detect(video);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                predictions.forEach(prediction => {
                    const [x, y, width, height] = prediction.bbox;
                    ctx.strokeStyle = '#00FFFF';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(x, y, width, height);
                    
                    ctx.fillStyle = '#00FFFF';
                    ctx.font = '16px Arial';
                    ctx.fillText(`${prediction.class} - ${Math.round(prediction.score * 100)}%`, x, y > 10 ? y - 5 : 10);
                });
            } catch (error) {
                console.error('Error en la detección de objetos:', error);
            }
        }

        // Iniciar el bucle de detección
        function startDetection() {
            detectObjects();
            setTimeout(startDetection, 500); // 2 FPS
        }

        // Iniciar la aplicación
        startCamera();
    </script>
</body>
</html>
