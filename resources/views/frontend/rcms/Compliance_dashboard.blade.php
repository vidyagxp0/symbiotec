@extends('frontend.rcms.Regulatorylayout.main_regulatory')

@section('footer_cdn')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<!-- DataTables Buttons JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<!-- JSZip (required for Excel export) -->
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- pdfmake (required for PDF export) -->
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- Buttons HTML5 export JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<!-- Buttons print JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        var table =   $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "paging": true,
            "searching": true,
            "ordering": true
        });


        $('#fileInput').on('change', function(event) {
            try {
                var file = event.target.files[0];
                var reader = new FileReader();

                reader.onload = function(event) {
                    var data = new Uint8Array(event.target.result);
                    var workbook = XLSX.read(data, {type: 'array'});
                    var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    var jsonData = XLSX.utils.sheet_to_json(firstSheet, {header: 1});

                    // Clear the existing table data
                    table.clear();

                    // Append new data from Excel file

                    jsonData.forEach(function(row, rowIndex) {
                        // Skip the header row (index 0)
                        if (rowIndex > 0 && row.length > 0) {
                            table.row.add(row).draw();
                        }
                    });
                };

                reader.readAsArrayBuffer(file);
            } catch (err) {
                alert('oops!', err.message)
            }

            $('#fileInput').val('')
        });
    });
</script>
@endsection

<script>
    // Function to update the options of the second dropdown based on the selection in the first dropdown
    function updateQueryOptions() {
        var scopeSelect = document.getElementById('scope');
        var querySelect = document.getElementById('query');
        var scopeValue = scopeSelect.value;

        // Clear existing options in the query dropdown
        querySelect.innerHTML = '';

        // Add options based on the selected scope
        if (scopeValue === 'Regulatory Inspection') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Audit Preparation', '2'));
            querySelect.options.add(new Option('Pending Audit', '3'));
            querySelect.options.add(new Option('Pending Response', '4'));
            querySelect.options.add(new Option('CAPA Execution in Progress', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));
        } 
    }
</script>
<style>
    #short_width{
        display: inline-block;
    width: 320px !important;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
    }
    .table-container {
  overflow: auto;
  /* max-height: 350px;
  max-height: 350px; */
}

.table-header11 {
  position: sticky;
  top: 0;
  background-color: white;
  z-index: 1;
}

