let toggle = false;

$("#sidebar_menu li").click(function() {
    if(!$(this).hasClass('active')) {
        $("#sidebar_menu li").removeClass("active");
        $(this).addClass("active");
        $(".child_menu").slideUp(200);
        $(".child_menu", this).slideDown(200);
        $("#sidebar_menu .fa-angle-down").removeClass("fa-angle-down");
        $(".fa-angle-left", this).addClass("fa-angle-down");   
    }
    else if($(this).hasClass('active')){
        $(this).removeClass("active");
        $(".child_menu", this).slideUp(200);
        $(".fa-angle-down", this).addClass("fa-angle-left");
        $("#sidebar_menu .fa-angle-down").removeClass("fa-angle-down");
    }
    else if(toggle){
        $('.child_menu').slideUp(200);
        $('child_menu' , this).show();
    }
});

$("#sidebarToggle").click(function() {
    if ($(".page_sidebar").hasClass("toggled")) {
        toggle = false;
        $(this)
            .removeClass("fa fa-bars")
            .addClass("fa fa-times");
        $(".page_sidebar").removeClass("toggled");
        $(".page_sidebar").animate(
            {
                width: "240px"
            },
            150
        );
        $("#sidebar_menu")
            .find(".active .child_menu")
            .css("display", "block");
        $(".page_content").animate(
            {
                marginRight: "240px"
            },
            150
        );
    } else {
        toggle = true;
        $(this)
            .removeClass("fa fa-times")
            .addClass("fa fa-bars");
        $(".page_sidebar").addClass("toggled");
        $(".page_sidebar").animate(
            {
                width: "50px"
            },
            150
        );
        $(".child_menu").hide();
        $(".page_content").animate(
            {
                marginRight: "50px"
            },
            150
        );
    }
});

set_sidebar_width = function() {
    const width = document.body.offsetWidth;
    // console.log(width);
    if (width < 850) {
        $(".page_sidebar").addClass("toggled");
        $(".page_sidebar #sidebarToggle")
            .removeClass("fa fa-times")
            .addClass("fa fa-bars");
        $(".page_content").css("margin-right", "50px");
        $(".page_sidebar").css("width", "50px");
        $(".child_menu").hide();
    } else {
        if (toggle == false) {
            $(".page_sidebar").removeClass("toggled");
            $(".page_content").css("margin-right", "240px");
            $(".page_sidebar").css("width", "240px");

            $("#sidebar_menu")
                .find(".active .child_menu")
                .css("display", "block");
        }
    }
};

$(window).resize(function() {
    set_sidebar_width();
});

$(document).ready(function() {
    set_sidebar_width();

        const url = window.location.href.split("?")[0];
        $('#sidebar_menu a[href="' + url + '"]')
            .parent()
            .parent()
            .addClass("active");

        $('#sidebar_menu a[href="' + url + '"]')
            .parent()
            .parent()
            .find("a .fa-angle-left")
            .addClass("fa-angle-down");
        $('#sidebar_menu a[href="' + url + '"]')
            .parent()
            .parent()
            .find(".child_menu")
            .show();
});

selectFile = function() {
    $("#pic").click();
};

loadFile = function(event) {
    const render = new FileReader();
    render.onload = function() {
        const output = document.getElementById("output");
        output.src = render.result;
    };
    render.readAsDataURL(event.target.files[0]);
};

let delete_url;
let token;
let send_array_data = false;
let _method = 'DELETE';

del_row = function(url , t , message_text){
    _method = "DELETE";
    delete_url = url;
    token = t;
    $("#msg").text(message_text);
    $(".message_div").show();
}

