<?php
/**
 * @var \Zedsh\ZAdmin\Menu\BaseMenu $menu
 */
$items = $menu->getItems();
?>
<ul class="nav flex-column">
    @foreach($items as $item)
        <li class="nav-item">
            {!! $item->render() !!}
        </li>
    @endforeach
</ul>

