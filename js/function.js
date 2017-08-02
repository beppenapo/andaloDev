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

function setChart(){
    var viewport = viewportSize();
    var istoWidth = getCss('isto',null,'width');
    if(viewport.mq==='"xs"' || viewport.mq==='"sm"' ){
        var width = istoWidth - 30;
        document.getElementById('chart').setAttribute("height", '150');
        document.getElementById('chart').setAttribute("width", width);
    }else {
        var istoTitleWidth = getCss('istoTitle',null,'width');
        document.getElementById('chart').setAttribute("width", istoWidth-istoTitleWidth+50);
        document.getElementById('chart').setAttribute("height", '120');
    }
}



// variabili geometriche da usare nelle mappe
var map;
var mousePositionControl = new ol.control.MousePosition({
    coordinateFormat: ol.coordinate.createStringXY(4),
    projection: 'EPSG:4326',
    undefinedHTML: '&nbsp;'
});
var scaleLineControl = new ol.control.ScaleLine();
var osm = new ol.layer.Tile({
    title: 'OSM',
    type: 'base',
    visible: true,
    source: new ol.source.OSM()
});
var sat = new ol.layer.Tile({
    title: 'RealVista',
    source: new ol.source.TileWMS({
        url: 'http://213.215.135.196/reflector/open/service?',
        params: {LAYERS: 'rv1', FORMAT: 'image/jpeg', TILED: true},
        attributions: [new ol.Attribution({ html: "RealVista1.0 WMS OPEN di e-GEOS SpA - CC BY SA" })]
    }),
    visible: false
});
var baselayers = new ol.layer.Group({ title: 'Baselayers', layers: [osm,sat] });
//var overlays = new ol.layer.Group({ title: 'Overlays', layers: [] });
var zoomMap=12, center=ol.proj.transform([0, 0],'EPSG:4326', 'EPSG:3857');
var view = new ol.View({ center: center, zoom: zoomMap });

$("#zoomin").on('click', function(){ view.animate({zoom: view.getZoom() + 1, duration:500}); });
$("#zoomout").on('click', function(){view.animate({zoom: view.getZoom() - 1, duration:500}); });
$("#zoomHome").on('click', function(){ fitExtent(); });

var clusterFill = new ol.style.Fill({ color: 'rgba(255, 153, 0, 0.8)' });
var clusterStroke = new ol.style.Stroke({ color: 'rgba(255, 204, 0, 0.2)', width: 1 });
var textFill = new ol.style.Fill({ color: '#fff' });
var textStroke = new ol.style.Stroke({ color: 'rgba(0, 0, 0, 0.6)', width: 3 });
var invisibleFill = new ol.style.Fill({ color: 'rgba(255, 255, 255, 0.01)' });



/// mappe
var poi={}, layers={}, css={}, styleCache = {}, btn={};
function initindex() {
    document.removeEventListener('DOMContentLoaded', initindex);
    fitExtent();
    map = new ol.Map({
        target: 'mappa',
        view: view,
        controls: ol.control.defaults({zoom:false}).extend([scaleLineControl, mousePositionControl]),
        layers: [baselayers]
    });

    $.getJSON('connector/mappaSource.php', function (data) {
        data.features.forEach(function (feature) {
            if (!poi.hasOwnProperty(feature.properties.fonte)) { poi[feature.properties.fonte] = { "type": "FeatureCollection", "features": [] }; }
            poi[feature.properties.fonte].features.push(feature);
            css[feature.properties.fonte]=feature.properties.css;
        });
        setSwitchLayer();
    });

    $("input[name='baseLyr']").on('change', function(){
        var lyr = $("input[name='baseLyr']:checked").val();
        toggleBaseLyr(lyr);
    });

    /// geolocalizzazione //
    var geolocation = new ol.Geolocation({ projection: view.getProjection() });
    $("#geoloc").on('click', function() {
        geolocation.setTracking(false);
        geolocation.setTracking(true);
        geolocation_source.addFeature(accuracyFeature);
        geolocation_source.addFeature(positionFeature);
    });

    // update the HTML page when the position changes.
    //geolocation.on('change', function() { el('info').innerText = geolocation.getAccuracy() + ' [m]'; });

    // handle geolocation error.
    geolocation.on('error', function(error) { console.log(error); });

    var accuracyFeature = new ol.Feature();
    geolocation.on('change:accuracyGeometry', function() { accuracyFeature.setGeometry(geolocation.getAccuracyGeometry()); });

    var positionFeature = new ol.Feature();
    positionFeature.setStyle(new ol.style.Style({
        image: new ol.style.Circle({
            radius: 6,
            fill: new ol.style.Fill({ color: '#3399CC'}),
            stroke: new ol.style.Stroke({ color: '#fff', width: 2 })
        })
    }));

    geolocation.on('change:position', function() {
        var coordinates = geolocation.getPosition();
        positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
        view.animate({
            center: coordinates,
            zoom:18,
            duration: 500
        });
    });

    var geolocation_source = new ol.source.Vector({});
    var geolocation_layer = new ol.layer.Vector({ map: map, source: geolocation_source  });

}

