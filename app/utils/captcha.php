<?php

if (!extension_loaded('gd')) {
    throw new RuntimeException('La extensión GD de PHP no está habilitada.');
}

$captchaFont = __DIR__ . '/DejaVuSans.ttf';
if (!is_file($captchaFont)) {
    throw new RuntimeException('No se encuentra la fuente del CAPTCHA: ' . $captchaFont);
}

if (session_start() === false) {
    throw new RuntimeException('No se pudo iniciar la sesión del CAPTCHA.');
}

$captcha = '';
$totalCharacteres = random_int(5, 8);
$posiblesLetras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
$captchaFontSize = random_int(30, 40);

for ($caracter = 0; $caracter < $totalCharacteres; $caracter++) {
    $captcha .= $posiblesLetras[random_int(0, strlen($posiblesLetras) - 1)];
}

$textBox = imagettfbbox($captchaFontSize, 0, $captchaFont, $captcha);
if ($textBox === false) {
    throw new RuntimeException('No se pudo calcular el tamaño del texto del CAPTCHA.');
}

$minX = min($textBox[0], $textBox[2], $textBox[4], $textBox[6]);
$maxX = max($textBox[0], $textBox[2], $textBox[4], $textBox[6]);
$minY = min($textBox[1], $textBox[3], $textBox[5], $textBox[7]);
$maxY = max($textBox[1], $textBox[3], $textBox[5], $textBox[7]);
$margen = 10;
$ancho = $maxX - $minX + ($margen * 2);
$alto = $maxY - $minY + ($margen * 2);

$randomLineas = $captchaFontSize > 35 ? 10 : 14;
$imagen = imagecreatetruecolor($ancho, $alto);
if ($imagen === false) {
    throw new RuntimeException('No se pudo crear la imagen del CAPTCHA.');
}

$colorBlanco = imagecolorallocate($imagen, 255, 255, 255);
$colorLineas = imagecolorallocate($imagen, 150, 150, 150);
$colorTexto = imagecolorallocate($imagen, 0, 0, 120);
imagefill($imagen, 0, 0, $colorBlanco);

for ($contadorLineas = 0; $contadorLineas < $randomLineas; $contadorLineas++) {
    imageline(
        $imagen,
        random_int(0, $ancho - 1),
        0,
        random_int(0, $ancho - 1),
        $alto - 1,
        $colorLineas
    );
}

$textoDibujado = imagettftext(
    $imagen,
    $captchaFontSize,
    0,
    $margen - $minX,
    $margen - $minY,
    $colorTexto,
    $captchaFont,
    $captcha
);
if ($textoDibujado === false) {
    imagedestroy($imagen);
    throw new RuntimeException('No se pudo dibujar el texto del CAPTCHA.');
}

ob_start();
$imagenGenerada = imagepng($imagen);
$contenidoImagen = ob_get_clean();
imagedestroy($imagen);
if ($imagenGenerada === false || $contenidoImagen === false) {
    throw new RuntimeException('No se pudo generar la imagen PNG del CAPTCHA.');
}

$_SESSION['captchaGenerado'] = $captcha;
if (session_write_close() === false) {
    throw new RuntimeException('No se pudo guardar el CAPTCHA en la sesión.');
}

header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate');
echo $contenidoImagen;