.table-body-new {
  margin-top: 30px;
}
.td_c{
    width: 100px !important;
}
.td_desc{
    width: 10px;
}
.main-dahsboard{
    display: flex;
    gap: 10px;
    margin-top: 10px;
}
.map1 { margin: 0; overflow: hidden; }
#chartdiv {
  width: 100%;
  height: 500px;
}
.main-head-new{
    display: flex;
    justify-content: space-between;
}
</style>
@section('rcms_container')
    <div id="rcms-dashboard">
        <div class="container-fluid">
            <div class="dash-grid">

                <div>
                    <div class="inner-block scope-table" >
                       <div class="col-lg-12 main-dahsboard">
                          <div class="col-lg-6">
                            <div class="inner-block">
                                <div class="main-head-new ">
                                    <div class="fw-bold"> Warning Letters by Fiscal Year </div>   
                           
                                <div>
                                    <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>

                                </div>
                             
                                 </div> 
                                <div>
                                <div id="chart"></div>
                                </div>
                            </div>
                          </div>

                            <div class="col-lg-6">
                                <div class="inner-block">
                                    <div class="main-head-new ">
                                        <div class="fw-bold"> Injuction and Seizures by Fiscal </div>   
                                            <div>
                                                <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            </div>
                                         </div>                                    
                                    <div>
                                        <div id="chart2"></div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                        <div class="col-lg-12 main-dahsboard">
                            <div class="col-lg-6">
                              <div class="inner-block">
                                  <div class="main-head-new ">
                                    <div class="fw-bold">  Auditor Distribution Year(2023) </div>   
                                        <div>
                                            <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                        </div>
                                     </div>
                                  <div>
                                  <div id="chart01"></div>
                                  </div>
                              </div>
                            </div>
  
                              <div class="col-lg-6">
                                  <div class="inner-block">
                                      <div class="main-head-new ">
                                        <div class="fw-bold">  21 CFR Part 211 Distribution  </div>   
                                            <div>
                                                <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            </div>
                                         </div>
                                      <div>
                                          <div id="chart02"></div>
                                      </div>
                                  </div>
                              </div>    
                          </div>


                          {{-- 
  
                              --}}

                          <div class="col-lg-12 main-dahsboard">
                            <div class="col-lg-6">
                              <div class="inner-block">
                                  <div class="main-head-new ">
                                    <div class="fw-bold">  Regulatory Audit Site </div>   
                                        <div>
                                            <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                        </div>
                                     </div>
                                  <div>
                                  <div id="chart001"></div>
                                  </div>
                              </div>
                            </div>
  
                              <div class="col-lg-6">
                                  <div class="inner-block">
                                      <div class="main-head-new ">
                                        <div class="fw-bold">   21 CFR Part 211 Site Wise Distribution</div>   
                                            <div>
                                                <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            </div>
                                         </div>
                                      <div>
                                          <div id="chart002"></div>
                                      </div>
                                  </div>
                              </div>    
                          </div>


                              <div class="col-lg-12 main-dahsboard">
                            <div class="col-lg-6">
                              <div class="inner-block">
                                  <div class="main-head-new ">
                                    <div class="fw-bold">  Regulatory CAPA Overdue Analysis </div>   
                                        <div>
                                            <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                        </div>
                                     </div>
                                  <div>
                                  <div id="chart0001"></div>
                                  </div>
                              </div>
                            </div>
  
                              <div class="col-lg-6">
                                  <div class="inner-block">
                                    
                                      <div class="main-head-new ">
                                        <div class="fw-bold"> MHRA/PICS Chapterwise Audit </div>   
                                            <div>
                                                <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            </div>
                                         </div>
                                      <div>
                                          <div id="chart0002"></div>
                                      </div>
                                  </div>
                              </div>    
                          </div>
                          <div class="col-lg-12 main-dahsboard">
                            <div class="col-lg-6">
                              <div class="inner-block">
                                 
                                  <div class="main-head-new ">
                                    <div class="fw-bold">Regulatory Observation Category Distribution  </div>   
                                        <div>
                                            <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                        </div>
                                     </div>
                                  <div>
                                  <div id="chart00001"></div>
                                  </div>
                              </div>
                            </div>
  
                              <div class="col-lg-6">
                                  <div class="inner-block">
                                      
                                      <div class="main-head-new ">
                                        <div class="fw-bold"> Department Wise Regulatory Observation  </div>   
                                            <div>
                                                <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            </div>
                                         </div>
                                      <div>
                                          <div id="chart00002"></div>
                                      </div>
                                  </div>
                              </div>    
                          </div>




                        <div class="col-lg-12 main-dahsboard">
                            <div class="col-lg-6">
                              <div class="inner-block">
                                                                   
                                  <div class="main-head-new ">
                                    <div class="fw-bold"> Inspections Classification by Product Type </div>   
                                        <div class="flex">
                                            <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            {{-- <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Print</button></a> --}}

                                        </div>
                                     </div>
                                  
                                  <div>
                                  <div id="chart3"></div>
                                  </div>
                              </div>
                            </div>
  
                              <div class="col-lg-6" style="max-height: 23rem;">
                                  <div class="inner-block">
                                     
                                      <div class="main-head-new ">
                                        <div class="fw-bold"> Foreign and Domestic Inspection  </div>   
                                            <div>
                                                <a class="btn " href="{{ url('rcms/action-items-create')}}"><button>Launch Action Item</button></a>
                                            </div>
                                         </div>
                                      <div>
                                          <div id="chart4"></div>
                                      </div>
                                  </div>
                              </div>
  
                             
                            
                          </div>


                          {{-- <div class="col-lg-12 main-dahsboard"> --}}
                            <div class="col-lg-12">
                                <div class="inner-block mt-5">
                                    <div class="main-head card" style="border: none">

                                        <div id="chartdiv" style="margin-top: 5rem;"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="inner-block mt-5">
                                    <div class="main-head card" style="border: none">

                                        <div style="margin: 20px;">
                                            {{-- <h1>Table </h1> --}}
                                            <div class="input-group">
                                                <input type="file" id="fileInput" accept=".xlsx, .xls" class="form-control"  style="margin-bottom: 2rem;"/>
                                            </div>
                                            <div style="overflow-x: scroll">
                                                <table id="example" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Observation Detail</th>
                                                            <th>Reference No.</th>
                                                            <th>Site/Location</th>
                                                            <th>Auditing Agency</th>
                                                            <th>Audit Type</th>
                                                            <th>Audit Start Date</th>
                                                            <th>Audit End Date</th>
                                                            <th>Auditor</th>
                                                            <th>Observation Category</th>
                                                            <th>Observation Type</th>
                                                            <th>Observation Area</th>
                                                            <th>Observation Area - Subcategory</th>
                                                            <th>CAPA Required?</th>
                                                            <th>CAPA Owner</th>
                                                            <th>CAPA Short Description</th>
                                                            <th>CAPA Due Date</th>
                                                            <th>CAPA Status</th>
                                                            <th>Delay Justification</th>
                                                            <th>Delay Category</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                          
                       
                </div>
            </div>
        </div>
    </div>

