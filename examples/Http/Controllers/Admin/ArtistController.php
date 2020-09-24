<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Fields\BooleanField;
use App\Admin\Fields\FileField;
use App\Admin\Fields\HiddenField;
use App\Admin\Fields\TextField;
use App\Admin\Fields\SelectField;
use App\Admin\Fields\TinyMceAreaField;
use App\Admin\Filters\FulltextFilter;
use App\Admin\Forms\BaseForm;
use App\Admin\Lists\Columns\ActionsColumn;
use App\Admin\Lists\Columns\RawColumn;
use App\Admin\Lists\Columns\RelatedTextColumn;
use App\Admin\Lists\Columns\TextColumn;
use App\Admin\Lists\TableList;
use App\Admin\Templates\BaseTemplate;
use App\Artist;
use App\ArtistType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArtistRequest;
use Illuminate\Http\Request;

class ArtistController extends AdminController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function deleteFile($field, $modelId, $id)
    {
        $model = Artist::query()->findOrFail($modelId);
        /**
         * @var Artist $model
         */
        $model->deleteFile($field, $id);
        return back();
    }

    public function delete($id)
    {
        Artist::query()->findOrFail($id)->delete();
        return response()->redirectToRoute('artist.list');
    }

    public function save(ArtistRequest $request)
    {
        if (!empty($request->input('id'))) {
            $model = Artist::query()->findOrFail($request->input('id'));
        } else {
            $model = new Artist();
        }

        $model->fill($request->all());
        $model->addFiles($request->all());
        $model->save();
        if(!empty($model->photo[0]['path'])) {
            $model->resize(Artist::ARTIST_LIST_RESIZE, $model->photo[0]['path']);
        }
        return response()->redirectToRoute('artist.edit',['id' => $model->id])->with('message',['class' => 'alert-success', 'text' => 'Успешно обновлено.']);
    }

    public function edit($id)
    {

        $model = Artist::query()->findOrFail($id);
        $form = new BaseForm('main', [
            (new HiddenField('id'))->setValue($id),
            new TextField('name', 'Имя'),
            (new TextField('slug', 'Символьный код')),
            (new BooleanField('on_index','Показывать на главной')),
            new TinyMceAreaField('description', 'Описание'),
            (new FileField('photo', 'Основное фото')),
            (new FileField('additional_photos', 'Дополнительные фото'))->setRemoveRoute('artist.deleteFile')->setMultiple(),
            (new SelectField('artist_type_id', 'Тип ариста'))->setCollection(ArtistType::all()->keyBy('id')),
            (new RawColumn('socials', ''))->setContent(
                (new TableList('ArtistSocialsList'))->setTitle('Социальные сети')->enableAdd()->setAddPath(route('artist.social.add',
                    ['artistId' => $model->id]))->setColumns([
                        (new ActionsColumn())->setEditRoute('artist.social.edit')->setEditOn()
                            ->setDeleteRoute('artist.social.delete')
                            ->setDeleteOn()
                            ->setRouteParams([
                                'id' => function ($social) {
                                    return $social->pivot->id;
                                }
                            ]),
                        (new TextColumn('name', 'Соц.сеть')),
                        (new RawColumn('link', 'Ссылка'))->setClosure(function ($social) {
                            return $social->pivot->link;
                        }),
                    ]
                )->setQuery($model->socials())->render()),
        ]);
        $form->setModel($model);
        $form->setTitle('Артист');
        $form->setBack(route('artist.list'));
        $form->setAction(route('artist.save', ['id' => $id]));

        return $this->render($form);
    }

    public function add()
    {

        $model = new Artist();
        $form = new BaseForm('main', [
            new TextField('name', 'Имя'),
            (new TextField('slug', 'Символьный код'))->setSlugFrom('name'),
            (new BooleanField('on_index','Показывать на главной')),
            new TinyMceAreaField('description', 'Описание'),
            (new FileField('photo', 'Основное фото')),
            (new FileField('additional_photos', 'Дополнительные фото'))->setRemoveRoute('artist.deleteFile')->setMultiple(),
            (new SelectField('artist_type_id', 'Тип ариста'))->setCollection(ArtistType::all()->keyBy('id')),
        ]);
        $form->setModel($model);
        $form->setTitle('Новый артист');
        $form->setAction(route('artist.save'));

        return $this->render($form);
    }

    public function list()
    {
        $list = new TableList('ArtistList');
        $list->setTitle('Список артистов');
        $list->setColumns([
            (new ActionsColumn())->setEditRoute('artist.edit')->setDeleteRoute('artist.delete')->setDeleteOn()->setEditOn()->setRouteParams(['id']),
            (new TextColumn('id', '#'))->setWidth(50),
            new TextColumn('name', 'Имя'),
        ]);
        $list->enableAdd();
        $list->setAddPath(route('artist.add'));
        $list->setQuery(Artist::query());
        $list->enablePaginate();
        $list->setItemsOnPage(10);
        $list->setFilters([(new FulltextFilter('Имя:','name'))]);

        return $this->render($list);
    }
}
