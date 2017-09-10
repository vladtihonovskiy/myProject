$(document).ready(function() {
    $('#inputaddform input').bind('keyup', function() {

        if(allFilled()){ $('#register').removeAttr('disabled')}
        else{$('#register').attr("disabled", true)}

    });
    $( "#inputaddform select" ).change(function() {
        if(allFilled()){ $('#register').removeAttr('disabled')}
        else{$('#register').attr("disabled", true)}
    });

    function allFilled() {
        var filled = true;
        $('body input').each(function() {
            if(this.name=="product_type_new") {
                return;
            }
            if(this.name=="Category_new") {
                return;
            }
            if($(this).val() == '') {
                filled = false;
            }
            });
        if($("#Product_Type").val() == ''||$("#Product_Type").val()=="Product_Type"||$("#Product_Type").val() == null) {
            filled = false;
        }
        if($("#Category").val() == ''||$("#Category").val()=="Сategory"||$("#Category").val() == null) {
            filled = false;
        }
        if($("#Product_Type").val()=="Add_new_poduct"){
            $("#product_type_new").show();
            if($("#product_type_new").val()=="")
                filled = false;
        }
        if($("#Category").val()=="Add_new_category"){
            $("#Category_new").show();
            if($("#Category_new").val()=="")
                filled = false;
        }
        return filled;
    }

});
