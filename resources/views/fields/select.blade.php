<?php
/**
 * @var \zedsh\zadmin\Fields\SelectField $field
 */
$collection = $field->getCollection();
if(request()->route()->parameterNames()[0] === "admin_news") {
    $news_id = (int)request()->route()->parameter('admin_news');
    $tags_ids = \App\Models\NewsTag::where('news_id', '=', $news_id)->select(
        'tag_id'
    )->get()->toArray();
    $tags_ids = \Illuminate\Support\Arr::flatten($tags_ids, 1);
    $tags = \App\Models\Tag::whereIn('id', $tags_ids)->get();
}
?>
<div class="form-group">
    <label for="{{$field->getName()}}">{{$field->getTitle()}}</label>
    @if(count($tags) > 0)
        <div>Выбранные теги к новости: </div>
        @foreach($tags as $tag)
            <span style="margin-left: 10px;">
                <span
                    style="border: 1px solid grey;padding: 5px; border-radius: 15px;"
                >
                    {{ $tag->title }}
                </span>
                <span
                    style="margin-left: 5px; color: red; cursor: pointer;"
                    class="delete-tag"
                    id="delete-tag.{{$tag->id}}"
                    data-news_id = "{{ $news_id }}"
                    data-tag_id = "{{ $tag->id }}"
                    data-url = "{{ route('delete-tag-relation') }}"
                >
                    Удалить
                </span>
            </span>
        @endforeach
    @endif
    <br>
    <div>Дополните список тегов к новости из предложенного списка ниже:</div>

    <select class="form-control" id="{{$field->getName()}}" name="{{$field->getFormName()}}" {{($field->getMultiple() ? 'multiple' : '')}}>
        @if($field->getNullable())
            <option value="" {{(empty($field->getValue()) ? 'selected' : '')}}>Не выбрано</option>
        @endif
        @foreach($collection as $item)
            @if(in_array($item->{$field->getId()},$tags_ids))
            @else
                <option value="{{$item->{$field->getId()} }}" {{($field->isSelected($item->{$field->getId()}) ? 'selected' : '')}}>{{ $item->{$field->getShowField()} }}</option>
            @endif
        @endforeach
    </select>
    {{--    <div class="valid-feedback">--}}
    {{--        Looks good!--}}
    {{--    </div>--}}
</div>
