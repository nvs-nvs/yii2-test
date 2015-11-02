var cnt=3;
var $inputGroupe = $('#digitalInput');
$('#add').on('click', function () {
    cnt ++;
    if(cnt==10) {
        $('#add').css({
            'display': 'none'
        });
    }
        $inputGroupe.append('<input type="number" name = "input'
            +cnt
            + '"class="form-control" placeholder="Число от -1000 до 1000">');
});