<x-alert/>

@csrf()
<div class="card-body">
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" type="text" id="name" name="name" value="{{ $person->name ?? old('name') }}">
    </div>

    <div class="form-group">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type">
            <option value="F" {{ isset($person) ? (($person->type == 'F' ?? old('type') == 'F') ? 'selected' : '') : '' }}>Física</option>
            <option value="J" {{ isset($person) ? (($person->type == 'J' ?? old('type') == 'J') ? 'selected' : '') : '' }}>Jurídica</option>
        </select>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route('person.index') }}" class="btn btn-default float-right">Cancel</a>
</div>
