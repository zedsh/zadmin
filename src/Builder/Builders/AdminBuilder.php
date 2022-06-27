<?php

namespace zedsh\zadmin\Builder\Builders;

use zedsh\zadmin\Builder\Exceptions\FieldNameEmptyException;
use zedsh\zadmin\Builder\Exceptions\ArgumentNameEmptyException;
use zedsh\zadmin\Builder\Exceptions\MethodNotAllowedException;
use zedsh\zadmin\Builder\Elements\Fields;
use zedsh\zadmin\Builder\Elements\Form;
use zedsh\zadmin\Builder\Elements\Lists;
use zedsh\zadmin\Builder\Elements\Lists\Columns;
use zedsh\zadmin\Builder\Elements\Menu;
use zedsh\zadmin\Builder\Structures\BaseDescription;
use zedsh\zadmin\Builder\Structures\BaseDescriptionType;
use zedsh\zadmin\Builder\Structures\DescriptionColumn;
use zedsh\zadmin\Builder\Structures\DescriptionField;
use zedsh\zadmin\Builder\Structures\DescriptionForm;
use zedsh\zadmin\Builder\Structures\DescriptionList;
use zedsh\zadmin\Builder\Structures\DescriptionMenu;
use zedsh\zadmin\Builder\Structures\DescriptionMenuItem;
use zedsh\zadmin\Builder\Traits\MagicMethod;
use zedsh\zadmin\Builder\Workers\PageInterface;

/**
 * @method Form\BaseFormInterface setForm(string $name)
 *
 * @method Fields\BaseFieldInterface addFieldBoolean(string $name, string $title)
 * @method Fields\DateFieldInterface addFieldDate(string $name, string $title)
 * @method Fields\FileFieldInterface addFieldFile(string $name, string $title)
 * @method Fields\BaseFieldInterface addFieldHidden(string $name, string $title)
 * @method Fields\BaseFieldInterface addFieldPassword(string $name, string $title)
 * @method Fields\SelectFieldInterface addFieldSelect(string $name, string $title)
 * @method Fields\TextAreaFieldInterface addFieldTextArea(string $name, string $title)
 * @method Fields\TextFieldInterface addFieldText(string $name, string $title)
 * @method Fields\BaseFieldInterface addFieldTinyMceArea(string $name, string $title)
 *
 * @method Lists\TableListInterface setList(string $name)
 *
 * @method Columns\ActionsColumnInterface addColumnActions(string $name = 'actionsColumn', string $title = 'Действия')
 * @method Columns\ActionsColumnInterface addColumnCustom(string $name, string $title)
 * @method Columns\ActionsColumnInterface addColumnRaw(string $name, string $title)
 * @method Columns\ActionsColumnInterface addColumnRelatedText(string $name, string $title)
 * @method Columns\ActionsColumnInterface addColumnSequenceNumber(string $name, string $title)
 * @method Columns\ActionsColumnInterface addColumnText(string $name, string $title)
 *
 * @method Menu\BaseMenuInterface setMenu(array $items = [])
 * @method Menu\BaseMenuItemInterface addMenuItem(string $title, string $route = '')
 */
class AdminBuilder implements BuilderInterface
{
    use MagicMethod;

    /** @var PageInterface $worker */
    protected $worker;

    /** @var DescriptionForm $form */
    protected $form;

    /** @var DescriptionField[] $fields */
    protected $fields = [];

    /** @var DescriptionList $list */
    protected $list;

    /** @var DescriptionColumn[] $columns */
    protected $columns = [];

    /** @var DescriptionMenu $menu */
    protected $menu;

    /** @var DescriptionMenuItem[] $menuItems */
    protected $menuItems = [];

