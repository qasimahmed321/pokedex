function search() {
    if($("#pokename").val()){
        window.location.href = "/Pokemon/"+$("#pokename").val().toLowerCase();
    }
}
$("#pokename").on('keyup', function (e) {
    if (e.keyCode === 13) {
        search();
    }
});
