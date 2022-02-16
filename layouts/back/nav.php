<?php if(isset($pageNav)) { ?>
<nav class="font-h4 navbar">
    <?php 
        foreach($pageNav as $navItem) { 
            $navItemParts = explode(':', $navItem);
            $navItemLabel = $navItemParts[0];
            if(count($navItemParts) > 1) { // si il y a un path
                $navItemPath = $navItemParts[1];
    ?>
        <a href="<?=webSitePath().$navItemPath ?>" ><?=$navItemLabel ?></a>
    <?php } else { ?>
        <span><?=$navItemLabel ?></span>
    <?php
            }
        } 
    ?>
</nav>
<?php } ?>