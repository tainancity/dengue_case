var count;
$.getJSON(cakeRoot + 'json/count.json', {}, function(c) {
  count = c;
})

//ref https://firsemisphere.blogspot.com/2019/02/javascript-gis-proj4js.html
proj4.defs([
  [
    'EPSG:4326',
    '+title=WGS84 (long/lat) +proj=longlat +ellps=WGS84 +datum=WGS84 +units=degrees'
  ], [
    'EPSG:3826',
    '+title=TWD97 TM2 +proj=tmerc +lat_0=0 +lon_0=121 +k=0.9999 +x_0=250000 +y_0=0 +ellps=GRS80 +units=m +no_defs'
  ]
]);

//EPSG
var EPSG3826 = new proj4.Proj('EPSG:3826'); //TWD97 TM2(121分帶)
var EPSG4326 = new proj4.Proj('EPSG:4326'); //WGS84

var sidebar = new ol.control.Sidebar({ element: 'sidebar', position: 'right' });
var jsonFiles, filesLength, fileKey = 0;

var projection = ol.proj.get('EPSG:3857');
var projectionExtent = projection.getExtent();
var size = ol.extent.getWidth(projectionExtent) / 256;
var resolutions = new Array(20);
var matrixIds = new Array(20);
for (var z = 0; z < 20; ++z) {
    // generate resolutions and matrixIds arrays for this WMTS
    resolutions[z] = size / Math.pow(2, z);
    matrixIds[z] = z;
}

var appView = new ol.View({
  center: ol.proj.fromLonLat([120.221507, 23.000694]),
  zoom: 14
});

var baseLayer = new ol.layer.Tile({
    source: new ol.source.WMTS({
        matrixSet: 'EPSG:3857',
        format: 'image/png',
        url: 'http://wmts.nlsc.gov.tw/wmts',
        layer: 'EMAP',
        tileGrid: new ol.tilegrid.WMTS({
            origin: ol.extent.getTopLeft(projectionExtent),
            resolutions: resolutions,
            matrixIds: matrixIds
        }),
        style: 'default',
        wrapX: true,
        attributions: '<a href="http://maps.nlsc.gov.tw/" target="_blank">國土測繪圖資服務雲</a>'
    }),
    opacity: 0.3
});

function pointStyleFunction(f, r) {
  var color = '#ffffff';
  var p = f.getProperties();
  if(p.igm == '+' && p.igg == '+') {
    color = '#e70187';
  } else if(p.igm == '+') {
    color = '#069948';
  } else if(p.igg == '+') {
    color = '#00a2e2';
  }
  return new ol.style.Style({
    image: new ol.style.Circle({
      radius: 10,
      fill: new ol.style.Fill({
        color: color
      }),
      stroke: new ol.style.Stroke({
        color: '#fff',
        width: 2
      })
    })
  })
}

var styleHide = new ol.style.Style();

var styleBlank = new ol.style.Style({
  stroke: new ol.style.Stroke({
      color: 'rgba(37,67,140,0.5)',
      width: 1
  }),
  fill: new ol.style.Fill({
    color: 'rgba(255,255,255,0.1)'
  }),
  text: new ol.style.Text({
    font: 'bold 16px "Open Sans", "Arial Unicode MS", "sans-serif"',
    fill: new ol.style.Fill({
      color: 'blue'
    })
  })
});

var styleHigh = new ol.style.Style({
  stroke: new ol.style.Stroke({
      color: 'rgba(37,67,140,0.5)',
      width: 1
  }),
  fill: new ol.style.Fill({
    color: 'rgba(139,0,255,0.7)'
  }),
  text: new ol.style.Text({
    font: 'bold 16px "Open Sans", "Arial Unicode MS", "sans-serif"',
    fill: new ol.style.Fill({
      color: 'blue'
    })
  })
});

var styleNotice = new ol.style.Style({
  stroke: new ol.style.Stroke({
      color: 'rgba(139,0,255,0.3)',
      width: 1
  }),
  fill: new ol.style.Fill({
    color: 'rgba(184,161,207,0.4)'
  }),
  text: new ol.style.Text({
    font: 'bold 16px "Open Sans", "Arial Unicode MS", "sans-serif"',
    fill: new ol.style.Fill({
      color: 'blue'
    })
  })
});

var styleYellow = new ol.style.Style({
  stroke: new ol.style.Stroke({
      color: 'rgba(139,0,255,0.3)',
      width: 1
  }),
  fill: new ol.style.Fill({
    color: 'rgba(255,255,0,0.1)'
  }),
  text: new ol.style.Text({
    font: 'bold 16px "Open Sans", "Arial Unicode MS", "sans-serif"',
    fill: new ol.style.Fill({
      color: 'blue'
    })
  })
});

var styleCase = new ol.style.Style({
  image: new ol.style.Circle({
    radius: 10,
    fill: new ol.style.Fill({
      color: '#fff402'
    }),
    stroke: new ol.style.Stroke({
        color: '#d8041b',
        width: 3
    })
  })
});

var vectorPoints = new ol.layer.Vector({
  source: new ol.source.Vector({
    url: cakeRoot + '/points/json/issues',
    format: new ol.format.GeoJSON()
  }),
  style: pointStyleFunction
});