    public function __construct(PageInterface $worker)
    {
        $this->worker = $worker;
        $this->isFindMagicMethod = false;

        $this->fields = [];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return BaseDescription|BaseDescriptionType|null
     * @throws FieldNameEmptyException
     * @throws ArgumentNameEmptyException
     * @throws MethodNotAllowedException
     */
    public function __call(string $name, array $arguments)
    {
        $this->isFindMagicMethod = false;
        $results = [];
        $results[] = $this->callSetForm($name, $arguments);
        $results[] = $this->callAddField($name, $arguments);
        $results[] = $this->callSetList($name, $arguments);
        $results[] = $this->callAddColumn($name, $arguments);
        $results[] = $this->callSetMenu($name, $arguments);
        $results[] = $this->callAddMenuItem($name, $arguments);

        $this->checkFindMagicMethod($name);

        return $this->prepareReturnMagicMethod($results);
    }

    /**
     * @throws ArgumentNameEmptyException
     */
    protected function callSetForm(string $name, array $arguments): ?DescriptionForm
    {
        if (strpos($name, 'setForm') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        if (empty(trim($arguments[0]))) {
            throw new ArgumentNameEmptyException('Аргумент name не должен быть пустым');
        }

        $this->form = new DescriptionForm(['name' => $arguments[0]]);
        return $this->form;
    }

    /**
     * @throws FieldNameEmptyException
     */
    protected function callAddField(string $name, array $arguments): ?DescriptionField
    {
        if (strpos($name, 'addField') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        $nameParameter = str_replace('addField', '', $name);
        return $this->addField($nameParameter, $arguments[0], $arguments[1]);
    }

    /**
     * @throws FieldNameEmptyException
     */
    protected function addField(string $type, string $name, string $title): DescriptionField
    {
        if (empty(trim($name))) {
            throw new FieldNameEmptyException('Имя поля не должно быть пустым');
        }

        $this->fields[] = new DescriptionField(
            $type,
            ['name' => trim($name), 'title' => trim($title)]
        );

        return $this->fields[count($this->fields) -1];
    }

    /**
     * @throws ArgumentNameEmptyException
     */
    protected function callSetList(string $name, array $arguments): ?DescriptionList
    {
        if (strpos($name, 'setList') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        if (empty(trim($arguments[0]))) {
            throw new ArgumentNameEmptyException('Аргумент name не должен быть пустым');
        }

        $this->list = new DescriptionList(['name' => $arguments[0]]);
        return $this->list;
    }

    protected function callAddColumn(string $name, array $arguments): ?DescriptionColumn
    {
        if (strpos($name, 'addColumn') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        $nameParameter = str_replace('addColumn', '', $name);
        return $this->addColumn(
            $nameParameter,
            $arguments ? $arguments[0] : '',
            $arguments ? $arguments[1] : ''
        );
    }

    protected function addColumn(string $type, string $name, string $title): DescriptionColumn
    {
        $this->columns[] = new DescriptionColumn(
            $type,
            ['name' => trim($name), 'title' => trim($title)]
        );

        return $this->columns[count($this->columns) -1];
    }

    protected function callSetMenu(string $name, array $arguments): ?DescriptionMenu
    {
        if (strpos($name, 'setMenu') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        $this->menu = new DescriptionMenu(['items' => $arguments ? $arguments[0] : []]);
        return $this->menu;
    }

    /**
     * @throws ArgumentNameEmptyException
     */
    protected function callAddMenuItem(string $name, array $arguments): ?DescriptionMenuItem
    {
        if (strpos($name, 'addMenuItem') !== 0) { return null; }
        $this->isFindMagicMethod = true;

        if (empty(trim($arguments[0]))) {
            throw new ArgumentNameEmptyException('Аргумент title не должен быть пустым');
        }
        $this->menuItems[] = new DescriptionMenuItem([
            'title' => $arguments[0],
            'route' => $arguments ? $arguments[1] : '',
        ]);

        return $this->menuItems[count($this->menuItems) -1];
    }

    public function setWorker(PageInterface $worker)
    {
        $this->worker = $worker;
    }

    public function render(): string
    {
        return $this->worker->setBuilder($this)->render();
    }

    public function getForm(): ?DescriptionForm
    {
        return $this->form;
    }

    /**
     * @return DescriptionField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getList(): ?DescriptionList
    {
        return $this->list;
    }

    /**
     * @return DescriptionColumn[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getMenu(): DescriptionMenu
    {
        return  $this->menu;
    }

    /**
     * @return DescriptionMenuItem[]
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }
}
