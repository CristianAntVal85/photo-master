<?php
require_once __DIR__ . '/../inicio.part.php';
require_once __DIR__ . '/../navegacion.part.php';
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h1>Registrar asociado</h1>
            <hr>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <div class="alert alert-<?= empty($errores) ? 'success' : 'danger'; ?>" role="alert">
                    <?php if (empty($errores)): ?>
                        <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p>
                            <img
                                src="<?= htmlspecialchars($asociado->getUrl(), ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($asociado->getDescripcion(), ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($asociado->getNombre(), ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <form
                class="form-horizontal"
                action="<?= htmlspecialchars($_SERVER['PHP_SELF'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                method="post"
                enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="nombre" class="label-control">Nombre *</label>
                        <input
                            class="form-control"
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="descripcion" class="label-control">Descripción</label>
                        <textarea
                            class="form-control"
                            id="descripcion"
                            name="descripcion"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="logo" class="label-control">Logo *</label>
                        <input
                            class="form-control-file"
                            type="file"
                            id="logo"
                            name="logo"
                            accept="image/jpeg,image/png,image/gif"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <button class="pull-right btn btn-lg sr-button" type="submit">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../fin.part.php'; ?>
