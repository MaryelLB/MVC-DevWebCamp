<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del evento</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Evento</label>
        <input
        class="formulario__input"
        type="text"
        id="nombre"
        name="nombre"
        placeholder="Nombre Evento"
        value="<?php echo $evento->nombre ?>"
        >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripción Evento</label>
        <textarea
        class="formulario__input"
        id="descripcion"
        name="descripcion"
        placeholder="Descripcion Evento"
        rows="8"
        ><?php echo $evento->descripcion ?></textarea>
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="categoria_id">Categoria Tipo de Evento:</label>
        <select
        class="formulario__select"
        name="categoria_id"
        id="categoria">
            <option value="">---Seleccionar</option>
            <?php foreach($categorias as $categoria){ ?>
                <option <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : '' ?> value="<?php echo($categoria->id); ?>"><?php echo($categoria->nombre); ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Seleccionar el día</label>
        <div class="formulario__radio">
            <?php foreach($dias as $dia) { ?>
                <div>
                    <label for="<?php strtolower($dia->nombre) ?>"><?php echo $dia->nombre ?></label>
                    <input
                    type="radio"
                    id="<?php strtolower($dia->nombre) ?>"
                    name="dia"
                    value="<?php echo $dia->id ?>"
                    <?php echo ($evento->dia_id === $dia->id) ? 'checked' : ''; ?>
                    >
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="dia_id" value="<?php echo $evento->dia_id ?>">
        
    </div>

    <div id="horas" class="formulario__campo">
        <label class="formulario__label">Seleccionar Hora</label>
        <ul id="horas" class="horas">
            <?php foreach($horas as $hora) { ?>
                <li data-hora-id ="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
            <?php } ?>
        </ul>
        <input type="hidden" name="hora_id" value="<?php echo $evento->hora_id; ?>">
    </div>

</fieldset>

<fieldset class="formulario__fieldset">
<legend class="formulario__legend">Información extra</legend>
<div class="formulario__campo">
        <label class="formulario__label" for="ponentes">Ponente</label>
        <input
        class="formulario__input"
        type="text"
        id="ponentes"
        placeholder="Buscar ponente"
        >
        <ul id="listado-ponentes" class="listado-ponentes"></ul>
        <input type="hidden" name="ponente_id" value="<?php echo $evento->ponente_id; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="disponibles">Lugares disponibles</label>
        <input
        class="formulario__input"
        type="number"
        min="1"
        id="disponibles"
        name="disponibles"
        placeholder="Ej. 20"
        value="<?php echo $evento->disponibles; ?>"
        >
    </div>
</fieldset>