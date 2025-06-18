<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¡Próximamente!</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body,
        html {
            height: 100%;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: white;
        }

        .wave {
            position: absolute;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.03);
            animation: wave 12s linear infinite;
            transform: rotate(30deg);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 90%;
            max-width: 800px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 25px;
            box-shadow: 0 0 50px rgba(0, 255, 204, 0.2);
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: #00ffe7;
            text-shadow: 0 0 15px #00ffe7;
            animation: pulse 2.5s infinite;
        }

        p {
            font-size: 1.5rem;
            color: #d4d4d4;
        }

        @keyframes wave {
            0% {
                transform: translateX(-100%) rotate(30deg);
            }

            100% {
                transform: translateX(100%) rotate(30deg);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                text-shadow: 0 0 15px #00ffe7;
            }

            50% {
                text-shadow: 0 0 30px #00ffe7;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 2.2rem;
            }

            p {
                font-size: 1.1rem;
            }
        }

        @media (min-width: 1200px) {
            h1 {
                font-size: 4rem;
            }

            p {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="wave"></div>
    <div class="container">
        <h1>¡Próximamente!</h1>
        <p>Estamos trabajando en algo genial...<br>¡Prepárate para lo inesperado!</p>
    </div>
</body>

</html>