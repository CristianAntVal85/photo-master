<div class="last-box row">
  <div class="col-xs-12 col-sm-4 col-sm-push-4 last-block">
    <div class="partner-box text-center">
      <p>
        <i class="fa fa-map-marker fa-2x sr-icons"></i>
        <span class="text-muted">35 North Drive, Adroukpape, PY 88105, Agoe Telessou</span>
      </p>
      <h4>Our Main Partners</h4>
      <hr>
      <div class="text-muted text-left">
        <?php foreach ($asociadosHomeAleatorios as $asociado): ?>
          <ul class="list-inline">
            <li>
              <img
                src="<?= htmlspecialchars($asociado->getUrl(), ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?= htmlspecialchars($asociado->getDescripcion(), ENT_QUOTES, 'UTF-8'); ?>"
                title="<?= htmlspecialchars($asociado->getDescripcion(), ENT_QUOTES, 'UTF-8'); ?>">
            </li>
            <li><?= htmlspecialchars($asociado->getNombre(), ENT_QUOTES, 'UTF-8'); ?></li>
          </ul>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
