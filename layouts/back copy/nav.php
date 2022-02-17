<?php if(isset($pageNav)) { ?>
<nav class="font-p navbar">
    <?php 
        $keys = array_keys($pageNav);
        $last_key = end($keys);
        foreach($pageNav as $key=>$navItem) { 
            $navItemParts = explode(':', $navItem);
            $navItemLabel = $navItemParts[0];
            if(count($navItemParts) > 1) { // si il y a un path
                $navItemPath = $navItemParts[1];
    ?>
        <a href="<?= substr($navItemPath, 0,1) ==='/'?webSitePath().$navItemPath:$navItemPath ?>" ><?=$navItemLabel ?></a>
    <?php } else { ?>
        <span><?=$navItemLabel ?></span>
    <?php
            }
            if ($key !== $last_key) {
                echo ">";
            }
        } 
    ?>
</nav>
<?php } ?>