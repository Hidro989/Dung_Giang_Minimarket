<?php 
    
    function formatCurrency( $total ){
        return number_format($total, 0, '.', '.').'đ';
    };
?>