var vectorCase = new ol.layer.Vector({
  source: new ol.source.Vector({
    url: cakeRoot + 'points/json/cases',
    format: new ol.format.GeoJSON()
  }),
  style: styleCase
});

var areaList = {};
var getCunliStyle = function(f) {
  var p = f.getProperties();
  var code = p.VILLCODE;
  var town = p.TOWNNAME;
  var villtext = town + p.VILLNAME;
  var theStyle = styleBlank.clone();
  if(!areaList[town]) {
    areaList[town] = town;
    $('#formSelectArea').append('<option>' + town + '</option>');
  }
  if(count[code] && count[code][count.latest]) {
    if(count[code][count.latest].countPlus > 8 || count[code][count.latest].countEggs > 500) {
      theStyle = styleHigh.clone();
    } else if(count[code][count.latest].countPlus > 4 || count[code][count.latest].countEggs > 250) {
      theStyle = styleNotice.clone();
    } else if(count[code][count.latest].countPlus > 0 || count[code][count.latest].countEggs > 0) {
      theStyle = styleYellow.clone();
    }
  }
  theStyle.getText().setText(villtext);
  return theStyle;
}

var cunli = new ol.layer.Vector({
  source: new ol.source.Vector({
    url: cakeRoot + 'js/cunli.json',
    format: new ol.format.GeoJSON()
  }),
  style: getCunliStyle
});
cunli.setZIndex(-1);

var map = new ol.Map({
  layers: [baseLayer, vectorPoints, vectorCase, cunli],
  target: 'map',
  view: appView
});
map.addControl(sidebar);

var geolocation = new ol.Geolocation({
  projection: appView.getProjection()
});

geolocation.setTracking(true);

geolocation.on('error', function(error) {
  console.log(error.message);
});

var positionFeature = new ol.Feature();

positionFeature.setStyle(new ol.style.Style({
  image: new ol.style.Circle({
    radius: 6,
    fill: new ol.style.Fill({
      color: '#3399CC'
    }),
    stroke: new ol.style.Stroke({
      color: '#fff',
      width: 2
    })
  })
}));

geolocation.on('change:position', function() {
  var coordinates = geolocation.getPosition();
  positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
});

new ol.layer.Vector({
  map: map,
  source: new ol.source.Vector({
    features: [positionFeature]
  })
});

$('#btn-geolocation').click(function() {
  appView.setCenter(geolocation.getPosition());
  return false;
});

var pointColors = ['#ffffff', '#fad3d0', '#faa19e', '#fa605d', '#fa1714', '#cc1714', '#991799'];
var pointStyles = [];
for(k in pointColors) {
  pointStyles.push(new ol.style.Style({
    image: new ol.style.Circle({
      radius: 5,
      fill: new ol.style.Fill({
        color: pointColors[k]
      }),
      stroke: new ol.style.Stroke({
        color: '#fff',
        width: 1
      })
    })
  }));
}

function appendLeadingZeroes(n){
  if(n <= 9){
    return "0" + n;
  }
  return n
}

var sidebarTitle = document.getElementById('sidebarTitle');
var content = document.getElementById('sidebarContent');

map.on('singleclick', function(evt) {
  content.innerHTML = '';
  map.forEachFeatureAtPixel(evt.pixel, function (feature, layer) {
    var message = '';
    var p = feature.getProperties();
    if(p.VILLCODE) {
      message += '<h1>' + p.TOWNNAME + p.VILLNAME + '</h1>';
      if(count[p.VILLCODE]) {
        var keys = Object.keys(count[p.VILLCODE]);
        keys.sort(function(a,b) {
          return b-a;
        });
        message += '<table class="table table-dark"><thead>';
        message += '<tr><th>週次</th><th>誘卵桶卵數</th><th>陽性率</th></tr>';
        message += '</thead><tbody>';
        for(k in keys) {
          message += '<tr><th scope="row">' + keys[k] + '</th><td>' + count[p.VILLCODE][keys[k]].countEggs + '</td><td>' + Math.round((count[p.VILLCODE][keys[k]].countPlus / 12 * 100)) + '%</td></tr>';
        }
        message += '</tbody></table>';
      }
      $('#sidebarCunli').html(message);
      return false;
    } else {
      message += '<table class="table table-dark"><tbody>';
      for(k in p) {
        if(k != 'geometry') {
          message += '<tr><th scope="row">' + k + '</th><td>' + p[k] + '</td></tr>';
        }
      }
      message += '</tbody></table>';
      content.innerHTML = message;
    }
  });
  sidebar.open('home');
});

var selectedArea = 'all';
$('#formSelectArea').change(function() {
  selectedArea = $(this).val();
  var extentOfAllFeatures = ol.extent.createEmpty();
  cunli.getSource().forEachFeature(function(f) {
    if(selectedArea === 'all') {
      f.setStyle(getCunliStyle);
      ol.extent.extend(extentOfAllFeatures, f.getGeometry().getExtent());
    } else if(f.get('TOWNNAME') !== selectedArea) {
      f.setStyle(styleHide);
    } else {
      f.setStyle(getCunliStyle);
      ol.extent.extend(extentOfAllFeatures, f.getGeometry().getExtent());
    }
  });
  map.getView().fit(extentOfAllFeatures);
});