function toggleBaseLyr(lyr){
    if(lyr=='osm'){
        sat.setVisible(false);
        osm.setVisible(true);
    }else {
        sat.setVisible(true);
        osm.setVisible(false);

    }
}

function fitExtent(){
    $.get('connector/extent.php', function(data){
        var ext = data.split(',');
        zoom2ext(ext[0],ext[1],ext[2],ext[3]);
    });
}

function zoom2ext(xmin,ymin,xmax,ymax){
    var coomin = ol.proj.fromLonLat([xmin,ymin], 'EPSG:4326');
    var coomax = ol.proj.fromLonLat([xmax,ymax], 'EPSG:4326');
    var extent=[coomin[0],coomin[1],coomax[0],coomax[1]];
    view.fit(extent,{duration:500});
}

function setSwitchLayer(){
    var btnWrap = $("#btnLayer");
    // //var group = Object.keys(poi).sort();
    var $btn,$label,$input;
    $.each(css, function(k,v){
        initLayer(k);
        $btn = $('<div/>',{class:'list-group-item checkbox'});
        $label = $('<label/>',{style:'font-size:14px;padding-left:0px;', for:k+"Check"}).text(k);
        $ico = $('<i/>',{class:'fa fa-circle', style:'color:'+v});
        $input = $('<input/>',{type:'checkbox',name:'overlay', id:k+"Check"}).val(k).prop('checked',true);
        $label.prepend($input).prepend($ico);
        $btn.append($label);
        btnWrap.append($btn);
    })

    $('#switchLayer input').on('change',function (e) {
        initLayer(e.target.value);
        $(this).prev('i').toggleClass('fa-circle-o fa-circle');
        var c = overlayLength();
        showHide(c);
    }).hide();
}
function overlayLength(){return $('[name="overlay"]:checked').length;}
function showHide(n){
    if(n===8){
        $("#switchLayer>.panel-heading>i").removeClass('fa-check-circle-o').addClass('fa-ban');
    }else {
        $("#switchLayer>.panel-heading>i").removeClass('fa-ban').addClass('fa-check-circle-o');

    }
}

function initLayer(l){
    if (!layers.hasOwnProperty(l)) {
        layers[l] = new ol.layer.Vector({
            source: new ol.source.Vector({ features: (new ol.format.GeoJSON()).readFeatures(poi[l]) }),
            style: styleFunction
        });
        map.addLayer(layers[l]);
        layers[l].set('name',l);
    }else {
        map.removeLayer(layers[l]);
        delete layers[l];
    }
}

function styleFunction(feature, resolution) {
    var hex = feature.get('css');
    var rgba = hex2rgba(hex,50);
    var stroke = hex2rgba(hex,100);
    if (!styleCache[rgba]) {
        styleCache[rgba] = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 8,
                fill: new ol.style.Fill({ color: rgba}),
                stroke: new ol.style.Stroke({ color: stroke, width: 1 })
            })
        })
    }
    return [styleCache[rgba]];
}

function hex2rgba(hex,opacity){
    hex = hex.replace('#','');
    r = parseInt(hex.substring(0,2), 16);
    g = parseInt(hex.substring(2,4), 16);
    b = parseInt(hex.substring(4,6), 16);

    result = 'rgba('+r+','+g+','+b+','+opacity/100+')';
    return result;
}
