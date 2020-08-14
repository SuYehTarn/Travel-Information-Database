<?php


/*
* A method getting the address and opening time of an attraction.
*
* @arg attra_name(str): The name of the attraction that its
*       information is intented.
* @return (array): An associated array contains the address
*       and opening time of an attraction.
*/
function getInfo($attra_name) {
    /*
    * @var string
    */
	$address = DB::select('SELECT address FROM attraction_location WHERE attra_name = \''. $attra_name . '\'')[0]->address;
	
    /*
    * @var object
    */
	$times = DB::select('SELECT * FROM attraction_open_time_slot WHERE attra_name = \'' . $attra_name . '\'');

    $texts = [];

    foreach ($times as $time) {
        
        /*
        * @var array: The array of weekday strings corresponding
        * to the the weekday number.
        */
        $weekday = ['日', '一', '二', '三', '四', '五', '六'];

        /*
        * @var array: The array of open condition strings
        *       corresponding to the the open condition number.
        */
        $condition = [
            '0' => '休息',
            '1' => '全天',
            '3' => '活動而定',
            '2' => '依各店家',
            '9' => '其他'
        ];

    	if ( (int) $time->open_condition == 5 ) {

    		$texts[] = sprintf(
    			"週%s %s - %s",
    			$weekday[ $time->day ],
    			$time->start_time,
    			$time->end_time
    		);

    	} else {

    		$texts[] = sprintf(
    			"週%s %s",
    			$weekday[ $time->day ],
    			$condition[ $time->open_condition ]
    		);
    	}
    }
    return ['address' => $address, 'texts' => $texts];
}

/*
* A method getting the path searching result for a pair of attractions.
*
* @arg fromAttra(str): The name of the starting attraction.
* @arg toAttra(str) : THe name of the destination attraction.
* @return (array): An associated array contains the path
*       searching result.
*/
function getPaths($fromAttra, $toAttra) {
    $pb = new Path_Builder( $fromAttra, $toAttra );
    $pb->buildPath(FALSE);
    return $pb->paths;
}