<?php
/**
 * @category Template
 * @package JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license     GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
?>
<div class="cFilter clearfull">
<?php
    if( $sortItems )
    {
?>
    <ul class="filters cFloat-R cResetList cFloatedList">
        <!-- <li class="filter-label"><?php echo JText::_('COM_COMMUNITY_SORT_BY'); ?>:</li> -->
        <?php
        foreach( $sortItems as $key => $option )
        {
            $queries['sort'] = $key;
            $link = 'index.php?'. $uri->buildQuery($queries);
            $link = CRoute::_($link);
        ?>
        <li class="filter<?php if($key==JString::trim($selectedSort)) { ?> active<?php } ?>">
            <a href="<?php echo $link; ?>"><?php echo $option; ?></a>
        </li>
        <?php
        }
        ?>
    </ul>
<?php
        $queries['sort'] = $selectedSort;
    }
?>

<?php
    if( $filterItems )
    {
?>
    <ul class="filters cFloat-L cResetList cFloatedList">
        <!-- <li class="filter-label"><?php echo JText::_('COM_COMMUNITY_FILTER_SHOW'); ?></li> -->
    <?php
    foreach( $filterItems as $key => $option )
    {
        $queries['filter']      = $key;
        
        // We need to reset the pagination limitstart so the pagination will not affect the filter
        unset($queries['limitstart']);
        $link = 'index.php?'. $uri->buildQuery($queries);

        $link = CRoute::_($link);
    ?>
        <li class="filter<?php if($key==JString::trim($selectedFilter)) { ?> active<?php } ?>">
            <a href="<?php echo $link; ?>"><?php echo $option; ?></a>
        </li>
    <?php
    }
    ?>
    </ul>
<?php
    }
?>
</div>