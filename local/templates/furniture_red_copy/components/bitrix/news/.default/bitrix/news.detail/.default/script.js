(function (BX)
{
    BX.ready(function(){
        var temp = document.getElementById("bx-data");
        if (temp) {
            temp.onclick= function () {
                var text = document.getElementById("text-ajax");

                var url = temp.getAttribute('href');
            BX.ajax.loadJSON(url, {
               'TYPE': 'AJAX', 'ID': temp.dataset.id
                },
               function(data){
                text.innerHTML = 'Ваше мнение учтено, №' + data['ID']
            },
            function(data){
                text.innerHTML = 'Ошибка'
            }
            );
            return false;
            }
        }
    });
})(BX);

    