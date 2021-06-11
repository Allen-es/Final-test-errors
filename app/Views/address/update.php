<?php
//Problem is:
//Populating the form using a foreach loop from the $formFields array
//Field Array reference: 
//["firstName","lastName","departmentName"] , $formFields[0] => "firstName"

//We also have to get the values from the $employee object to populate the fields
//during the foreach loop.
//Object reference: $employee->firstName
//$employee [ "firstName" => "Bill", "lastName" => "Jones", "dob" => "", "departmentName => ""], $employee->firstName => Bill

?>

<form name="update_address" method="POST">
<div class="w3-container">
    <div class="w3-half" style="margin: 0 auto; border: 2px solid #000;">
        <div class="w3-section"><h3>Address Information</h3></div>
        <input type="hidden" name="id" value="<?php echo $address[0]->id; ?>" />
        <?php foreach ($address[0] as $key => $value) :?>
            <?php if($key != 'id') : ?>
                <div class="w3-section">
                    <input class="w3-input" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
                    <label><?php echo ucfirst(strtolower($key)); ?></label>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="w3-section">
            <a href="/address" class="w3-btn w3-theme">Cancel</a>
            <input class="w3-btn w3-theme" type="submit" name="submit" value="Submit" />
        </div>
    </div>
</div>
</form>