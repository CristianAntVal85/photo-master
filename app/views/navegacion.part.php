<?php

use dwes\app\utils\Utils;
?> 

<!-- Navigation Bar -->
   <nav class="navbar navbar-fixed-top navbar-default">
     <div class="container">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a  class="navbar-brand page-scroll" href="#page-top">
              <span>[PHOTO]</span>
            </a>
         </div>
         <div class="collapse navbar-collapse navbar-right" id="menu">
            <ul class="nav navbar-nav">

              <!-- HOME -->
              <li class="<?= Utils::esOpcionMenuActiva('/') ? 'active lien' : 'lien' ?>">
                <a href="/"><i class="fa fa-home sr-icons"></i> Home</a>
              </li>

              <!-- ABOUT -->
              <li class="<?= Utils::esOpcionMenuActiva('/about') ? 'active lien' : 'lien' ?>">
                <a href="/about"><i class="fa fa-bookmark sr-icons"></i> About</a>
              </li>

              <!-- BLOG -->
              <li class="<?= Utils::esOpcionMenuActiva('/blog') ? 'active lien' : 'lien' ?>">
                <a href="/blog"><i class="fa fa-file-text sr-icons"></i> Blog</a>
              </li>

              <!-- CONTACT -->
              <li class="<?= Utils::esOpcionMenuActiva('/contact') ? 'active lien' : 'lien' ?>">
                <a href="/contact"><i class="fa fa-phone-square sr-icons"></i> Contact</a>
              </li>

              <!-- GALERY -->
              <li class="<?= Utils::esOpcionMenuActiva('/galeria') ? 'active lien' : 'lien' ?>">
                <a href="/galeria"><i class="fa fa-phone-square sr-icons"></i> Galery</a>
              </li>

              <!-- ASOCIADOS -->
              <li class="<?= Utils::esOpcionMenuActiva('/asociados') ? 'active lien' : 'lien' ?>">
                <a href="/asociados"><i class="fa fa-handshake-o sr-icons"></i> Registrar asociado</a>
              </li>
            </ul>
         </div>
     </div>
   </nav>
<!-- End of Navigation Bar -->