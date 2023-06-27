var mapData = [{
    type: 'scattermapbox',
    lat: [],
    lon: [],
    mode: 'markers',
    marker: {
      size: 10,
      color: 'rgb(255, 0, 0)',
      opacity: 0.7
    },
    text: []
  }];

  var layout = {
autosize: true,
hovermode: 'closest',
mapbox: {
  style: 'open-street-map', 
  bearing: 0,
  center: {
    lat: 0,
    lon: 0
  },
  pitch: 0,
  zoom: 0
},
showlegend: false
};


  Plotly.newPlot('map', mapData, layout);