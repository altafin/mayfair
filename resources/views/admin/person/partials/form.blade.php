<x-alert/>

@csrf()
<div class="card-body">
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $person->name ?? old('name') }}">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type">
                    <option value="F" {{ isset($person) ? (($person->type == 'F' ?? old('type') == 'F') ? 'selected' : '') : '' }}>Física</option>
                    <option value="J" {{ isset($person) ? (($person->type == 'J' ?? old('type') == 'J') ? 'selected' : '') : '' }}>Jurídica</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="document">CPF</label>
                <input class="form-control" data-inputmask="'mask':'999.999.999-99'" data-mask type="text" id="document" name="document" value="{{ $person->name ?? old('name') }}">
            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route(strtolower($model) . '.index') }}" class="btn btn-default float-right">Cancel</a>
</div>
