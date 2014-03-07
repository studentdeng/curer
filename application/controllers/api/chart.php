<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author      studentdeng 
 * @link        <studentdeng.github.com> 
 * @datetime    2013-11-20 
 */
require APPPATH . '/libraries/REST_Controller.php';

class Chart extends REST_Controller
{

    public function show_post()
    {
        $inputParam = array('labels', 'datasets');
        $paramValues = $this->posts($inputParam);

        $labels = $paramValues["labels"];
        $datasets = $paramValues["datasets"];

        $html = <<<HTML
<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <head>
        <title>chart</title>
        <script type="text/javascript" src="http://112.124.107.63/curer/js/jquery.js"></script>
        <script type="text/javascript" src="http://112.124.107.63/curer/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://112.124.107.63/curer/js/jquery.paging.min.js"></script>
        <script type="text/javascript" src="http://112.124.107.63/curer/js/jquery.jqpagination.js"></script>
        <script type="text/javascript" src="http://112.124.107.63/curer/js/Chart.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
    </head>
    <body style="background-color: transparent;">
        <canvas id="canvas" width="550" height="300" style='background-color: transparent;'></canvas>
    </body>
</html>
HTML;

        echo $html;

        $js = <<<js
<script type="text/javascript">

                
        
                    var lineChartData = {
                        labels: $labels,
                        datasets: $datasets
                    };    
        
   var config = {
				
	//Boolean - If we show the scale above the chart data			
	scaleOverlay : false,
	
	//Boolean - If we want to override with a hard coded scale
	scaleOverride : false,
	
	//** Required if scaleOverride is true **
	//Number - The number of steps in a hard coded scale
	scaleSteps : null,
	//Number - The value jump in the hard coded scale
	scaleStepWidth : null,
	//Number - The scale starting value
	scaleStartValue : null,

	//String - Colour of the scale line	
	scaleLineColor : "rgba(0,0,0,.1)",
	
	//Number - Pixel width of the scale line	
	scaleLineWidth : 1,

	//Boolean - Whether to show labels on the scale	
	scaleShowLabels : false,
	
	//Interpolated JS string - can access value
	scaleLabel : "<%=value%>",
	
	//String - Scale label font declaration for the scale label
	scaleFontFamily : "'Arial'",
	
	//Number - Scale label font size in pixels	
	scaleFontSize : 12,
	
	//String - Scale label font weight style	
	scaleFontStyle : "normal",
	
	//String - Scale label font colour	
	scaleFontColor : "#666",	
	
	///Boolean - Whether grid lines are shown across the chart
	scaleShowGridLines : true,
	
	//String - Colour of the grid lines
	scaleGridLineColor : "rgba(0,0,0,.05)",
	
	//Number - Width of the grid lines
	scaleGridLineWidth : 1,	
	
	//Boolean - Whether the line is curved between points
	bezierCurve : true,
	
	//Boolean - Whether to show a dot for each point
	pointDot : true,
	
	//Number - Radius of each point dot in pixels
	pointDotRadius : 3,
	
	//Number - Pixel width of point dot stroke
	pointDotStrokeWidth : 1,
	
	//Boolean - Whether to show a stroke for datasets
	datasetStroke : true,
	
	//Number - Pixel width of dataset stroke
	datasetStrokeWidth : 2,
	
	//Boolean - Whether to fill the dataset with a colour
	datasetFill : true,
	
	//Boolean - Whether to animate the chart
	animation : false,

	//Number - Number of animation steps
	animationSteps : 60,
	
	//String - Animation easing effect
	animationEasing : "easeOutQuart",

	//Function - Fires when the animation is complete
	onAnimationComplete : null
	
};
        
    var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData, config);

                
</script>
js;

        echo $js;
    }

}