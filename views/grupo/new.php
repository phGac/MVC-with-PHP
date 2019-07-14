<br/>
<div class="text-center">
	<h4>Agregar Grupo</h4>
	<hr/>
</div>

<form id="formulario" onsubmit="_create('grupo'); return false;" method="post" autocomplete="off" class="form-group">
	<div id="specialspace" name="specialspace"></div>
	<br>
	<label for="nombre">Nombre(*):</label>
	<input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z0-9_- ]{4,25}" title="Sólo se aseptan: Mayúsculas, minusculas, espacios, números, guiones. Mínimo 4 carácteres, máximo 25 caracteres\">
	<br>
	<label for="abreviatura">Abreviatura(*):</label>
	<input type="text" class="form-control" id="abreviatura" name="abreviatura">
	<br>
	<label for="estado">Estado(*)</label>
	<select id="estado" name="estado" class="form-control">
		<option value=""></option>
		<option value="1">ACTIVO</option>
		<option value="0">INACTIVO</option>
	</select>
	<br>
	<h6>(*) Campos Necesarios</h6>
	<br>
	<input type="submit" class="btn btn-primary" value="Enviar">
</form>

