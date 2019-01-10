<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">Sección restringida, solo disponible para usuarios capacitados en la plataforma</h5>
	            <?php $this->renderFeedbackMessages(); ?>
                <form id="form.registrarse" method="post" action="<?php echo Config::get('URL'); ?>register/register_action">
                                    <div class="form-group">
                                        <label>Nombre del usuario <small>(todo junto)</small></label>
                                        <input type="text" class="form-control" name="user_name" pattern="[a-zA-Z0-9]{2,64}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>RUT</label>
                                        <input type="text" class="form-control" name="user_rut" pattern="[a-zA-Z0-9]{2,64}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control" name="user_telefono" pattern="[a-zA-Z0-9]{2,64}"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Correo electrónico</label>
                                        <input type="email" class="form-control" name="user_email" />
                                    </div>
                                    <div class="form-group">
                                        <label>Repetir correo</label>
                                        <input type="email" class="form-control" name="user_email_repeat"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña <small>(Mayor o igual a 6 carácteres)</small></label>
                                        <input type="password" class="form-control" name="user_password_new" pattern=".{6,}" />
                                    </div>
                                    <div class="form-group">
                                        <label>Repetir contraseña</label>
                                        <input type="password" class="form-control" name="user_password_repeat" pattern=".{6,}" />
                                    </div>
                                    <div class="form-group">
                                        <label>Escriba los carácteres de la imágen</label>
                                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>register/showCaptcha?' + Math.random(); return false">Recargar Captcha</a>
                                        <img id="captcha" src="<?php echo Config::get('URL'); ?>register/showCaptcha" />
                                        <input type="text" class="form-control" name="captcha" />
                                    </div>
                                    <p class="text-warning" style="display:none;" id="registro.mensaje"></p>
                                    <button type="submit" type="button" class="btn btn-outline-secondary">Registrar</button>
                                </form>
            </div>
        </div>
      </div>
   </div>
</div>