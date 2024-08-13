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
        #detected-objects {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 100%;
            max-width: 640px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        #detected-objects h2 {
            margin-top: 0;
            color: #333;
        }
        #object-list {
            list-style-type: none;
            padding: 0;
        }
        #object-list li {
            margin-bottom: 5px;
            padding: 5px;
            background-color: #f9f9f9;
            border-radius: 4px;
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
        <video id="webcam" width="640" height="480" autoplay></video>
        <canvas id="canvas" width="640" height="480"></canvas>
    </div>
    <div id="detected-objects">
        <h2>Objetos Detectados</h2>
        <ul id="object-list"></ul>
    </div>
    <div id="error-message"></div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const objectList = document.getElementById('object-list');
        const errorMessage = document.getElementById('error-message');

        let model;
        let detectedObjects = new Map();

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
                await video.play();
                loadModel();
            } catch (error) {
                console.error('Error al acceder a la cámara:', error);
                errorMessage.textContent = 'Error al acceder a la cámara web. Por favor, asegúrese de que tiene una cámara conectada y ha dado permiso para usarla.';
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
                    
                    if (!detectedObjects.has(prediction.class)) {
                        detectedObjects.set(prediction.class, new Date().toLocaleTimeString());
                        updateObjectList();
                    }
                });
            } catch (error) {
                console.error('Error en la detección de objetos:', error);
            }
        }

        // Actualizar la lista de objetos detectados
        function updateObjectList() {
            objectList.innerHTML = '';
            detectedObjects.forEach((time, object) => {
                const li = document.createElement('li');
                li.textContent = `${object} - Detectado por primera vez a las ${time}`;
                objectList.appendChild(li);
            });
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
