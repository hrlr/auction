$(document).ready(function(){
    // Activate tooltip
    // $('[data-toggle="tooltip"]').tooltip();

    // Select/Deselect checkboxes
    var checkboxes = $('table tbody input[type="checkbox"]');

    $("#selectAll").click(function(){
        if(this.checked){
            checkboxes.each(function(){
                this.checked = true;
            });
        } else{
            checkboxes.each(function(){
                this.checked = false;
            });
        }
    });

    checkboxes.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });

    $("#deleteButton").click(function(){
        var ids = [];
        checkboxes.each(function(){
            if(this.checked) {
                ids.push(this.id);
            }
        });

        $("#hiddenInput").prop("value", JSON.stringify(ids));
        // $("#hiddenInput").prop("value", ids);

        $("#deleteForm").submit();

    });

});
