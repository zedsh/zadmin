<?php

namespace zedsh\zadmin\Builder\Builders;

use zedsh\zadmin\Builder\Structures\DescriptionColumn;
use zedsh\zadmin\Builder\Structures\DescriptionField;
use zedsh\zadmin\Builder\Structures\DescriptionForm;
use zedsh\zadmin\Builder\Structures\DescriptionList;
use zedsh\zadmin\Builder\Structures\DescriptionMenu;
use zedsh\zadmin\Builder\Structures\DescriptionMenuItem;

use zedsh\zadmin\Builder\Elements\Fields;
use zedsh\zadmin\Builder\Elements\Form;
use zedsh\zadmin\Builder\Elements\Lists;
use zedsh\zadmin\Builder\Elements\Lists\Columns;
use zedsh\zadmin\Builder\Elements\Menu;

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
interface BuilderInterface
{
    public function getForm() : ?DescriptionForm;

    /**
     * @return DescriptionField[]
     */
    public function getFields() : array;

    public function getList() : ?DescriptionList;

    /**
     * @return DescriptionColumn[]
     */
    public function getColumns() : array;

    public function getMenu() : DescriptionMenu;

    /**
     * @return DescriptionMenuItem[]
     */
    public function getMenuItems() : array;
}
