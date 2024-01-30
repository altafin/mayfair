<x-alert/>

@csrf()
<label>Name</label>
<input type="text" name="name" value="{{ $person->name ?? old('name') }}">
<br><label>Type</label>
<select name="type">
    <option value="F" {{ isset($person) ? (($person->type == 'F' ?? old('type') == 'F') ? 'selected' : '') : '' }}>Física</option>
    <option value="J" {{ isset($person) ? (($person->type == 'J' ?? old('type') == 'J') ? 'selected' : '') : '' }}>Jurídica</option>
</select>
<br>
<button type="submit">Enviar</button>