{{-- table script --}}




    <!-- Chart code -->
<script>
    am5.ready(function() {
    
    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chart4");
    
    const myTheme = am5.Theme.new(root);
    
    // Move minor label a bit down
    myTheme.rule("AxisLabel", ["minor"]).setAll({
      dy: 1
    });
    
    // Tweak minor grid opacity
    myTheme.rule("Grid", ["minor"]).setAll({
      strokeOpacity: 0.08
    });
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root),
      myTheme
    ]);
    
    
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: false,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      paddingLeft: 0
    }));
    
    
    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
      behavior: "zoomX"
    }));
    cursor.lineY.set("visible", false);
    
    var date = new Date();
    date.setHours(0, 0, 0, 0);
    var value = 100;
    
    function generateData() {
      value = Math.round((Math.random() * 10 - 5) + value);
      am5.time.add(date, "day", 1);
      return {
        date: date.getTime(),
        value: value
      };
    }
    
    function generateDatas(count) {
      var data = [];
      for (var i = 0; i < count; ++i) {
        data.push(generateData());
      }
      return data;
    }
    
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
      maxDeviation: 0,
      baseInterval: {
        timeUnit: "day",
        count: 1
      },
      renderer: am5xy.AxisRendererX.new(root, {
        minorGridEnabled: true,
        minGridDistance: 200,    
        minorLabelsEnabled: true
      }),
      tooltip: am5.Tooltip.new(root, {})
    }));
    
    xAxis.set("minorDateFormats", {
      day: "dd",
      month: "MM"
    });
    
    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      renderer: am5xy.AxisRendererY.new(root, {})
    }));
    
    
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.LineSeries.new(root, {
      name: "Series",
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: "value",
      valueXField: "date",
      tooltip: am5.Tooltip.new(root, {
        labelText: "{valueY}"
      })
    }));
    
    // Actual bullet
    series.bullets.push(function () {
      var bulletCircle = am5.Circle.new(root, {
        radius: 5,
        fill: series.get("fill")
      });
      return am5.Bullet.new(root, {
        sprite: bulletCircle
      })
    })
    
    // Add scrollbar
    // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
    chart.set("scrollbarX", am5.Scrollbar.new(root, {
      orientation: "horizontal"
    }));
    
    var data = generateDatas(30);
    series.data.setAll(data);
    
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);
    
    }); // end am5.ready()
    </script>
    

    <!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create the map chart
// https://www.amcharts.com/docs/v5/charts/map-chart/
var chart = root.container.children.push(
  am5map.MapChart.new(root, {
    panX: "translateX",
    panY: "translateY",
    projection: am5map.geoMercator()
  })
);

var colorSet = am5.ColorSet.new(root, {});

// Create main polygon series for time zone areas
// https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
var areaSeries = chart.series.push(
  am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldTimeZoneAreasLow
  })
);

var areaPolygonTemplate = areaSeries.mapPolygons.template;
areaPolygonTemplate.setAll({ fillOpacity: 0.6 });
areaPolygonTemplate.adapters.add("fill", function (fill, target) {
  return am5.Color.saturate(
    colorSet.getIndex(areaSeries.mapPolygons.indexOf(target)),
    0.5
  );
});

areaPolygonTemplate.states.create("hover", { fillOpacity: 0.8 });

// Create main polygon series for time zones
// https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
var zoneSeries = chart.series.push(
  am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldTimeZonesLow
  })
);

zoneSeries.mapPolygons.template.setAll({
  fill: am5.color(0x000000),
  fillOpacity: 0.08
});

var zonePolygonTemplate = zoneSeries.mapPolygons.template;
zonePolygonTemplate.setAll({ interactive: true, tooltipText: "{id}" });
zonePolygonTemplate.states.create("hover", { fillOpacity: 0.3 });

// labels
var labelSeries = chart.series.push(am5map.MapPointSeries.new(root, {}));
labelSeries.bullets.push(() => {
  return am5.Bullet.new(root, {
    sprite: am5.Label.new(root, {
      text: "{id}",
      populateText: true,
      centerX: am5.p50,
      centerY: am5.p50,
      fontSize: "0.7em"
    })
  });
});

