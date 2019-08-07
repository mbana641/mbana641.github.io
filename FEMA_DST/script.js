var result = 0;
var svi_total = 0;
var pop_total = 0;
var svi = 0;
var count = 0;
var liters = 0;
var meals = 0;
var seek = 0;
var water = 0;
var food = 0;
var exportData = [];
require([
    "esri/Graphic",
    "esri/Map",
    "esri/views/MapView",
    "esri/views/draw/Draw",
    "esri/widgets/Expand",
    "esri/request",
    "esri/layers/support/Field",
    "esri/layers/FeatureLayer",
    "esri/layers/GraphicsLayer",
    "esri/widgets/Expand",
    "esri/tasks/RouteTask",
    "esri/tasks/support/RouteParameters",
    "esri/tasks/support/FeatureSet",
    "esri/widgets/Print",
    "esri/widgets/BasemapGallery",
    "esri/layers/MapImageLayer"
], function (Graphic, Map, MapView, Draw, Expand, request, Field, FeatureLayer, GraphicsLayer, Expand, RouteTask, RouteParameters, FeatureSet, Print, BasemapGallery, MapImageLayer) {
    // Create layers
    var portalUrl = "https://www.arcgis.com";
    const buffer = new GraphicsLayer();
    var graphicsLayer = new GraphicsLayer();
    var routeTask = new RouteTask({
        url: "https://utility.arcgis.com/usrsvcs/appservices/xpCBzJdj2bGmS7QB/rest/services/World/Route/NAServer/Route_World"
    });
    var routeLayer = new GraphicsLayer();
    const featureLayer = new FeatureLayer({
        url: "https://services3.arcgis.com/ZvidGQkLaDJxRSJ2/arcgis/rest/services/Overall_2014_Tracts/FeatureServer",
        visible: false
    });
    const active = new FeatureLayer({
        url: "https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/Active_Hurricanes_v1/FeatureServer/0"
    });
    const active2 = new FeatureLayer({
        url: "https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/Active_Hurricanes_v1/FeatureServer/1"
    });
    const active3 = new FeatureLayer({
        url: "https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/Active_Hurricanes_v1/FeatureServer/2"
    });
    const active4 = new FeatureLayer({
        url: "https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/Active_Hurricanes_v1/FeatureServer/3"
    });
    const active5 = new FeatureLayer({
        url: "https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/Active_Hurricanes_v1/FeatureServer/4"
    });
    var popup = {
        'title': '{NAME}',
        'content': '<b>Available Water:</b> {Water} liters<br><b>Available Food:</b> {Food} meals'
    };
    var centers = new FeatureLayer({
        url: 'https://services.arcgis.com/hRUr1F8lE8Jq2uJo/arcgis/rest/services/Distribution_Centers/FeatureServer/0',
        popupTemplate: popup
    });
    var weatherRadar = new MapImageLayer({
        url: "https://nowcoast.noaa.gov/arcgis/rest/services/nowcoast/radar_meteo_imagery_nexrad_time/MapServer/",
        opacity: 0.5
    });
    document
        .getElementById("uploadForm")
        .addEventListener("change", function (event) {
            var fileName = event.target.value.toLowerCase();
            if (fileName.indexOf(".zip") !== -1) {
                //is file a zip - if not notify user
                generateFeatureCollection(fileName);
            }
            else {
                document.getElementById("upload-status").innerHTML =
                    '<p style="color:red">Add shapefile as .zip file</p>';
            }
        });
    // Create map
    const map = new Map({
        basemap: "hybrid",
        layers: [featureLayer, active5, active3, active4, active, active2, weatherRadar, buffer, centers, routeLayer]
    });
    // Create view
    const view = new MapView({
        container: "viewDiv",
        map: map,
        zoom: 5,
        center: [-97.383, 34.4069]
    });
    var fileForm = document.getElementById("mainWindow");
    var expand = new Expand({
        expandIconClass: "esri-icon-upload",
        view: view,
        content: fileForm
    });
    var print = new Expand({
        id: "Print",
        view: view,
        // specify your own print service
        content: new Print({
            view: view,
            printServiceUrl: "https://utility.arcgisonline.com/arcgis/rest/services/Utilities/PrintingTools/GPServer/Export%20Web%20Map%20Task"
        })
    });
    var basemap = new Expand({
        id: "Change Basemaps",
        expandIconClass: "esri-icon-basemap",
        view: view,
        content: new BasemapGallery({
            view: view,
            source: {
                portal: {
                    url: "https://www.arcgis.com",
                    useVectorBasemaps: true
                }
            }
        })
    });
    view.ui.add(basemap, "top-left");
    view.ui.add(expand, "top-right");
    function generateFeatureCollection(fileName) {
        var name = fileName.split(".");
        // Chrome and IE add c:\fakepath to the value - we need to remove it
        // see this link for more info: http://davidwalsh.name/fakepath
        name = name[0].replace("c:\\fakepath\\", "");
        document.getElementById("upload-status").innerHTML =
            "<b>Loading </b>" + name;
        // define the input params for generate see the rest doc for details
        // https://developers.arcgis.com/rest/users-groups-and-items/generate.htm
        var params = {
            name: name,
            targetSR: view.spatialReference,
            maxRecordCount: 1000,
            enforceInputFileSizeLimit: true,
            enforceOutputJsonSizeLimit: true
        };
        // generalize features to 10 meters for better performance
        params.generalize = true;
        params.maxAllowableOffset = 10;
        params.reducePrecision = true;
        params.numberOfDigitsAfterDecimal = 0;
        var myContent = {
            filetype: "shapefile",
            publishParameters: JSON.stringify(params),
            f: "json"
        };
        // use the REST generate operation to generate a feature collection from the zipped shapefile
        request(portalUrl + "/sharing/rest/content/features/generate", {
            query: myContent,
            body: document.getElementById("uploadForm"),
            responseType: "json"
        })
            .then(function (response) {
                var layerName = response.data.featureCollection.layers[0].layerDefinition.name;
                document.getElementById("upload-status").innerHTML =
                    "<b>Loaded: </b>" + layerName;
                addShapefileToMap(response.data.featureCollection);
            })
            .catch(errorHandler);
    }
    function errorHandler(error) {
        document.getElementById("upload-status").innerHTML =
            "<p style='color:red;max-width: 500px;'>" + error.message + "</p>";
    }
    function addShapefileToMap(featureCollection) {
        // add the shapefile to the map and zoom to the feature collection extent
        // if you want to persist the feature collection when you reload browser, you could store the
        // collection in local storage by serializing the layer using featureLayer.toJson()
        // see the 'Feature Collection in Local Storage' sample for an example of how to work with local storage
        var sourceGraphics = [];
        var layers = featureCollection.layers.map(function (layer) {
            var graphics = layer.featureSet.features.map(function (feature) {
                return Graphic.fromJSON(feature);
            });
            sourceGraphics = sourceGraphics.concat(graphics);
            var featureLayer = new FeatureLayer({
                objectIdField: "FID",
                source: graphics,
                fields: layer.layerDefinition.fields.map(function (field) {
                    return Field.fromJSON(field);
                })
            });
            return featureLayer;
            // associate the feature with the popup on click to enable highlight and zoom to
        });
        map.addMany(layers);
        view.goTo(sourceGraphics);
        document.getElementById("upload-status").innerHTML = "";
    }
    //// add the button for the draw tool
    view.ui.add("line-button", "top-right");
    const draw = new Draw({
        view: view
    });
    // draw polyline button
    document.getElementById("line-button").onclick = function () {
        view.graphics.removeAll();
        document.body.style.cursor = "crosshair";
        // creates and returns an instance of PolyLineDrawAction
        const action = draw.create("polygon");
        action.on("vertex-add", function (evt) {
            createPolygonGraphic(evt.vertices);
        });
        // PolygonDrawAction.vertex-remove
        // Fires when the "Z" key is pressed to undo the last added vertex
        action.on("vertex-remove", function (evt) {
            createPolygonGraphic(evt.vertices);
        });
        // Fires when the pointer moves over the view
        action.on("cursor-update", function (evt) {
            createPolygonGraphic(evt.vertices);
        });
        // Add a graphic representing the completed polygon
        // when user double-clicks on the view or presses the "C" key
        action.on("draw-complete", function (evt) {
            var graphic = createPolygonGraphic(evt.vertices);
            sleep(2);
            var category = prompt("What is the category of damage?", "1, 2, 3, 4, or 5");
            category = parseInt(category);
            route(graphic.geometry, category);
        });
    };
    // Checks if the last vertex is making the line intersect itself.
    function updateVertices(event) {
        // create a polyline from returned vertices
        if (event.vertices.length > 1) {
            const result = createGraphic(event);
            // if the last vertex is making the line intersects itself,
            // prevent the events from firing
            if (result.selfIntersects) {
                event.preventDefault();
            }
        }
    }
    function createPolygonGraphic(vertices) {
        view.graphics.removeAll();
        var polygon = {
            type: "polygon",
            rings: vertices,
            spatialReference: view.spatialReference
        };
        var graphic = new Graphic({
            geometry: polygon,
            symbol: {
                type: "simple-fill",
                color: "rgba(228,228,228,0.4)",
                style: "solid",
                outline: {
                    color: "rgba(228, 228, 228, 0.8)",
                    width: 2,
                }
            }
        });
        view.graphics.add(graphic);
        return graphic;
    }
    // Add widget to the top right corner of the view
    view.ui.add(print, "top-right");
    view.ui.add("csvDiv", "top-right");
    view.ui.add("layerToggle", "top-left");
    var args = '{ filename: "export-data.csv" }';
    function convertArrayOfObjectsToCSV(args) {
        var result, ctr, keys, columnDelimiter, lineDelimiter, data;
        data = args.data || null;
        if (data == null || !data.length) {
            return null;
        }
        columnDelimiter = args.columnDelimiter || ',';
        lineDelimiter = args.lineDelimiter || '\n';
        keys = Object.keys(data[0]);
        result = '';
        result += keys.join(columnDelimiter);
        result += lineDelimiter;
        data.forEach(function (item) {
            ctr = 0;
            keys.forEach(function (key) {
                if (ctr > 0)
                    result += columnDelimiter;
                result += item[key];
                ctr++;
            });
            result += lineDelimiter;
        });
        return result;
    }
    document.getElementById("layerToggle").onclick = function toggle() {
        if (weatherRadar.visible == true) {
            weatherRadar.visible = false;
        }
        else if (weatherRadar.visible == false) {
            weatherRadar.visible = true;
        }
    };
    document.getElementById("csvDiv").onclick = function downloadCSV(args) {
        var data, filename, link;
        var csv = convertArrayOfObjectsToCSV({
            data: exportData
        });
        if (csv == null)
            return;
        filename = args.filename || 'export.csv';
        if (!csv.match(/^data:text\/csv/i)) {
            csv = 'data:text/csv;charset=utf-8,' + csv;
        }
        data = encodeURI(csv);
        link = document.createElement('a');
        link.setAttribute('href', data);
        link.setAttribute('download', filename);
        link.click();
    };
    function calculation(buffer, category) {
        const query = featureLayer.createQuery();
        query.geometry = buffer;
        query.outFields = ["E_TOTPOP", "RPL_THEMES"];
        return featureLayer
            .queryFeatures(query)
            .then(function (results) {
                result = results.features;
                for (var i = 0; i < result.length; i++) {
                    if (result[i].attributes.E_TOTPOP >= 0) {
                        pop_total += result[i].attributes.E_TOTPOP;
                    }
                    if (result[i].attributes.RPL_THEMES >= 0) {
                        svi_total += result[i].attributes.RPL_THEMES;
                        count += 1;
                    }
                }
                var categoryValue = 0;
                if (category == 1) {
                    categoryValue = 0.15;
                }
                else if (category == 2) {
                    categoryValue = 0.3;
                }
                else if (category == 3) {
                    categoryValue = 0.6;
                }
                else if (category == 4) {
                    categoryValue = 0.8;
                }
                else if (category == 5) {
                    categoryValue = 1;
                }
                var svi = svi_total / count;
                var vul_pop = Math.round(pop_total * categoryValue);
                var vul_pop = Math.round(vul_pop * svi);
                seek = Math.round(0.38 * vul_pop);
                liters = Math.round(seek * 9);
                meals = Math.round(seek * 6);
                water = Math.round(liters * 0.97);
                food = Math.round(meals * 4.77);
                function formatNumber(num) {
                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                }
                svi = formatNumber(svi);
                vul_pop = formatNumber(vul_pop);
                var seekf = formatNumber(seek);
                var litersf = formatNumber(liters);
                var mealsf = formatNumber(meals);
                var waterf = formatNumber(water);
                var foodf = formatNumber(food);
                html = "<div class='floating-box'><div class='resources'><div id='box'><strong><span>Number of people in need:</span></strong><br></br><span id='pop'></span></div><br></br><div id='box'><strong><span>Liters of water needed:</span></strong><br></br><span id='water'></span></div><br></br><div id='box'><strong><span>Number of meals needed:</span></strong><br></br><span id='meals'></span></div><br></br><div id='box'><strong><span>Cost of water:</span></strong><br></br>$<span id='costw'></span></div><br></br><div id='box'><strong><span>Cost of meals:</span></strong><br></br>$<span id='costm'></span></div><br></br><div id='box'><strong><span>Number of miles on route:</span></strong><br></br><span id='miles'></div></div></div>";
                document.getElementById('html').innerHTML = html;
                document.getElementById('pop').innerHTML = seekf;
                document.getElementById('water').innerHTML = litersf;
                document.getElementById('meals').innerHTML = mealsf;
                document.getElementById('costw').innerHTML = waterf;
                document.getElementById('costm').innerHTML = foodf;
                document.getElementById('miles').innerHTML = "Loading...";
            });
    }
    function sleep(seconds) {
        var waitUntil = new Date().getTime() + seconds * 1000;
        while (new Date().getTime() < waitUntil)
            true;
    }
    function route(buffer, category) {
        calculation(buffer, category);
        document.body.style.cursor = "wait";
        sleep(5);
        var centroidx = buffer.centroid.latitude;
        var centroidy = buffer.centroid.longitude;
        var point = {
            type: "point",
            longitude: centroidy,
            latitude: centroidx
        };
        var centersQuery = centers.createQuery();
        centers.queryFeatures(centersQuery).then(function (response) {
            for (var x = 0; x < response.features.length; x++) {
                var Dgraphic = new Graphic({
                    geometry: response.features[x].geometry,
                    layer: graphicsLayer,
                    attributes: response.features[x].attributes
                });
                graphicsLayer.add(Dgraphic);
            }
            var routeparams = new RouteParameters({
                stops: new FeatureSet(),
                outSpatialReference: {
                    wkid: 3857
                }
            });
            var routeSymbolWater = {
                type: "simple-line",
                color: [173, 216, 230, 0.75],
                width: 5
            };
            var allDistances = new Array();
            var features = new Array();
            // find better way of calculating these values - all same right now
            for (var y = 0; y < graphicsLayer.graphics.length; y++) {
                var distancesq = ((centroidy - graphicsLayer.graphics.items[y].geometry.longitude) * (centroidy - graphicsLayer.graphics.items[y].geometry.longitude)) + ((centroidx - graphicsLayer.graphics.items[y].geometry.latitude) * (centroidx - graphicsLayer.graphics.items[y].geometry.latitude));
                var distance = Math.sqrt(distancesq);
                allDistances[y] = distance;
                features[y] = new Graphic({ geometry: graphicsLayer.graphics.items[y].geometry, attributes: graphicsLayer.graphics.items[y].attributes });
            }
            var allValues = allDistances.concat(features);
            function sortNumber(a, b) {
                return a - b;
            }
            var sortedDistances = allDistances.sort(sortNumber);
            var sortedGraphics = new GraphicsLayer();
            for (var m = 0; m < 4; m++) {
                for (var q = 0; q < 4; q++) {
                    if (sortedDistances[m] == allValues[q]) {
                        sortedGraphics.add(allValues[q + 4]);
                    }
                }
            }
            var markerSymbol = {
                type: "simple-marker",
                color: [169, 169, 169],
                style: "square",
                size: 2
            };
            var graphic = new Graphic({
                geometry: point,
                symbol: markerSymbol
            });
            var waterNeed = liters;
            var foodNeed = meals;
            for (var n = 0; n < sortedGraphics.graphics.length; n++) {
                while (waterNeed > 0 || foodNeed > 0) {
                    var nearestD = sortedGraphics.graphics.items[n];
                    waterNeed = waterNeed - nearestD.attributes.Water;
                    foodNeed = foodNeed - nearestD.attributes.Food;
                    routeparams.stops.features = Array(0);
                    routeparams.stops.features.push(graphic);
                    routeparams.stops.features.push(nearestD);
                    routeLayer.graphics.items = Array(0);
                    routeLayer.add(graphic);
                    routeLayer.add(nearestD);
                    if (routeparams.stops.features.length >= 2 && (nearestD.attributes.Water !== 0 || nearestD.attributes.Food !== 0)) {
                        routeTask.solve(routeparams).then(function (data) {
                            var routeResult = data.routeResults[0].route;
                            routeResult.symbol = routeSymbolWater;
                            routeLayer.add(routeResult);
                            var miles = 0;
                            for (var t = 0; t < routeLayer.graphics.items.length; t++) {
                                if (routeLayer.graphics.items[t].geometry.type == "polyline") {
                                    miles = miles + routeLayer.graphics.items[t].attributes.Total_Miles;
                                    miles = Math.round(miles);
                                    document.getElementById('miles').innerHTML = miles;
                                    document.body.style.cursor = "default";
                                    exportData = [
                                        {
                                            Variable: "Population Seeking Shelter",
                                            Value: seek
                                        },
                                        {
                                            Variable: "Liters of water needed",
                                            Value: liters
                                        },
                                        {
                                            Variable: "Number of meals needed",
                                            Value: meals
                                        },
                                        {
                                            Variable: "Cost of water",
                                            Value: water,
                                        },
                                        {
                                            Variable: "Cost of food",
                                            Value: food
                                        },
                                        {
                                            Variable: "Miles of Travel",
                                            Value: miles
                                        },
                                    ];
                                }
                            }
                        });
                    }
                }
            }
        });
    }
});