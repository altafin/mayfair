<x-alert/>

@csrf()
<div class="card-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="name">Nome</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $person->name ?? old('name') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="type">Tipo</label>
                <select class="form-control" id="type" name="type">
                    <option value="F" {{ isset($person) ? (($person->type == 'F' ?? old('type') == 'F') ? 'selected' : '') : '' }}>Física</option>
                    <option value="J" {{ isset($person) ? (($person->type == 'J' ?? old('type') == 'J') ? 'selected' : '') : '' }}>Jurídica</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="document">{{ isset($person) ? $person->type == 'F' ?? old('type') == 'F' ? 'CPF' : 'CNPJ' : 'CPF' }}</label>
                <input class="form-control" data-inputmask="'mask':'999.999.999-99'" data-mask type="text" id="document" name="document" value="{{ $person->documents[0]['value'] ?? old('document') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="zip_code">CEP</label>
                <input class="form-control" data-inputmask="'mask':'99999-999'" data-mask type="text" id="zip_code" name="zip_code" value="{{ $person->addresses[0]['zip_code'] ?? old('zip_code') }}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="address">Endereço</label>
                <input class="form-control" type="text" id="street" name="street" value="{{ $person->addresses[0]['street'] ?? old('street') }}">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="number">Número</label>
                <input class="form-control" type="text" id="number" name="number" value="{{ $person->addresses[0]['number'] ?? old('number') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="complement">Complemento</label>
                <input class="form-control" type="text" id="complement" name="complement" value="{{ $person->addresses[0]['complement'] ?? old('complement') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="uf">UF</label>
                <select class="custom-select rounded-1" id="uf" name="uf">
                    <option value=""></option>
                    <option value="PR">Paraná</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="city">Cidade</label>
                <select class="custom-select rounded-1" id="city" name="city">
                    <option value=""></option>
                    <option value="Londrina">Londrina</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="district">Bairro</label>
                <input class="form-control" type="text" id="district" name="district" value="{{ $person->addresses[0]['district'] ?? old('district') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="reference">Ponto de referência</label>
                <input class="form-control" type="text" id="reference" name="reference" value="{{ $person->addresses[0]['reference'] ?? old('reference') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input class="form-control" data-inputmask-alias="email" data-mask type="text" id="email" name="email" value="{{ $person->addresses[0]['email'] ?? old('email') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="cell">Telefone celular</label>
                <input class="form-control" data-inputmask="'mask':'(99) 99999-9999'" data-mask type="text" id="cell" name="cell" value="{{ $person->addresses[0]['cell'] ?? old('cell') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="phone">Telefone fixo</label>
                <input class="form-control" data-inputmask="'mask':'(99) 99999-9999'" data-mask type="text" id="phone" name="phone" value="{{ $person->addresses[0]['phone'] ?? old('phone') }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="website">Website</label>
                <input class="form-control" data-inputmask-alias="url" data-mask type="text" id="website" name="website" value="{{ $person->addresses[0]['website'] ?? old('website') }}">
            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route(strtolower($model) . '.index') }}" class="btn btn-default float-right">Cancel</a>
</div>
