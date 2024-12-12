<div>
    <div class="mb-3">
        <label for="validationServerUsername" class="form-label">إسم المتجر باللغة الإنجليزية</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend3">{{request()->host()}}</span>
          <input name="store_name" wire:model="tenant_name" wire:keyup="isRegistered" type="text" class="form-control is-{{$statu}} @error('store_name') is-invalid @enderror" value="{{old('store_name')}}" id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required onkeypress="return a(event);" onpaste="return false;" ondrop="return false;" placeholder="yourstore">
          <div id="validationServerUsernameFeedback" class="{{$statu}}-feedback">
            {{$message}}.
          </div>
          @error('store_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
        </div>
      </div>
</div>

