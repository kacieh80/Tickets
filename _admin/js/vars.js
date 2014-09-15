function add_row_to_table(tbody, name, value)
{
    var row = $('<tr/>');
    var cell = $('<td/>');
    if(name == '_blank')
    {
    }
    else
    {
        cell.html('<button type="button" class="btn btn-link btn-sm" id="delete_'+name+'"><span class="glyphicon glyphicon-remove"></span></button>');
    }
    cell.appendTo(row);
    cell = $('<td/>');
    if(name == '_blank')
    {
        cell.html('<input type="text" id="name__blank" value="" placeholder="Variable Name"/>');
    }
    else
    {
        cell.html(name);
    }
    cell.appendTo(row);
    cell = $('<td/>');
    cell.html('<input type="text" id="text_'+name+'" value="'+value+'"/><button type="button" class="btn btn-link btn-sm" id="change_'+name+'"><span class="glyphicon glyphicon-ok"></span></button>');
    cell.appendTo(row);
    row.appendTo(tbody);
}

function variable_set_done(data)
{
    if(data.error != undefined)
    {
        alert(data.error);
    }
    else
    {
        $('#raw tbody').empty();
        init_vars();
    }
}

function delete_var()
{
    var button = $(this);
    var var_name = button.attr('id').substr(7);
    $.ajax({
            url: '/tickets/ajax/vars.php',
            data: 'delete='+encodeURIComponent(var_name),
            type: 'post',
            dataType: 'json',
            success: variable_set_done});
}

function change_var()
{
    var button = $(this);
    var var_name = button.attr('id').substr(7);
    var var_value = $('#text_'+var_name).val();
    if(var_name == '_blank')
    {
        var_name = $('#name__blank').val();
        if(var_name.length < 1)
        {
            alert('Variable name must be at least one character long');
            return;
        }
    }
    $.ajax({
            url: '/tickets/ajax/vars.php',
            data: 'name='+encodeURIComponent(var_name)+'&value='+encodeURIComponent(var_value),
            type: 'post',
            dataType: 'json',
            success: variable_set_done});
}

function known_change(control)
{
    var jq = $(control);
    var var_value = '';
    var var_name = '';
    if(jq.is("button"))
    {
        var_name = jq.attr("for");
        var_value = $('#'+var_name).val(); 
    }
    else
    {
        var_name = jq.attr("name");
        var_value = jq.val();
    }
    $.ajax({
            url: '/tickets/ajax/vars.php',
            data: 'name='+encodeURIComponent(var_name)+'&value='+encodeURIComponent(var_value),
            type: 'post',
            dataType: 'json',
            success: variable_set_done});
}

function populate_raw_table(vars)
{
    var tbody = $('#raw tbody');
    for(i = 0; i < vars.length; i++)
    {
        add_row_to_table(tbody, vars[i].name, vars[i].value);
    }
    //Add empty row for adding
    add_row_to_table(tbody, '_blank', '');
    $('[id^=delete_]').on('click', delete_var);
    $('[id^=change_]').on('click', change_var);
}

function populate_known_form(vars)
{
    for(i = 0; i < vars.length; i++)
    {
        var control = $('#'+vars[i].name);
        if(control.length > 0)
        {
            control.val(vars[i].value);
        }
    }
}

function variables_done(data)
{
    if(data.vars != undefined)
    {
        populate_raw_table(data.vars);
        populate_known_form(data.vars);
    }
}

function init_vars()
{
    $('#tabs a:first').tab('show');
    $.ajax({
            url: '/tickets/ajax/vars.php',
            type: 'get',
            dataType: 'json',
            success: variables_done});
}

$(init_vars)
