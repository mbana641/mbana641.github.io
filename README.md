## Team Name: DC++

## What it does

In the span of two weeks in May of 2019, over 300 tornadoes touched down in states from Ohio to Nebraska. As climate change occurs, there will be an increase in extreme weather incidents ranging from tornadoes, hurricanes, blizzards and floods. It is imperative that both everyday people and planners have access to situational awareness both before and during these events.

In the span of two weeks in May of 2019, over 300 tornadoes touched down in states from Ohio to Nebraska. As climate change occurs, there will be an increase in extreme weather incidents ranging from tornadoes, hurricanes, blizzards and floods. It is imperative that both everyday people and planners have access to situational awareness both before and during these events.

Our first operations dashboard will show the location of live weather events using the USA Watches and Warnings layer found on the Living Atlas. Using an ArcGIS API for Python Script scheduled to run every 10 minutes through Windows Task Scheduler, demographic data from the CDC social vulnerability index will be synced to current existing weather event polygons to provide planners a view of how many people in at risk groups, would be affected by extreme weather events. 

Our JavaScript Web Application will use data from Living Atlas layers to show locations of recent tornadoes. The user will then be able to draw a polygon that would calculate what percentage of the population in the chosen area would be affected by this storm, depending on the severity of the storm, and route them to the nearest shelter. These calculations will be based on a Living Atlas layer of CDC Socioeconomic Vulnerability Indexes at census tract level. 

Our second operations dashboard will provide planners with a view of emergency shelters and their needs in terms of essential supplies and locations, Walmart, where they could purchase such supplies.

## How we built it

Our suite of products was created using the ArcGIS API for Python (scheduled using Windows Task Scheduler), ArcGIS API for JavaScript, and Operations Dashboard.

## Why is this important?

This combined suite of tools will enhance situational awareness in cases of extreme weather events and help save lives. These tools will provide invaluable resources to disaster response organization and the general public to increase the ease of planning and response for natural disasters.

## Data used from ArcGIS Living Atlas of the World

Storms Layers: https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/NWS_Watches_Warnings_v1/FeatureServer/9
https://services9.arcgis.com/RHVPKKiFTONKtxq3/arcgis/rest/services/NWS_Watches_Warnings_v1/FeatureServer/10
CDC SVI Layer: https://services3.arcgis.com/ZvidGQkLaDJxRSJ2/arcgis/rest/services/Overall_2014_Tracts/FeatureServer/1
