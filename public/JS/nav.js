function search() {
    if($("#name").val()){
        window.location.href = "/Pokemon/"+$("#name").val().toLowerCase();
    }
}
$("#name").on('keyup', function (e) {
    if (e.keyCode === 13) {
        search();
    }
});
