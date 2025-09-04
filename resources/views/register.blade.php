<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: linear-gradient(135deg, #0f4c3a 0%, #2d5016 50%, #1a472a 100%);
            background-image:
                radial-gradient(white 1px, transparent 1px),
                radial-gradient(white 1px, transparent 1px);
            background-size: 40px 40px, 40px 40px;
            background-position: 0 0, 20px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .soccer-ball {
            position: absolute;
            width: 80px;
            height: 80px;
            background: #fff;
            border-radius: 50%;
            border: 3px solid #333;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .soccer-ball:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .soccer-ball:nth-child(2) {
            top: 70%;
            right: 15%;
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            border: 3px solid #4CAF50;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #4CAF50, #45a049, #2e7d32, #4CAF50);
            z-index: -1;
            border-radius: 15px;
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        h2 {
            color: #2e7d32;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            background: #f9f9f9;
            transition: all 0.3s ease;
            outline: none;
            font-weight: 500;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            transform: translateY(-1px);
        }

        input::placeholder {
            color: #888;
            font-weight: 400;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            z-index: 1;
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 50%, #2e7d32 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, #45a049 0%, #4CAF50 50%, #2e7d32 100%);
        }

        button:hover::before {
            left: 100%;
        }

        button:active {
            transform: translateY(0);
        }

        .field-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            opacity: 0.05;
        }

        .field-lines::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #2e7d32;
            transform: translateY(-50%);
        }

        .field-lines::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            border: 2px solid #2e7d32;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 25px;
                margin: 10px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 12px 15px 12px 45px;
                font-size: 15px;
            }

            button {
                padding: 14px;
                font-size: 16px;
            }

            .input-icon {
                font-size: 18px;
                left: 12px;
            }
        }

        /* Animasi masuk */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            animation: slideInUp 0.8s ease-out;
        }

        .form-group {
            animation: slideInUp 0.6s ease-out both;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.3s;
        }

        button {
            animation: slideInUp 0.6s ease-out both;
            animation-delay: 0.4s;
        }
    </style>
</head>

<body>
    <div class="soccer-ball"></div>
    <div class="soccer-ball"></div>

    <div class="container">
        <div class="field-lines"></div>

        <div class="header">
            <h2>Registrasi Akun</h2>
            <div class="subtitle">
                ⚽ Join the Game! ⚽
            </div>
        </div>

        <form action="{{ route('registering') }}" method="POST">
            <div class="form-group">
                <div class="input-wrapper">
                    <div class="input-icon">⚽</div>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <div class="input-icon">📧</div>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <div class="input-icon">🔐</div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            </div>

            <button type="submit">⚽ DAFTAR ⚽</button>
            <p style="margin-top: 10px;">
                Sudah punya akun? 
                <a href="{{ route('login') }}" style="text-decoration: none; color: #FFF;">Login</a>
            </p>
        </form>
    </div>
</body>

</html>
