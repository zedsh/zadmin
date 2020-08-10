<?php
/**
 * @var \zedsh\zadmin\Fields\BooleanField $field
 */
?>
<div class="form-group">
    <div class="form-check form-check-inline">
        <input type="hidden" name="{{$field->getName()}}" value="0">
        <input type="checkbox" class="form-check-input" id="{{$field->getName()}}"
               name="{{$field->getName()}}" {{($field->getValue() ? 'checked' : '') }} value="1">
        <label class="form-check-label" for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    </div>
</div>
