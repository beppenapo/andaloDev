$(document).ready(function(){
    linkActive();
    var dim = viewportSize();
    confNav(dim.w);
    $("#mainNavigation a").attr("data-tooltip","tooltip").attr("data-placement","left");
    $('[data-tooltip="tooltip"]').tooltip({ trigger : 'hover',container: 'body'});
    $("#toggleNav").on('click', function(){ toggleNav(dim.w); });
    $("#login").on('click', function(){ login(); });
    $("#logout").on('click', function(){ logout(); });
    $(".prevent").on("click", function(e){e.preventDefault();});
});

function viewportSize(){
  var mq = window.getComputedStyle(document.querySelector('body'), ':before').getPropertyValue('content');
  var w = window.innerWidth;
  var h = window.innerHeight;
  var viewportSize = new Object();
  viewportSize.mq = mq;
  viewportSize.w = w;
  viewportSize.h = h;
  return viewportSize;
}
function confNav(dim){
    var navClass = dim > 1023 ? 'aside-open':'aside-closed';
    var secClass = dim > 1023 ? 'section-def':'section-open';
    document.getElementById("mainNavigation").classList.add(navClass);
    document.getElementById("mainSection").classList.add(secClass);
}

function toggleNav(dim){
    var navClass = dim > 1023 ? 'aside-min':'aside-closed';
    var secClass = dim > 1023 ? 'section-lg':'section-open';
    $("#mainNavigation").toggleClass('aside-open '+navClass);
    $("#mainSection").toggleClass('section-open '+secClass);
    setTimeout( function() {
        map.updateSize();
        //setChart();
    }, 500);
}
function logout(){
    $.ajax({
        type: "POST",
        url: "class/logout.php",
        success: function(data){
            var alert = '<div class="alert alert-warning logOutAlert" role="alert"><label>Stai per essere disconnesso dal sistema</label></div>';
            $(alert).hide().appendTo('body').fadeIn('fast');
        }
    });
    setTimeout(function(){ window.location.href='index.php'; }, 3000);
}
function login(){
    $("#modal .modal-body").load("inc/form/login.php", function(){loginSubmit();});
    $("#modalTitle").text('Accedi alla tua bacheca di lavoro');
    $("#modal").modal();
}
function loginSubmit(){
    $("#loginSubmit").on('click', function(event){
        var isvalidate = $("form[name='loginForm']")[0].checkValidity();
        var usr = $('input[name="email"]').val();
        var pwd = $('input[name="password"]').val();
        if (isvalidate) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "class/login.php",
                data: {usr:usr, pwd:pwd},
                success: function(data){
                    $("#output").html(data);
                    if(data.includes('Ok')){ countdown(3); }
                }
            });
        }
    });
}
function countdown(counter){
    var span = document.getElementById("sec");
    setInterval(function() {
        counter--;
        if (counter >= 2) { span.innerHTML = counter+" secondi";}
        if (counter === 1) { span.innerHTML = counter+" secondo";}
        if (counter === 0) {
            clearInterval(counter);
            location.reload();
        }
    }, 1000);
}
function linkActive(){
    var link = getPageName();
    $("#"+link).addClass('active');
}
function getPageName(){
    var path = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
    var page = path.substring(0,path.lastIndexOf("."));
    return page;
}
function viewportSize(){
  var mq = window.getComputedStyle(document.querySelector('body'), ':before').getPropertyValue('content');
  var w = window.innerWidth;
  var h = window.innerHeight;
  var viewportSize = new Object();
  viewportSize.mq = mq;
  viewportSize.w = w;
  viewportSize.h = h;
  return viewportSize;
}

function elDim(el){
    var obj = document.getElementById(el);
    var w = obj.scrollWidth;
    var h = obj.innerHeight;
    var dim = new Object();
    dim.w = w;
    dim.h = h;
    return dim;
}

function getCss(el,pseudo,css){
    var obj = document.getElementById(el);
    var style = window.getComputedStyle(obj,pseudo);
    return parseInt(style.getPropertyValue(css));
}

function getTipoSk(){
    // var lista = new Object;
    var archeo = {id:6,fonte:'archeologica', argomento:'archeologia', css:'#71FF40'};
    var archit = {id:8,fonte:'architettonica', argomento:'architettura', css:'#FF0000'};
    var archiv = {id:4,fonte:'archivistica', argomento:'archivistica', css:'#FF00FF'};
    var biblio = {id:5,fonte:'bibliografica', argomento:'bibliografia', css:'#FFCA01'};
    var carto = {id:10,fonte:'cartografica', argomento:'cartografia storica', css:'#FF5C76'};
    var cultmat = {id:2,fonte:'materiale', argomento:'cultura materiale', css:'#008000'};
    var orale = {id:1,fonte:'orale', argomento:'cultura materiale', css:'#52C734'};
    var foto = {id:7,fonte:'fotografica', argomento:'fotografia', css:'#00FF00'};
    var stoart = {id:9,fonte:'storico-artistica', argomento:'storia dell&#8216;arte', css:'#0095D8'};
    return [archeo,archit,archiv,biblio,carto,cultmat,orale,foto,stoart];

}

// variabili geometriche da usare nelle mappe
var map;
var mousePositionControl = new ol.control.MousePosition({
    coordinateFormat: ol.coordinate.createStringXY(4),
    projection: 'EPSG:4326',
    undefinedHTML: '&nbsp;'
});
var baselayers = new ol.layer.Group({
    title: 'Baselayers',
    layers: [
        new ol.layer.Tile({
            title: 'OSM',
            type: 'base',
            visible: true,
            source: new ol.source.OSM()
        })
    ]
});
var view = new ol.View({
    center: ol.proj.fromLonLat([11, 46.16]),
    zoom: 12
});

function setChart(){
    var viewport = viewportSize();
    var istoWidth = getCss('isto',null,'width');
    if(viewport.mq==='"xs"' || viewport.mq==='"sm"' ){
        var width = istoWidth - 30;
        console.log(width);
        document.getElementById('chart').setAttribute("height", '150');
        document.getElementById('chart').setAttribute("width", width);
    }else {
        var istoTitleWidth = getCss('istoTitle',null,'width');
        document.getElementById('chart').setAttribute("width", istoWidth-istoTitleWidth+50);
        document.getElementById('chart').setAttribute("height", '120');
    }
}


/// mappe
function initindex() {
    map = new ol.Map({
        target: 'mappa',
        view: view,
        controls: ol.control.defaults().extend([
            new ol.control.Zoom()
            ,new ol.control.ScaleLine()
            ,mousePositionControl
        ])
        ,layers: [baselayers]
    });
}
function zoom2ext(xmin,ymin,xmax,ymax){
    var coomin = ol.proj.fromLonLat([xmin,ymin], 'EPSG:4326');
    var coomax = ol.proj.fromLonLat([xmax,ymax], 'EPSG:4326');
    var extent=[coomin[0],coomin[1],coomax[0],coomax[1]];
    view.fit(extent, map.getSize());
}
