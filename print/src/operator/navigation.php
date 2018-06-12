<?php
function Navigation($page, $pages)
{
    $n = '';
    if ($pages > 1) {
//        $n .= '<div class="pages">';
        if ($pages <= 9) {
            $start = 1;
            $end = $pages;
        } else {
            if (($page - 4) < 1) {
                $start = 1;
                $end = 9;
            } elseif (($page + 4) > $pages) {
                $end = $pages;
                $start = $pages - 9;
            } else {
                $start = ($page - 4);
                $end = ($page + 4);
            }
        }
        for ($i = $start; $i <= $end; $i++) {
            //            $n.='<a href="orders.php'.(($i != 1) ? '?page='.$i : '').'"'.(($page == $i) ? ' class="selected"' : '').'>'.$i.'</a>'.' ';
            $n .= '<a href="orders.php' . '?page=' . $i . '"' . (($page == $i) ? ' class="selected"' : '') . '>' . $i . '</a>' . ' ';
        }
        if ($end < $pages) {
            if ($end != ($pages - 1)) $n .= '<span>...</span>';
            $n .= '<a href="orders.php?page=' . $pages . '">' . $pages . '</a>' . ' ';
        }
//        $n .= '</div>';
    }
    return $n;
}

?>