// create labels for each zone
zoneSeries.events.on("datavalidated", () => {
  am5.array.each(zoneSeries.dataItems, (dataItem) => {
    var centroid = dataItem.get("mapPolygon").visualCentroid();
    labelSeries.pushDataItem({
      id: dataItem.get("id"),
      geometry: {
        type: "Point",
        coordinates: [centroid.longitude, centroid.latitude]
      }
    });
  });
});

// Add zoom control
// https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
var zoomControl = chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
zoomControl.homeButton.set("visible", true);

// Add labels and controls
var cont = chart.children.push(
  am5.Container.new(root, {
    layout: root.horizontalLayout,
    x: 20,
    y: 40
  })
);

cont.children.push(
  am5.Label.new(root, {
    centerY: am5.p50,
    text: "Map"
  })
);

var switchButton = cont.children.push(
  am5.Button.new(root, {
    themeTags: ["switch"],
    centerY: am5.p50,
    icon: am5.Circle.new(root, {
      themeTags: ["icon"]
    })
  })
);

switchButton.on("active", function () {
  if (!switchButton.get("active")) {
    chart.set("projection", am5map.geoMercator());
    chart.set("panX", "translateX");
    chart.set("panY", "translateY");
  } else {
    chart.set("projection", am5map.geoOrthographic());
    chart.set("panX", "rotateX");
    chart.set("panY", "rotateY");
  }
});

