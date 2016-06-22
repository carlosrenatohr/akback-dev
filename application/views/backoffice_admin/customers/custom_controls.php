<?php
function required_control()
{
    echo "<div style=\"float:left;\">
            <span style=\"color:#F00; text-align:left; padding:4px; font-weight:bold;\">*</span>
          </div>";
}

function setControl($row)
{
    switch ($row['Control']) {
        case 'text':
            input_text('customer_' . $row['Field'], $row['Required'], $row['Label']);
            break;
        case 'number':
            input_integer('customer_' . $row['Field'], $row['Required'], $row['Label']);
            break;
        case 'number2Decimal':
            input_float('customer_' . $row['Field'], $row['Required'], $row['Label']);
            break;
        case 'radio':
            input_radio('customer_' . $row['Field'], $row['Label']);
            break;
        case 'date':
            input_date('customer_' . $row['Field']);
            break;
        case 'datalist':
            input_datalist('customer_' . $row['Field']);
            break;
        default:
            echo 'no registered';
            break;
    }
}

function input_text($name, $required = false, $label = 'type text')
{
    $req = $required ? 'required' : '';
    echo "<input type=\"text\" class=\"form-control {$req}\"
            id=\"{$name}\" name=\"{$name}\"
            placeholder=\"{$label}\" value=\"\">";
}

function input_integer($name, $required = false, $label = 'type number')
{
    $req = $required ? 'required' : '';
    echo "<input type=\"number\" class=\"form-control {$req}\"
            id=\"{$name}\" name=\"{$name}\"
            placeholder=\"{$label}\"
            step=\"1\" min=\"1\" value=\"\" pattern=\"\d*\">";
}

function input_float($name, $required = false, $label = 'type number')
{
    $req = $required ? 'required' : '';
    echo "<div style='margin-top: 3px;' class='jqxDecimalNumber {$req}' id='{$name}'></div>";
}

function input_radio($name, $label = 'radio')
{
    echo "<div style='margin-top: 10px;' id='{$name}' class='jqxRadio'>
            {$label}
          </div>";
}

function input_date($name)
{
    echo "<div class='jqxDate' id='{$name}'></div>";
}

function input_datalist($name)
{
    echo "<div class='jqxDatalist' id='{$name}'></div>";
}
