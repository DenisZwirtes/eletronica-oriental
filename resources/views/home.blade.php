<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Oriental - Sistema de Gestão</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            margin: 2rem;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        .subtitle {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .status {
            background: #e8f5e8;
            border: 1px solid #4caf50;
            color: #2e7d32;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .info {
            background: #f5f5f5;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            text-align: left;
        }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 0.5rem;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .version {
            color: #999;
            font-size: 0.9rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Eletrônica Oriental</h1>
        <p class="subtitle">Sistema de Gestão de Consertos</p>
        
        <div class="status">
            ✅ Sistema funcionando corretamente!
        </div>
        
        <div class="info">
            <h3>📋 Informações do Sistema:</h3>
            <ul>
                <li><strong>Laravel:</strong> {{ app()->version() }}</li>
                <li><strong>PHP:</strong> {{ phpversion() }}</li>
                <li><strong>Ambiente:</strong> {{ app()->environment() }}</li>
                <li><strong>Banco de Dados:</strong> Conectado</li>
            </ul>
        </div>
        
        <div class="info">
            <h3>🔗 Links Úteis:</h3>
            <a href="http://localhost:8080" class="btn" target="_blank">PHPMyAdmin</a>
            <a href="http://localhost:5173" class="btn" target="_blank">Frontend Dev</a>
        </div>
        
        <div class="info">
            <h3>👤 Credenciais de Acesso:</h3>
            <ul>
                <li><strong>Email:</strong> proprietario@eletronica.com</li>
                <li><strong>Senha:</strong> password</li>
            </ul>
        </div>
        
        <p class="version">
            Desenvolvido com Laravel 12.0 + Vue.js 3.4 + TailwindCSS
        </p>
    </div>
</body>
</html> 