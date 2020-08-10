<?php
/**
 * @var \Zedsh\ZAdmin\Fields\SelectField $field
 */
$collection = $field->getCollection();
?>
<div class="form-group">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    <select class="form-control" id="{{$field->getName()}}" name="{{$field->getFormName()}}" {{($field->getMultiple() ? 'multiple' : '')}}>
        @if($field->getNullable())
            <option value="" {{(empty($field->getValue()) ? 'selected' : '')}}>Не выбрано</option>
        @endif
        @foreach($collection as $item)
            <option value="{{$item->{$field->getId()} }}" {{($field->isSelected($item->{$field->getId()}) ? 'selected' : '')}}>{{ $item->{$field->getShowField()} }}</option>
        @endforeach
    </select>
    {{--    <div class="valid-feedback">--}}
    {{--        Looks good!--}}
    {{--    </div>--}}
</div>
