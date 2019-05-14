$( document ).ready(function() {
    // $('#map-canvas').vectorMap({
    //     map: 'co_mill',
    // //     series: {
    // //         regions: [{
    // //             values: gdpData,
    // //             scale: ['#b0bec5'],
    // //             normalizeFunction: 'polynomial'
    // //         }]
    // //     },
    // //     onRegionTipShow: function(e, el, code){
    // //         el.html(el.html()+' (GDP - '+gdpData[code]+')');
    // //     },
    // // markerStyle: {
    // //   initial: {
    // //     fill: '#ec407a',
    // //     stroke: '#ec407a'
    // //   }
    // // },
    // // markers: [
    // //   {latLng: [42.5, 1.51], name: 'Andorra'},
    // //   {latLng: [47.14, 9.52], name: 'Liechtenstein'},
    // //   {latLng: [14.01, -60.98], name: 'Saint Lucia'},
    // //   {latLng: [1.3, 103.8], name: 'Singapore'}
    // // ]

    // });
    $('#map-canvas').vectorMap({
      map: 'co_mill',
      "data": [
        ["1156", "CO-AMA"],
        ["1157", "CO-ANT"],
        ["1148", "CO-ARA"],
        ["1144", "CO-ATL"],
        ["1136", "CO-BOL"],
        ["172", "CO-BOY"],
        ["1158", "CO-CAL"],
        ["1134", "CO-CAQ"],
        ["1140", "CO-CAS"],
        ["1150", "CO-CAU"],
        ["626", "CO-CES"],
        ["1145", "CO-COR"],
        ["1091", "CO-CUN"],
        ["1159", "CO-CHO"],
        ["1135", "CO-DC"],
        ["1152", "CO-GUA"],
    ["1151", "CO-GUV"],
    ["1141", "CO-HUI"],
    ["1161", "CO-LAG"],
    ["1146", "CO-MAG"],
    ["1153", "CO-MET"],
    ["1084", "CO-NAR"],
    ["1149", "CO-NSA"],
    ["1142", "CO-PUT"],
    ["1137", "CO-QUI"],
    ["1138", "CO-RIS"],
    ["1162", "CO-SAP"],
    ["1160", "CO-SAN"],
    ["1147", "CO-SUC"],
    ["1139", "CO-TOL"],
    ["1143", "CO-VAC"],
    ["1154", "CO-VAU"],
    ["1155", "CO-VID"]
  ],
  regionLabelStyle: {
      initial: {
        fill: '#B90E32'
      },
      hover: {
        fill: 'red'
      }
    },
    regionStyle: {
        initial: {
          fill: '#a4a4a4'
        },
        hover: {
            fill: "#9ccc65"
          }
      },
    zoomAnimate: true,
    markersSelectable: true,
    scaleColors: ['#C8EEFF', '#0071A4'],
    normalizeFunction: 'polynomial',
    hoverOpacity: 0.7,
    hoverColor: false,
    markerStyle: {
      initial: {
        fill: '#F8E23B',
        stroke: '#383f47'
      }
    },
    legend: {
          horizontal: true,
          title: 'Hokla'
        },
    backgroundColor: 'black',
    zoomOnScrollSpeed: true,
  markerStyle: {
      initial: {
        fill: '#008981',
        stroke: '#008981'
      }
    },
    markers: [
      {latLng: [6.2518401,-75.563591], name: 'Nodo Medellin'},
      {latLng: [6.1551499,-75.3737106], name: 'Nodo Rionegro'},
      {latLng: [3.4372201, -76.5224991], name: 'Nodo Cali'},
      {latLng: [4.6097102,-74.081749], name: 'Nodo Bogotá DC'},
      {latLng: [4.57937,-74.2168198], name: 'Nodo Cazuca (Soacha, Cundinamarca)'},
      {latLng: [4.8133302, -75.6961136], name: 'Nodo Pereira'},
      {latLng: [2.9273, -75.2818909], name: 'Nodo Neiva'},
      {latLng: [7.1253901, -73.1197968], name: 'Nodo Bucaramanga'},
      {latLng: [5.0688901, -75.5173798], name: 'Nodo Manizales'},
      {latLng: [4.14924, -74.8842926], name: 'Nodo La Granja'},
      {latLng: [1.8537101, -76.0507126], name: 'Nodo Pitalito'},
      {latLng: [10.4631395, -73.2532196], name: 'Nodo Valledupar'},
      {latLng: [8.23773, -73.356041], name: 'Nodo Ocaña'},
      {latLng: [2.891717, -75.27604199999996], name: 'Nodo Angostura'},
      {latLng: [6.468665, -73.26404100000002], name: 'Nodo Socorro'},


      // {latLng: [47.14, 9.52], name: 'Liechtenstein'},
      // {latLng: [14.01, -60.98], name: 'Saint Lucia'},
      // {latLng: [1.3, 103.8], name: 'Singapore'}
    ],
    onMarkerLabelShow: function(event, label, code) {
     label.html("<img src="+uri+"public/img/fondo1.jpg"+"><br>"+ label.html());                
    },
    legend: {
          horizontal: true,
          cssClass: 'jvectormap-legend-bg',
          title: 'Pattern',
          labelRender: function(v){
            return {
              redGreen: 'low',
              yellowBlue: 'high'
            }[v];
          }
        }
    });
    
    $('.jvectormap-zoomin').addClass('btn blue-grey');
    $('.jvectormap-zoomout').addClass('btn blue-grey');

});