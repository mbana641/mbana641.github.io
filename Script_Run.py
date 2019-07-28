from arcgis.gis import GIS
from arcgis.geometry import Geometry, project
from arcgis.features import FeatureLayer
from arcgis.geometry.filters import intersects
import json
gis=GIS("http://esrifederal.maps.arcgis.com", "MBanaski_Federal", "GeologyRocks9?")
svi = FeatureLayer("https://services3.arcgis.com/ZvidGQkLaDJxRSJ2/arcgis/rest/services/Overall_2014_Tracts/FeatureServer/1")
severeStorm = FeatureLayer("https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/NWS_Watches_Warnings_v1/FeatureServer/9")
moderateStorm = FeatureLayer("https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/NWS_Watches_Warnings_v1/FeatureServer/10")
svi_in_weather = []
dataItem = gis.content.get("fcf8dccebeb043a2adcd87016725bfb5")
data = dataItem.layers[0]
severe = severeStorm.query(where = '1=1', return_geometry = True)
moderate = moderateStorm.query(where = '1=1', return_geometry = True)
stats = [{"statisticType": "sum", "onStatisticField": "E_TOTPOP", "outStatisticFieldName": "SUM_POP"}, 
{"statisticType": "sum", "onStatisticField": "E_POV", "outStatisticFieldName": "SUM_POV"},
{"statisticType": "sum", "onStatisticField": "M_AGE65", "outStatisticFieldName": "SUM_ELDERLY"},
{"statisticType": "sum", "onStatisticField": "E_SNGPNT", "outStatisticFieldName": "SUM_SINGLE"},
{"statisticType": "sum", "onStatisticField": "E_NOVEH", "outStatisticFieldName": "SUM_NOVEH"}]
data.delete_features(where='1=1')
for feature in moderate.features:
    weather_geom = feature.geometry
    weather = [weather_geom]
    weather_proj = project(geometries=weather, in_sr=102100, out_sr=4269, transform_forward=True)
    svi_weather_selection = svi.query(where="1=1", out_statistics=stats, geometry_filter= intersects(weather_proj[0]))
    statistics = svi_weather_selection.features[0]
    proj = str(weather_proj[0])
    proj = '{"rings"' + proj[8:]
    statistics = str(statistics)
    statistics = statistics[0:-1]
    statistics = "" + statistics + ', "geometry": ' + proj + '}'
    statistics = json.loads(statistics)
    data.edit_features(adds=[statistics])
for feature in severe.features:
    weather_geom = feature.geometry
    weather = [weather_geom]
    weather_proj = project(geometries=weather, in_sr=102100, out_sr=4269, transform_forward=True)
    svi_weather_selection = svi.query(where="1=1", out_statistics=stats, geometry_filter= intersects(weather_proj[0]))
    statistics = svi_weather_selection.features[0]
    proj = str(weather_proj[0])
    proj = '{"rings"' + proj[8:]
    statistics = str(statistics)
    statistics = statistics[0:-1]
    statistics = "" + statistics + ', "geometry": ' + proj + '}'
    statistics = json.loads(statistics)
    data.edit_features(adds=[statistics])