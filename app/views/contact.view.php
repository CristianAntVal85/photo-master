<!-- Principal Content Start -->
   <div id="contact">
   	  <div class="container">
   	    <div class="col-xs-12 col-sm-8 col-sm-push-2">
       	   <h1>CONTACT US</h1>
       	   <hr>
       	   <p>Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
	       <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
	       	<div class="alert alert-<?= empty($errores) ? 'success' : 'danger'; ?>" role="alert">
	       		<?php if (empty($errores)) : ?>
	       			<?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>
	       		<?php else : ?>
	       			<ul>
	       				<?php foreach ($errores as $error) : ?>
	       					<li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
	       				<?php endforeach; ?>
	       			</ul>
	       		<?php endif; ?>
	       	</div>
	       <?php endif; ?>
	       <form class="form-horizontal" action="/contact/enviar" method="post" enctype="multipart/form-data">
	       	  <div class="form-group">
	       	  	<div class="col-xs-6">
	       	  	    <label class="label-control">First Name</label>
                    <input class="form-control" type="text" name="nombre" required>
	       	  	</div>
	       	  	<div class="col-xs-6">
	       	  	    <label class="label-control">Last Name</label>
                    <input class="form-control" type="text" name="apellidos">
	       	  	</div>
	       	  </div>
	       	  <div class="form-group">
	       	  	<div class="col-xs-12">
	       	  		<label class="label-control">Email</label>
                    <input class="form-control" type="email" name="email" required>
	       	  	</div>
	       	  </div>
	       	  <div class="form-group">
	       	  	<div class="col-xs-12">
	       	  		<label class="label-control">Subject</label>
                    <input class="form-control" type="text" name="asunto" required>
	       	  	</div>
	       	  </div>
	       	  <div class="form-group">
	       	  	<div class="col-xs-12">
	       	  		<label class="label-control">Message</label>
                    <textarea class="form-control" name="mensaje"></textarea>
					 <!-- CAPTCAHA --> 
	       	  		<label class="label-control" for="captcha">Introduce el CAPTCHA:</label>
                <img src="/app/utils/captcha.php?v=<?= htmlspecialchars($captchaImageToken, ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen CAPTCHA">
	       	  		<input class="form-control" id="captcha" name="captcha" type="text">
	       	  		<button class="pull-right btn btn-lg sr-button" type="submit">SEND</button>
	       	  	</div>
	       	  </div>
	       </form>
	       <hr class="divider">
	       <div class="address">
	           <h3>GET IN TOUCH</h3>
	           <hr>
	           <p>Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero.</p>
	       </div>
	    </div>   
   	  </div>
   </div>
<!-- Principal Content Start -->
