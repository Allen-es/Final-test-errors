<div class="w3-row">&nbsp;</div>
<?php foreach($addresses as $address) : ?>
<div class="w3-container">
    <?php 
        echo (
            $address->departmentName 
            .": " . $address->id 
            ."-". $address->firstName 
            . " " . $address->lastName
            . " | "
            . "<a href='/address/update/".$address->id ."'><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>"
            . " <a href='/address/delete/".$address->id ."'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></i></a>"
        ); 
    ?>
</div>
<?php endforeach; ?>