cont.children.push(
  am5.Label.new(root, {
    centerY: am5.p50,
    text: "Globe"
  })
);
// Make stuff animate on load
chart.appear(1000, 100);

}); // end am5.ready()
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'NAI',
                    data: [44, 55, 41, 67, 22, 43]
                }, {
                    name: 'VAI',
                    data: [13, 23, 20, 8, 13, 27]
                },  {
                    name: 'OAI',
                    data: [21, 7, 25, 13, 22, 8]
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                colors: ['#F38100', '#F7B103', '#022E45'], // Colors: Pink, Yellow, Blue, Green
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        borderRadiusApplication: 'end', // 'around', 'end'
                        borderRadiusWhenStacked: 'last', // 'all', 'last'
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    }
                },
                xaxis: {
                    type: 'data',
                    categories: ['Biologics', 'Devices', 'Drugs', 'Food/Cosmetics',
                        'Tobacco', 'Veterinary'
                    ]
                },
                legend: {
                    position: 'right',
                    offsetY: 40
                },
                fill: {
                    opacity: 1
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart3"), options);
            chart.render();
        });
    </script>
   


   <script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    horizontal: true
                }
            },
            colors: ['#FFA500'],
            series: [{
                data: [{
                    x: '2020',
                    y: 18
                }, {
                    x: '2021',
                    y: 1
                }, {
                    x: '2022',
                    y: 10
                }, {
                    x: '2023',
                    y: 4
                }, {
                    x: '2024',
                    y: 8
                }]
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>

  <script>
    var colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#546E7A', '#26A69A', '#D10CE8'];

    var options = {
      series: [{
        data: [11, 2, 10, 8, 6, 1, 13, 3]
      }],
      chart: {
        height: 310,
        type: 'bar',
        events: {
          click: function(chart, w, e) {
            // console.log(chart, w, e)
          }
        }
      },
      colors: colors,
      plotOptions: {
        bar: {
          columnWidth: '45%',
          distributed: true,
        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: false
      },
      xaxis: {
        categories: [
          ['John', 'Doe'],
          ['Joe', 'Smith'],
          ['Jake', 'Williams'],
          'Amber',
          ['Peter', 'Brown'],
          ['Mary', 'Evans'],
          ['David', 'Wilson'],
          ['Lily', 'Roberts'], 
        ],
        labels: {
          style: {
            colors: colors,
            fontSize: '12px'
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart01"), options);
    chart.render();
  </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                type: 'bar'
            },
            colors: ['#FFA500'],
            series: [{
                data: [{
                    x: 'category A',
                    y: 10
                }, {
                    x: 'category B',
                    y: 18
                }, {
                    x: 'category C',
                    y: 3
                }
                , {
                    x: 'category D',
                    y: 12
                },{
                    x: 'category E',
                    y: 4
                }]
            }]
        };
        var chart = new ApexCharts(document.querySelector("#cha88989rt2"), options);
        chart.render();
    });
</script>


{{-- chart02 --}}


<script>
    try {
        var options = {
            colors: ['#571746'],
        series: [
        {
            data: [20, 15, 10, 6]
        }],
        chart: {
            type: 'bar',
            // height: 430
        },
        plotOptions: {
            bar: {
                vertical: true,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            offsetX: -2,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        xaxis: {
            categories: ['211.22', '211.45', '211.25', '211.48'],
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart02"), options);
    chart.render();
    } catch (err) {
        console.log('error rendering g', err.message)
    }
</script>


<script>
    try {
        var options = {
            colors: ['#7CBEB1'],
        series: [
        {
            data: [20, 15, 10, 6,11,13]
        }],
        chart: {
            type: 'bar',
            height: 283
        },
        plotOptions: {
            bar: {
                horizontal: true,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            offsetX: -2,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        xaxis: {
            categories: ['MHRA', 'ANVISA', 'USFDA', 'MCC','EU','PICS'],
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart001"), options);
    chart.render();
    } catch (err) {
        console.log('error rendering g', err.message)
    }
</script>

<script>
    var options = {
      series: [{
        name: 'Inflation',
        data: [2.3, 3.1, 4.0, 10.1, 0.5, 0.2]
      }],
      chart: {
        height: 350,
        type: 'bar',
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
            position: 'top', // top, center, bottom
          },
        }
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val + "%";
        },
        offsetY: -20,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      },
      xaxis: {
        categories: [">1Month", ">2Month", ">3Month", ">4Month", ">6Month", "1Year"],
        position: 'top',
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        crosshairs: {
          fill: {
            type: 'gradient',
            gradient: {
              colorFrom: '#D8E3F0',
              colorTo: '#BED1E6',
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5,
            }
          }
        },
        tooltip: {
          enabled: true,
        }
      },
      yaxis: {
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: false,
          formatter: function (val) {
            return val + "%";
          }
        }
      },
      title: {
        text: 'Month Wise Distribution',
        floating: true,
        offsetY: 330,
        align: 'center',
        style: {
          color: '#444'
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart0001"), options);
    chart.render();
  </script>


<script>
    var options = {
      series: [{
        data: [40, 30, 28, 30, 40, 10, 60]
      }],
      chart: {
        type: 'bar',
        height: 350,
      },
      annotations: {
        xaxis: [{
          x: 500,
          borderColor: '#00E396',
          label: {
            borderColor: '#00E396',
            style: {
              color: '#fff',
              background: '#E14C61',
            },
            text: 'X annotation',
          }
        }],
        yaxis: [{
          y: 'July',
          y2: 'September',
          label: {
            text: 'Y annotation'
          }
        }]
      },
      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      dataLabels: {
        enabled: true
      },
      xaxis: {
        categories: ['Chapter 1', 'Chapter 2', 'Chapter 3', 'Chapter 4', 'Chapter 5'],
      },
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      yaxis: {
        reversed: true,
        axisTicks: {
          show: true
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart0002"), options);
    chart.render();
  </script>
  <script>
    var options = {
      series: [44, 55, 13],
      chart: {
        width: 380,
        type: 'pie',
      },
      labels: ['Critical', 'Major', 'Minor'],
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#chart00001"), options);
    chart.render();
  </script>
    <script>
        var options = {
          series: [{
            data: [40, 30, 22, 47, 20, 45,]
          }],
          chart: {
            type: 'bar',
            height: 240
          },
          plotOptions: {
            bar: {
              barHeight: '100%',
              distributed: true,
              horizontal: true,
              dataLabels: {
                position: 'bottom'
              },
            }
          },
          colors: ['#33b2df', '#69d2e7', '#d4526e', '#f48024', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
            '#f48024', '#69d2e7'
          ],
          dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
              colors: ['#fff']
            },
            formatter: function (val, opt) {
              return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
            },
            offsetX: 0,
            dropShadow: {
              enabled: true
            }
          },
          stroke: {
            width: 1,
            colors: ['#fff']
          },
          xaxis: {
            categories: ['QC Chemical', 'QA', 'Micro', 'RA', 'WareHouse', 'MH' ],
          },
          yaxis: {
            labels: {
              show: false
            }
          },
          title: {
            text: '',//title23
            align: 'center',
            floating: true
          },
          subtitle: {
            // text: 'Category Names as DataLabels inside bars',
            align: 'center',
          },
          tooltip: {
            theme: 'dark',
            x: {
              show: false
            },
            y: {
              title: {
                formatter: function () {
                  return ''
                }
              }
            }
          }
        };
    
        var chart = new ApexCharts(document.querySelector("#chart00002"), options);
        chart.render();
      </script>



{{-- 
<script>
    try {
        var options = {
            colors: ['#571746'],
        series: [
        {
            data: [20, 15, 10, 6]
        }],
        chart: {
            type: 'bar',
            // height: 430
        },
        plotOptions: {
            bar: {
                vertical: true,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            offsetX: -2,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        xaxis: {
            categories: ['211.22', '211.45', '211.25', '211.48'],
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart002"), options);
    chart.render();
    } catch (err) {
        console.log('error rendering g', err.message)
    }
</script>

 --}}

<script>
    var options = {
        series: [211, 211, 98, 66],
        chart: {
            type: 'donut',
            height: 500

        },
        plotOptions: {
            pie: {
                startAngle: -90,
                endAngle: 90,
                offsetY: 10
            }
        },
        grid: {
            padding: {
                bottom: -80
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart002"), options);
    chart.render();
</script>

<script>
    try {
        var options = {
        
        series: [{
            data: [44, 55, 41, 64, 22]
        },
        {
            data: [4, 5, 1, 64, 22]
        },],
        chart: {
            type: 'bar',
            // height: 430
        },
        plotOptions: {
            bar: {
                vertical: true,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            offsetX: -2,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        xaxis: {
            categories: [2019,2020,2021,2022,2023],
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
    } catch (err) {
        console.log('error rendering g', err.message)
    }
</script>

<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  paddingLeft:0,
  layout: root.verticalLayout
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}))


// Data
var data = [{
  year: "2017",
  income: 23.5,
  expenses: 18.1
}, {
  year: "2018",
  income: 26.2,
  expenses: 22.8
}, {
  year: "2019",
  income: 30.1,
  expenses: 23.9
}, {
  year: "2020",
  income: 29.5,
  expenses: 25.1
}, {
  year: "2021",
  income: 24.6,
  expenses: 25
}];


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "year",
  renderer: am5xy.AxisRendererY.new(root, {
    inversed: true,
    cellStartLocation: 0.1,
    cellEndLocation: 0.9,
    minorGridEnabled: true
  })
}));

yAxis.data.setAll(data);

var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererX.new(root, {
    strokeOpacity: 0.1,
    minGridDistance: 50
  }),
  min: 0
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function createSeries(field, name) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueXField: field,
    categoryYField: "year",
    sequencedInterpolation: true,
    tooltip: am5.Tooltip.new(root, {
      pointerOrientation: "horizontal",
      labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
    })
  }));

  series.columns.template.setAll({
    height: am5.p100,
    strokeOpacity: 0
  });


  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      locationX: 1,
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        centerY: am5.p50,
        text: "{valueX}",
        populateText: true
      })
    });
  });

  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      locationX: 1,
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        centerX: am5.p100,
        centerY: am5.p50,
        text: "{name}",
        fill: am5.color(0xffffff),
        populateText: true
      })
    });
  });

  series.data.setAll(data);
  series.appear();

  return series;
}

createSeries("income", "Income");
createSeries("expenses", "Expenses");


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));

