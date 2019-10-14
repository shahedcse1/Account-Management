<script type="text/javascript">
    $("#productGroupId").change(function() {
        var value = $("#productGroupId").val();
        if (value === "addgrup") {
            $('#addprgrpModal').modal();
        }
    });
    $("#manufactureId").change(function() {
        var value = $("#manufactureId").val();
        if (value === "addmanu") {
            $('#myModalmanu').modal();
        }
    });
    $("#unitId").change(function() {
        var value = $("#unitId").val();
        if (value === "addunit") {
            $('#addProductunit').modal();
        }
    });
</script>