<?php
/**
 * @var \Zedsh\ZAdmin\Fields\TextField $field
 */

?>
<div class="form-group">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <textarea class="form-control mce @error($field->getName()) is-invalid @enderror" id="{{$field->getName()}}" name="{{$field->getName()}}">{!! $field->getValue() !!}</textarea>
    @error($field->getName())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
