document.addEventListener('DOMContentLoaded', initindex);
$(document).ready(function(){
    setTimeout( function() {
        map.updateSize();
        //setChart();
    }, 500);
    var schedeArr = getTipoSk();
    setChart();
    var data=[], bg=[];
    var istoDiv = $(".istoDiv");
    $.each(istoDiv, function(i,el){
        var e = {value:$(el).val(), label: $(el).attr('id'), tpsch:$(el).data('id')};
        data.push(e);
        bg.push($(el).data('bg'));
    });
    //console.log(data[0].bg);
    var config = rectangularAreaChartDefaultSettings();
    config.expandFromLeft = false;
    config.expandFromTop = false;
    config.maxValue = 100;
    config.labelAlignDiagonal = true;
    config.colorsScale = d3.scale.ordinal().range(bg);
    config.textColorScale = d3.scale.ordinal().range(["#fff"]);
    config.animateDelay = 50;
    loadRectangularAreaChart("chart", data, config);

    $("rect").on('click', function(){
        var t = $(this).data('tpsch'), lista='';
        var obj = $.grep(schedeArr, function(e){ return e.id == t; });
        $(".panel-heading>div>strong").html(obj[0].argomento);
        $(".panel-heading i").css({"cursor":"pointer"}).on('click', function(){$("#lista").slideUp('fast');});
        $("#schedaFiltro").html('');
        $.ajax({
            type: "POST",
            url: "connector/tpschList.php",
            dataType:'json',
            data: {tpsch:t},
            success: function(data){
                $.each(data,function(k,v){
                    lista += "<tr>";
                    lista += "<td>"+v.dgn_dnogg+"</td>";
                    lista += "<td data-type='html'><a href='scheda.php?sk="+v.id+"' title='apri scheda' data-tooltip='tooltip'><i class='fa fa-arrow-right'></i></a></td>";
                    lista += "</tr>";
                });
                $("#tableSchede").html(lista);
                $('.foo').footable({ "filtering": { "enabled": true } });
                $("#tableSchede>thead>tr>th>form")
                    .removeClass('form-inline')
                    .detach()
                    .appendTo("#schedaFiltro")
                    .find('button.dropdown-toggle')
                    .remove();
                if(!$('#lista').is(":visible")){$("#lista").slideDown('fast');}
            }
        });
    });

    $("#lyr").on("change", function(){ $("#switchLayer").fadeToggle('fast'); });
    $("#switchLayer>.panel-heading").on('click', function(){
        var n = overlayLength();
        var input = $('[name="overlay"]');
        if(n===8){
            input.prop("checked",false).prev('i').removeClass('fa-circle').addClass('fa-circle-o');
        }else {
            input.prop("checked",true).prev('i').removeClass('fa-circle-o').addClass('fa-circle');
        }
        n = overlayLength();
        showHide(n);
        $(input).each(function(){ initLayer($(this).val()); });
    });
});
