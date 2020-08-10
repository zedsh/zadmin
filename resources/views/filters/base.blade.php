<?php
/**
 * @var \zedsh\zadmin\Filters\BaseFilter $filter
 */
?>

<form method="GET" action="">
    <div class="form-group row">
        <label for="inputEmail3" class="col-1 col-form-label">{{$filter->getTitle()}}</label>
        <div class="col-8">
            <input name="{{$filter->getFullFieldNameHTML()}}" class="form-control" id="{{$filter->getField()}}" value="{{$filter->getFilterValue()}}">
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </div>
</form>
