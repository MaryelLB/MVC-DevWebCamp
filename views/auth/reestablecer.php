<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Coloca tu nuevo password</p>

<?php if(isset($token_valido)) { ?>
    <form method="POST">
    <div class="formulario__campo">
            <label for="password" class="formulario__label">Nuevo Password</label>
            <input
            type="password"
            class="formulario__input"
            placeholder="Tu nuevo password"
            id="password"
            name="password"
            >
        </div>
        <input class="formulario__submit" type="submit" value="Guardar password">
    </form>
<?php } ?>
</main>