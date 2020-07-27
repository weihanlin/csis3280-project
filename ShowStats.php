<?php
require_once ("inc/config.inc.php");
require_once ("inc/Entity/Page.class.php");


Page::$title="Parking Space Statistic";
Page::header();


?>
    <script src="https://d3js.org/d3.v5.min.js"></script>

    <section>
    <div class="stats" id="spaceCount"></div>
    </section>
    <section>
    <div class="stats" id="spaceAvg"></div>
    </section>

    <script>
        const margin = {top: 60, right: 60, bottom: 10, left: 120};
        const width = 600 - margin.left - margin.right;
        const height = 400 - margin.top - margin.bottom;

        const svg = d3.selectAll(".stats").append("svg")
                        .attr('width', width + margin.left + margin.right)
                        .attr('height', height + margin.top + margin.bottom);

        const g = svg.append("g").attr("transform", "translate(" + margin.left +","+ margin.top + ")");


        const xscale = d3.scaleLinear().range([0,width]);
        const yscale = d3.scaleBand().rangeRound([0,height]).paddingInner(0.1);

        const xaxis = d3.axisTop().scale(xscale);
        const yaxis = d3.axisLeft().scale(yscale);


        d3.json("data.php?q=sum").then((json) => {

            d3.select("#spaceCount svg")
                .append("text").text("Total Spaces for each parking lot").attr("x", 0).attr("y", margin.top/2);

            xscale.domain([0, d3.max(json, (d) => parseInt(d.Count))]);
            yscale.domain(json.map((d)=>d.ShortName));


            const rect = d3.select("#spaceCount svg g").selectAll("rect").data(json).join("rect")
                .attr("x",0)
                .attr("height", yscale.bandwidth())
                .attr("width", (d)=>xscale(d.Count))
                .attr("y", (d)=>yscale(d.ShortName));

            rect.on("mouseover", function() {d3.select(this).attr("fill","orange")})
                .on("mouseout", function() {d3.select(this).attr("fill","black")});

            d3.select("#spaceCount svg g").selectAll("text").data(json).join("text")
                .text((d)=>d.Count)
                .attr("text-anchor","middle")
                .attr("x", (d)=>xscale(d.Count) + 10)
                .attr("y", (d)=>yscale(d.ShortName)+yscale.bandwidth()/2)
                .attr("fill","black");

            xaxis.ticks(d3.max(json, (d) => d.Count),"f");

            const g_xaxis = d3.select("#spaceCount svg g").append("g").attr("class","x axis");
            const g_yaxis = d3.select("#spaceCount svg g").append("g").attr("class","y axis");

            g_xaxis.call(xaxis);
            g_yaxis.call(yaxis);

        });


        d3.json("data.php?q=avg").then((json) => {

            d3.select("#spaceAvg svg")
                .append("text").text("Average Unit Price for each parking lot").attr("x", 0).attr("y", margin.top/2);

            xscale.domain([0, d3.max(json, (d) => parseFloat(d.Avg))]);
            yscale.domain(json.map((d)=>d.ShortName));

            const rect = d3.select("#spaceAvg svg g").selectAll("rect").data(json).join("rect")
                .attr("x",0)
                .attr("height", yscale.bandwidth())
                .attr("width", (d)=>xscale(d.Avg))
                .attr("y", (d)=>yscale(d.ShortName));

            rect.on("mouseover", function() {d3.select(this).attr("fill","orange")})
                .on("mouseout", function() {d3.select(this).attr("fill","black")});

            d3.select("#spaceAvg svg g").selectAll("text").data(json).join("text")
                .text((d)=>d3.format("$.2f")(d.Avg))
                .attr("text-anchor","middle")
                .attr("x", (d)=>xscale(d.Avg) + 30)
                .attr("y", (d)=>yscale(d.ShortName)+yscale.bandwidth()/2)
                .attr("fill","black");

            xaxis.ticks(d3.max(json, (d) => parseFloat(d.Avg)), "f");
            const g_xaxis = d3.select("#spaceAvg svg g").append("g").attr("class","x axis");
            const g_yaxis = d3.select("#spaceAvg svg g").append("g").attr("class","y axis");

            g_xaxis.call(xaxis);
            g_yaxis.call(yaxis);

        });

    </script>


<?php

Page::footer();
