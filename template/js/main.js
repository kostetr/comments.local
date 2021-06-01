$(document).ready(function () {
//prifile
    $("#phone").mask("+38(999)999-99-99");
    $("#birthday").mask("99-99-9999", {placeholder: "дд-мм-гггг"});

});
$("#all").change(function () {    
    $("input:checkbox.allpatterns-checkbox").prop('checked',this.checked);
});
$(".not-all-pattern-selected").change(function () {
    $("#all").prop('checked', false);
});




$("#submit-deletepatterns").on('click', function(){
    $("input:checkbox.allpatterns-checkbox").prop('form','submit-deletepatterns');
});