delete_row = function(){
    if (send_array_data) {
        $("#data_form").submit();
    } 
    else {
        let form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", delete_url);
        const hiddenField1 = document.createElement("input");
        hiddenField1.setAttribute("name", "_method");
        hiddenField1.setAttribute("value", _method);
        form.appendChild(hiddenField1);

        const hiddenField2 = document.createElement("input");
        hiddenField2.setAttribute("name", "_token");
        hiddenField2.setAttribute("value", token);
        form.appendChild(hiddenField2);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
};

hide_box = function() {
    delete_url = "";
    token = "";
    $(".message_div").hide();
};

$('.check_box').click(function(){
    send_array_data = false;
    const checkboxes = $("table tr td input[type='checkbox']");
    const count = checkboxes.filter(':checked').length;
    if(count > 0){
        $('#remove_items').removeClass('off');
        $("#restore_items").removeClass("off");
    }
    else{
        $("#remove_items").addClass("off");
        $("#restore_items").addClass("off");
    }
});

$(".item-form").click(function(){
    send_array_data = true;
    const checkboxes = $("table tr td input[type='checkbox']");
    const count = checkboxes.filter(":checked").length;
    if (count > 0) {
        const href = window.location.href.split('?');
        let action = href[0] + '/' + this.id;
        if(href.length == 2){
            action = action + "?" + href[1];
        }
        $("#data_form").attr('action' , action);
        $("#msg").text($(this).attr("msg"));
        $(".message_div").show();
    }
});

$("span[data-toggle='tooltip']").tooltip();

restore_row = function(url, t, message_text) {
    _method = "post";
    delete_url = url;
    token = t;
    $("#msg").text(message_text);
    $(".message_div").show();
};

add_tag = function(){
    const tag_list = document.getElementById('tag_list').value;
    const t = tag_list.split('،');
    const keywords = document.getElementById('keywords').value;
    let count = document.getElementsByClassName('tag_div').length+1;
    let string = keywords;
    for(let i = 0 ; i<t.length ; i++){
        if(t[i].trim() != ''){
            const n = keywords.search(t[i]);
            if(n==-1){
                const r = "'"+t[i]+"'";
                string = string + "," + t[i];
                var tag =
                '<div class="tag_div" id="tag_div_'+count+'">'+
                    '<span class="fa fa-remove" style="margin-left:5px" onclick="remove_tag('+count+','+r+')"></span>'+t[i]+
                '</div>'
                count++;
                $('#tag_box').append(tag);
            }
        }
    }
    document.getElementById('keywords').value=string;
    document.getElementById('tag_list').value='';
}

remove_tag = function(id,text){
    $("#tag_div_"+id).hide();
    const keywords = document.getElementById("keywords").value;
    const t1 = text + ",";
    const t2 = "," + text;
    let a =keywords.replace(t1 , '');
    let b = a.replace(t2 , '');
    document.getElementById('keywords').value=b;
}

add_item_input = function(){
    const id = document.getElementsByClassName('item_input').length+1;
    const html =
        '<div class="form-group item_groups" id="item_-'+id+'">' +
        '<input type="text" class="form-control item_input" name="item[-'+id+']" placeholder="نام گروه ویژگی">' +
        ' <span class="fa fa-plus-circle" onclick="add_child_input(-'+id+')"></span>' +
        '<div class="child_item_box"></div>' +
        "</div>";
    $('#item_box').append(html);
}

add_child_input = function(id){
    const child_count = document.getElementsByClassName('child_input_item').length+1;
    const count = document.getElementsByClassName('child_'+id).length+1;
    const html = '<div class="form-group child_'+id+'">' + 
    count + ' - ' +
    '<input type="checkbox" name="check_box_item['+id+'][-'+child_count+']"><input type="text" name="child_item['+id+'][-'+child_count+']" class="form-control child_input_item" placeholder="نام ویژگی">' + 
    '</div>';
    $('#item_'+id).find('.child_item_box').append(html);
}

add_item_value_input = function(id){
    const html = '<div class="form-group">' + 
    '<label></label> ' + 
    '<input name="item_value['+id+'][]" type="text" class="form-control">' +
    '</div>';
    $('#input_item_box_'+id).append(html);
}

logout = function() {
    $("#logout_form").submit();
};