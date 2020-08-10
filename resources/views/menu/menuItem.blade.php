<?php
/**
 * @var \zedsh\zadmin\Menu\BaseMenuItem $item
 */
?>
<div class="nav-link-group">
    <a class="nav-link @if($item->getIsActive()) active @endif"
       href="{{$item->getLink()}}">{{$item->getTitle()}}</a>

    @if($item->getAddLink())
        <a class="nav-link add-link" href="{{$item->getAddLink()}}">
            <i class="fas fa-plus-square"></i>
        </a>
    @endif
</div>
