<?php
/**
 * @var \zedsh\zadmin\Lists\Columns\ActionsColumn $column
 */
?>
@if($column->getEditOn())
<a href="{{$column->getEditUrl()}}" role="button" class="btn btn-primary btn-sm">
    <i class="fas fa-pencil-alt fa-xs"></i>
</a>
@endif
@if($column->getDeleteOn())
<a href="{{$column->getDeleteUrl()}}" onclick="return confirm('Удалить?')" role="button" class="btn btn-danger btn-sm">
    <i class="fas fa-trash fa-sm"></i>
</a>
@endif