legend.data.setAll(chart.series.values);


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
  behavior: "zoomY"
}));
cursor.lineY.set("forceHidden", true);
cursor.lineX.set("forceHidden", true);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

}); // end am5.ready()
</script>



    <div class="modal fade modal-sm" id="record-modal">
        <div class="modal-contain">
            <div class="modal-dialog m-0">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body " id="auditTableinfo">
                        Please wait...
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function showChild() {
            $(".child-row").toggle();
        }

        $(".view-list").hide();

        function toggleview() {
            $(".view-list").toggle();
        }

        $("#record-modal .drop-list").hide();

        function showAction() {
            $("#record-modal .drop-list").toggle();
        }
    </script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#auditTable').on('click', '.viewdetails', function() {
                var auditid = $(this).attr('data-id');
                var formType = $(this).attr('data-type');
                if (auditid > 0) {
                    // AJAX request
                    var url = "{{ route('ccView', ['id' => ':auditid', 'type' => ':formType']) }}";
                    url = url.replace(':auditid', auditid).replace(':formType', formType);

                    // Empty modal data
                    $('#auditTableinfo').empty();
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        success: function(response) {
                            // Add employee details
                            $('#auditTableinfo').append(response.html);
                            // Display Modal
                            $('#record-modal').modal('show');
                        }
                    });
                }
            });
        });
    </script>
@endsection
