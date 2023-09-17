<?php
/**
 * @var \zedsh\zadmin\Lists\TableList $table
 */
?>

<h2>{{$table->getTitle()}} @if($table->getAdd()) <a href="{{$table->getAddPath()}}" role="button"
                                                    class="btn btn-primary btn-sm">
        <i class="fas fa-plus fa-xs"></i>
    </a> @endif</h2>

@if(!empty($table->getFilters()))
<div class="row">
    <div class="col-12">
        {!! $table->getFiltersRenderedContent() !!}
    </div>
</div>
@endif

<table class="table table-striped table-sm">
    <thead>
    <tr>
        @foreach($table->getColumns() as $column)
            <th scope="col" @if($column->getWidth()) width="{{$column->getWidth()}}" @endif>{{$column->getTitle()}}
                @if($column->getSort())
                    <a href="{{request()->fullUrlWithQuery(['sort' => $column->getName(), 'direction' => 'asc'])}}"><i class="fas fa-angle-up"
                          @if(request()->input('sort') == $column->getName() && request()->input('direction') == 'asc') style="color:red;" @endif></i></a>
                    <a href="{{request()->fullUrlWithQuery(['sort' => $column->getName() , 'direction' => 'desc'])}}"><i class="fas fa-angle-down"
                          @if(request()->input('sort') == $column->getName() && request()->input('direction') == 'desc') style="color:red;" @endif></i></a>
                @endif
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($table->items() as $item)
        <tr>
            @foreach($table->getColumns() as $column)
                <td>{!! $column->setModel($item)->render() !!}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

@if($table->getPaginate())
    {{ $table->getRenderedPaginationContent() }}
@endif
