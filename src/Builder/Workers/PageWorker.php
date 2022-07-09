<?php

namespace zedsh\zadmin\Builder\Workers;

use App\Admin\Menu\BaseMenuItem;
use zedsh\zadmin\Builder\Exceptions\ClassNotFoundException;
use zedsh\zadmin\Builder\Structures\BaseDescription;
use zedsh\zadmin\Builder\Structures\BaseDescriptionType;
use zedsh\zadmin\Builder\Structures\DescriptionColumn;
use zedsh\zadmin\Builder\Structures\DescriptionField;
use zedsh\zadmin\Builder\Structures\DescriptionForm;
use zedsh\zadmin\Builder\Builders\BuilderInterface;
use zedsh\zadmin\Builder\Structures\DescriptionList;
use zedsh\zadmin\Builder\Structures\DescriptionMenu;
use zedsh\zadmin\Builder\Structures\DescriptionMenuItem;
use Illuminate\Contracts\Container\BindingResolutionException;
use zedsh\zadmin\Forms\BaseForm;
use zedsh\zadmin\Fields\BooleanField;
use zedsh\zadmin\Fields\DateField;
use zedsh\zadmin\Fields\FileField;
use zedsh\zadmin\Fields\HiddenField;
use zedsh\zadmin\Fields\PasswordField;
use zedsh\zadmin\Fields\SelectField;
use zedsh\zadmin\Fields\TextField;
use zedsh\zadmin\Fields\TinyMceAreaField;
use zedsh\zadmin\Lists\Columns\ActionsColumn;
use zedsh\zadmin\Lists\Columns\CustomColumn;
use zedsh\zadmin\Lists\Columns\RawColumn;
use zedsh\zadmin\Lists\Columns\RelatedTextColumn;
use zedsh\zadmin\Lists\Columns\SequenceNumberColumn;
use zedsh\zadmin\Lists\Columns\TextColumn;
use zedsh\zadmin\Lists\TableList;
use zedsh\zadmin\Menu\BaseMenu;
use function app;



class PageWorker implements PageInterface
{
    /** @var BuilderInterface $builder */
    protected $builder;

    /** @var string[] */
    protected $fieldClasses = [];

    /** @var string $formClass */
    protected $formClasses = [];

    /** @var string[] $columnClasses */
    protected $columnClasses = [];

    /** @var string $listClass */
    protected $listClasses = [];

    /** @var string $menu */
    protected $menuClass = '';
    /** @var string $menuItem */
    protected $menuItemClass = '';

    /** @var string $template */
    protected $template = '';

    public function __construct()
    {
        $this->setFieldClass('Boolean', BooleanField::class)
            ->setFieldClass('Date',DateField::class)
            ->setFieldClass('File', FileField::class)
            ->setFieldClass('Hidden', HiddenField::class)
            ->setFieldClass('Password', PasswordField::class)
            ->setFieldClass('Select', SelectField::class)
            ->setFieldClass('TextArea', SelectField::class)
            ->setFieldClass('Text', TextField::class)
            ->setFieldClass('TinyMceArea', TinyMceAreaField::class)
            ->setFormClass('Base', BaseForm::class)

            ->setColumnClass('Actions', ActionsColumn::class)
            ->setColumnClass('Custom', CustomColumn::class)
            ->setColumnClass('Raw', RawColumn::class)
            ->setColumnClass('RelatedText', RelatedTextColumn::class)
            ->setColumnClass('SequenceNumber', SequenceNumberColumn::class)
            ->setColumnClass('Text', TextColumn::class)
            ->setListClass('Table',TableList::class)

            ->setMenuClass(BaseMenu::class)
            ->setMenuItemClass(BaseMenuItem::class)

            ->setTemplate('zadmin::layouts.admin');

    }

    public function setFieldClass(string $fieldType, string $class): PageWorker
    {
        $this->fieldClasses[$fieldType] = $class;
        return $this;
    }

    public function setFormClass(string $class): PageWorker
    {
        $this->formClass = $class;
        return $this;
    }

