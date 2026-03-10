<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login API - compraFacil</title>
    <link rel="stylesheet" href="./css/testLogin.css">
</head>

<body>
    <h2>Login (API)</h2>
    <form id="loginForm">
        <label>Email</label>
        <input id="email" type="text" placeholder="email" required />
        <label>Contraseña</label>
        <input id="contrasena" type="password" placeholder="******" required />
        <button type="submit">Iniciar sesión</button>
    </form>
    <h3>Respuesta (JSON)</h3>
    <pre id="output">{}</pre>

    <h3>Probar /api/me</h3>
    <button id="meBtn" type="button">Consultar</button>
    <pre id="meOut">{}</pre>

    <script src="./js/testLogin.js"></script>
</body>

</html><?php /**PATH /var/www/localhost/htdocs/compraFacil/resources/views/testLogin.blade.php ENDPATH**/ ?>