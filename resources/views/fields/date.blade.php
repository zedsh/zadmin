<?php
/**
 * @var \zedsh\zadmin\Fields\TextField $field
 */
?>
<div class="form-group">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <input type="date" class="form-control date @error($field->getName()) is-invalid @enderror" id="{{$field->getName()}}" name="{{$field->getName()}}"
           value="{{$field->getValue()}}">
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