    public function setColumnClass(string $columnType, string $class): PageWorker
    {
        $this->columnClasses[$columnType] = $class;
        return $this;
    }

    public function setListClass(string $classType, string $class): PageWorker
    {
        $this->listClasses[$classType] = $class;
        return $this;
    }

    public function setMenuClass(string $class): PageWorker
    {
        $this->menuClass = $class;
        return $this;
    }

    public function setMenuItemClass(string $class): PageWorker
    {
        $this->menuItemClass = $class;
        return $this;
    }

    public function setTemplate(string $path): PageWorker
    {
        $this->template = $path;
        return $this;
    }

    public function getFieldClassNameByType(string $fieldType) : string
    {
        return $this->fieldClasses[$fieldType];
    }

    public function getFormClassNameByType(string $formType) : string
    {
        return $this->formClasses[$formType];
    }

    public function getListClassNameByType(string $listType) : string
    {
        return $this->listClasses[$listType];
    }

    public function getColumnClassNameByType(string $fieldType) : string
    {
        return $this->columnClasses[$fieldType];
    }

    /**
     * @param BuilderInterface $builder
     * @return PageWorker|PageInterface
     */
    public function setBuilder(BuilderInterface $builder): PageInterface
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * @throws BindingResolutionException
     * @throws ClassNotFoundException
     */
    public function render(): string
    {
        $menu = $this->createObject($this->builder->getMenu());

        $content = null;
        if ($this->builder->getForm()) {
            $content = $this->createObject($this->builder->getForm());
        } elseif ($this->builder->getList()) {
            $content = $this->createObject($this->builder->getList());
        }

        return view($this->template, ['content' => $content ? $content->render() : '', 'menu' => $menu->render()]);
    }

    /**
     * @param BaseDescription|BaseDescriptionType $description
     * @throws BindingResolutionException
     * @throws ClassNotFoundException
     */
    protected function createObject($description)
    {
        $object = app()->make(
            $this->getClassObject($description),
            $description->getConstructorParameters()
        );

        foreach ($description->getOtherData() as $functionName => $value) {
            if (!method_exists($object, $functionName)) { continue; }
            if ($this->valueInstanceofDescription($value)) {
                $object->{$functionName}(...$this->prepareDescriptionValue($value));
            } else {
                if ($value === DescriptionColumn::ARGUMENT_DEFAULT) {
                    $object->{$functionName}();
                } else {
                    $object->{$functionName}(...$value);
                }
            }
        }

        return $object;
    }

    protected function valueInstanceofDescription($value): bool
    {
        return (!is_array($value) && $value instanceof BaseDescription)
            || (is_array($value) && $value[key($value)] instanceof BaseDescription);
    }

    /**
     * @param BaseDescription|BaseDescriptionType|BaseDescription[]|BaseDescriptionType[] $value
     * @throws BindingResolutionException
     * @throws ClassNotFoundException
     */
    protected function prepareDescriptionValue($value)
    {
        if (!is_array($value)) {
            return $this->createObject($value);
        }

        $items = [];
        foreach ($value as $descriptionItem) {
            $items[] = $this->createObject($descriptionItem);
        }
        return $items;
    }

    /**
     * @param BaseDescription|BaseDescriptionType $description
     * @throws ClassNotFoundException
     */
    protected function getClassObject($description): string
    {
        switch (get_class($description)) {
            case DescriptionForm::class:
                return $this->getFormClassNameByType($description->getType());
            case DescriptionField::class:
                return $this->getFieldClassNameByType($description->getType());
            case DescriptionList::class:
                return $this->getListClassNameByType($description->getType());
            case DescriptionColumn::class:
                return $this->getColumnClassNameByType($description->getType());
            case DescriptionMenu::class:
                return $this->menuClass;
            case DescriptionMenuItem::class:
                return $this->menuItemClass;
        }

        throw new ClassNotFoundException('Class for object with class "'.get_class($description).'" not found');
    }
}
