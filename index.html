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
            text-align: center;
        }
        #video-container {
            position: relative;
            margin-bottom: 20px;
            max-width: 100%;
        }
        #webcam, #canvas {
            position: absolute;
            top: 0;
            left: 0;
            max-width: 100%;
            height: auto;
        }
        #detected-objects {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        #error-message {
            color: red;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Detección de Objetos en Tiempo Real</h1>
    <div id="video-container">
        <video id="webcam" autoplay playsinline></video>
        <canvas id="canvas"></canvas>
    </div>
    <div id="detected-objects">
        <h2>Objetos Detectados:</h2>
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

        // Traducción de clases de objetos al español
        const translations = {
            'person': 'persona', 'bicycle': 'bicicleta', 'car': 'coche', 'motorcycle': 'motocicleta',
            'airplane': 'avión', 'bus': 'autobús', 'train': 'tren', 'truck': 'camión', 'boat': 'barco',
            'traffic light': 'semáforo', 'fire hydrant': 'boca de incendios', 'stop sign': 'señal de stop',
            'parking meter': 'parquímetro', 'bench': 'banco', 'bird': 'pájaro', 'cat': 'gato', 'dog': 'perro',
            'horse': 'caballo', 'sheep': 'oveja', 'cow': 'vaca', 'elephant': 'elefante', 'bear': 'oso',
            'zebra': 'cebra', 'giraffe': 'jirafa', 'backpack': 'mochila', 'umbrella': 'paraguas',
            'handbag': 'bolso', 'tie': 'corbata', 'suitcase': 'maleta', 'frisbee': 'frisbee',
            'skis': 'esquís', 'snowboard': 'snowboard', 'sports ball': 'pelota deportiva',
            'kite': 'cometa', 'baseball bat': 'bate de béisbol', 'baseball glove': 'guante de béisbol',
            'skateboard': 'monopatín', 'surfboard': 'tabla de surf', 'tennis racket': 'raqueta de tenis',
            'bottle': 'botella', 'wine glass': 'copa de vino', 'cup': 'taza', 'fork': 'tenedor',
            'knife': 'cuchillo', 'spoon': 'cuchara', 'bowl': 'bol', 'banana': 'plátano', 'apple': 'manzana',
            'sandwich': 'sándwich', 'orange': 'naranja', 'broccoli': 'brócoli', 'carrot': 'zanahoria',
            'hot dog': 'perrito caliente', 'pizza': 'pizza', 'donut': 'donut', 'cake': 'pastel',
            'chair': 'silla', 'couch': 'sofá', 'potted plant': 'planta en maceta', 'bed': 'cama',
            'dining table': 'mesa de comedor', 'toilet': 'inodoro', 'tv': 'televisión', 'laptop': 'portátil',
            'mouse': 'ratón', 'remote': 'mando a distancia', 'keyboard': 'teclado', 'cell phone': 'teléfono móvil',
            'microwave': 'microondas', 'oven': 'horno', 'toaster': 'tostadora', 'sink': 'fregadero',
            'refrigerator': 'nevera', 'book': 'libro', 'clock': 'reloj', 'vase': 'jarrón', 'scissors': 'tijeras',
            'teddy bear': 'oso de peluche', 'hair drier': 'secador de pelo', 'toothbrush': 'cepillo de dientes'
        };

        // Cargar el modelo COCO-SSD
        cocoSsd.load().then((loadedModel) => {
            model = loadedModel;
            console.log('Modelo COCO-SSD cargado');
        }).catch((error) => {
            console.error('Error al cargar el modelo:', error);
            errorMessage.textContent = 'Error al cargar el modelo de detección de objetos.';
        });

        // Acceder a la cámara web
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then((stream) => {
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    video.play();
                    detectObjects();
                };
            })
            .catch((error) => {
                console.error('Error al acceder a la cámara:', error);
                errorMessage.textContent = 'Error al acceder a la cámara. Por favor, asegúrate de que tienes una cámara conectada y has dado permiso para usarla.';
            });

        function detectObjects() {
            if (model) {
                model.detect(video).then((predictions) => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    predictions.forEach((prediction) => {
                        const [x, y, width, height] = prediction.bbox;
                        const spanishClass = translations[prediction.class] || prediction.class;
                        const label = `${spanishClass} (${Math.round(prediction.score * 100)}%)`;

                        ctx.strokeStyle = '#00FFFF';
                        ctx.lineWidth = 2;
                        ctx.strokeRect(x, y, width, height);

                        ctx.fillStyle = '#00FFFF';
                        ctx.font = '16px Arial';
                        ctx.fillText(label, x, y > 20 ? y - 5 : y + 20);

                        if (!detectedObjects.has(spanishClass)) {
                            detectedObjects.set(spanishClass, new Date().toLocaleTimeString());
                            updateObjectList();
                        }
                    });
                });
            }
            requestAnimationFrame(detectObjects);
        }

        function updateObjectList() {
            objectList.innerHTML = '';
            detectedObjects.forEach((time, object) => {
                const li = document.createElement('li');
                li.textContent = `${object} - Detectado por primera vez: ${time}`;
                objectList.appendChild(li);
            });
        }
    </script>
</body>
</html>
