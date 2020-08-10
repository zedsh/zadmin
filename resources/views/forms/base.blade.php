    <?php
    /**
     * @var \Zedsh\ZAdmin\Forms\BaseForm $form
     */
    ?>

    <h2>{{$form->getTitle()}}</h2>
    <form action="{{$form->getAction()}}" method="{{$form->getMethod()}}" enctype="{{$form->getEncType()}}">
        @csrf
        {!! $content !!}
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{$form->getBack()}}" role="button" class="btn btn-info">Отменить</a>
    </form>
