<?php

class Path_Builder {
    /*
    * @param array An array of the start attraction contains the name,
    *       address, latitude, and longitude.
    */
    public $startAttra;

    /*
    * @param array: An array of the goal attraction contains the name,
    *       address, latitude, and longitude.
    */
    public $goalAttra;

    /*
    * @param array: An array of all bus stop array, each contains the
    *       name, latitude, longitude, and the belonging lines of the
    *       bust stop.
    */
    public $Stops;
    
    /*
    * @param array: An array of all bus line array that the line name
    *       is the key. In each bus line array, the included bus stop
    *       name is added as the stop order.
    */
    public $Lines;
    
    /*
    * @param array
    */
    public $startStop;
    
    /*
    * @param array
    */
    public $goalStop;
    
    /*
    * @param array
    */
    public $lineSequences;
    
    /*
    * @param array
    */
    public $paths;
    
    /*
    * @param array: An array containing the line sequences failed to
    *       be a path result. This array is empty at initial state.
    */
    public $failed_seq;

    function __construct($start_attra_name, $goal_attra_name) {
        
        $this->init_Stops();
        
        $this->init_Lines();

        $this->startAttra = (array) DB::select('SELECT * FROM attraction_location WHERE attra_name = \''. $start_attra_name . '\'')[0];

        $this->goalAttra = (array) DB::select('SELECT * FROM attraction_location WHERE attra_name = \''. $goal_attra_name . '\'')[0];
        
        $this->startStop = $this->nearestStop($this->startAttra);
        
        $this->goalStop = $this->nearestStop($this->goalAttra);
        
        $this->init_lineSequences();
        
        $this->failed_seq = [];
    }

    /*
    * The method of counting the distance in meter according
    * to the latitude and longitude of two places.
    *
    * @arg lat1(string, float): The latitude of the 1st location.
    * @arg lon1(string, float): The longitude of the 1st location.
    * @arg lat2(string, float): The latitude of the 2nd location.
    * @arg lon2(string, float): The longitude of the 2nd location.
    */
    private function geoDistM($lat1, $lon1, $lat2, $lon2){
        $lat1 = floatval($lat1);
        $lon1 = floatval($lon1);
        $lat2 = floatval($lat2);
        $lon2 = floatval($lon2);

        $ER     = 6378.388;
        $factor = pi() / 180;
        $dLat   = ($lat2 - $lat1) * $factor;
        $dLon   = ($lon2 - $lon1) * $factor;
        $a      = sin($dLat / 2) * sin($dLat / 2) + 
                  cos($lat1 * $factor) * cos($lat2 * $factor) * 
                  sin($dLon / 2) * sin($dLon / 2);
        $c      = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d      = $ER * $c * 1000;
        return $d;
    }

    /*
    * The method initializing the `Stops` array.
    */
    private function init_Stops() {

        $this->Stops = [];

        $data = DB::select("SELECT DISTINCT stop_name, latitude, longitude FROM stop;");
        
        foreach ($data as $d) {

            $this->Stops[$d->stop_name] = (array) $d;
        }
    }
    /*
    * The method of initializing the `Lines` array.
    */
    private function init_Lines() {

        $this->Lines = [];

        $data = DB::select("SELECT line_name, branch_name, stop_name, num FROM stop;");

        foreach ($data as $id => $d) {

            $d = (array) $d;

            $name = sprintf("%s_%s", $d['line_name'], $d['branch_name']);

            if ( ! array_key_exists($name, $this->Lines) )
               { $this->Lines[$name] = []; }

            $this->Lines[$name][$d['num']] = $d['stop_name'];

            if ( ! array_key_exists('lines', $this->Stops[$d['stop_name']]) )
               { $this->Stops[$d['stop_name']]['lines'] = []; }
            
            $this->Stops[$d['stop_name']]['lines'][] = $name;
        }
    }

    /*
    * The method of getting the nearest stop for a location.
    * 
    * @arg loca array, object: A location array or object
    *       containing its latitude and longitude data.
    * @return array: The data array of the nearest stop.
    */
    private function nearestStop($loca) {

        $loca = (array) $loca;

        $nearest_stop = NULL;
        $nearest_dist = NULL;
        
        foreach ($this->Stops as $stop) {

            $dist = $this->geoDistM(
                $loca['latitude'], $loca['longitude'],
                $stop['latitude'],  $stop['longitude']
            );

            if ( is_null($nearest_dist) or $dist < $nearest_dist ){
                $nearest_stop = $stop;
                $nearest_dist = $dist;
            }
        }
        return $nearest_stop;
    }

    private function init_lineSequences() {
        
        $this->lineSequences = [];

        /*
        *   Put line sequences composed with same line
        *   into the front of the array in order to
        *   deal them earlier.
        */
        foreach (array_intersect($this->startStop['lines'], $this->goalStop['lines']) as $ln) {
            $this->lineSequences[] = array(
                'start_line'  => $ln, 
                'goal_line'   => $ln,
                'inter_lines' => []
            );
        }

        foreach ( $this->startStop['lines'] as $sl ) {
            foreach ( $this->goalStop['lines'] as $gl ) {
                if ( $sl == $gl ) { continue; }
                $this->lineSequences[] = array(
                    'start_line'  => $sl, 
                    'goal_line'   => $gl,
                    'inter_lines' => []
                );
            }
        }
    }
    private function refinePath($path) {

        $stopSeq = [];
        $stopSeq[] = $this->startStop['stop_name'];
        foreach ($path['links'] as $key => $link) {
            $stopSeq[] = $link['from'];
            $stopSeq[] = $link['to'];
        }
        $stopSeq[] = $this->goalStop['stop_name'];

        $pureSeq = array_merge(
            [$path['lineSequence']['start_line']],
            $path['lineSequence']['inter_lines'],
            [$path['lineSequence']['goal_line']]
        );

        $stepSeq = [];
        foreach ( $pureSeq as $key => $line ) {
            $stepSeq[] = [
                'on_st'  => $stopSeq[$key*2],
                'off_st' => $stopSeq[$key*2 + 1],
                'line'   => $line
            ];
        }
        return $stepSeq;
    }

    public function buildPath($returnFirst = TRUE) {

        // Basic information
        /*$this->paths = [
            'from_attra' => $this->startAttra['attra_name'],
            'to_attra'   => $this->goalAttra['attra_name'],
            'from_st'    => $this->startStop['stop_name'],
            'to_st'      => $this->goalStop['stop_name']
        ];*/

        $minInterLn = NULL;

        while ( $seq = array_shift($this->lineSequences) ) {

            /*
            *   Break if new line sequence has more inter line
            *   than path results got previously.
            */
            if ( ! is_null($minInterLn) and count($seq['inter_lines']) > $minInterLn ) {
                //$_SESSION['app']['monolog']->addDebug('Exceed inter line minimum of '. $minInterLn );
                break;
            }

            /*
            *   A path is found.
            */
            if ( $path = $this->seekPath($seq) ) {

                //$_SESSION['app']['monolog']->addDebug('Get Path: '. json_encode($path));

                $this->paths[] = $this->refinePath($path);
                //$this->paths[] = $path;
                $minInterLn = count($path['lineSequence']['inter_lines']);
                
                // Do not want to get multiple path results.
                if ( $returnFirst )
                   { break; }
            }

            /*
            *   Add new line sequences with a failed sequence.
            */
            if ( empty($this->lineSequences) and ! empty($this->failed_seq) ) {
                $pureSeq      = array_shift($this->failed_seq);
                $newLineNames = array_diff(array_keys($this->Lines), $pureSeq);
                $lineSequence = [
                    'start_line'  => $pureSeq[0], 
                    'goal_line'   => end($pureSeq),
                    'inter_lines' => array_slice($pureSeq, 1, -1)
                ];
                foreach ($newLineNames as $lineName) {
                    $lineSequence['inter_lines'][] = $lineName;
                    $this->lineSequences[] = $lineSequence;
                }
            }
        }
    }

    private function index_of_st_in_ln($stopName, $lineName, $firstIndex = TRUE) {      
        $index = NULL;
        foreach ( $this->Lines[$lineName] as $i => $st_n ) {
            if ( $stopName == $st_n ) {
                $index = $i;                
                if ( $firstIndex )
                   { break; }
            }
        }
        return $index;
    }

    private function nextLink($initStName, $fromLnName, $toLnName, $endStName = NULL) {

        $initStIndex = $this->index_of_st_in_ln($initStName, $fromLnName);
        $endStIndex  = $this->index_of_st_in_ln($endStName, $toLnName, FALSE);

        /*
        *   On the same line and sequencially available for taking a bus.
        */
        if ( $fromLnName == $toLnName and $initStIndex <= $endStIndex )
           { return ['from' => $initStName, 'to' => $initStName]; }

        foreach ( $this->Lines[$fromLnName] as $fromIndex => $fromStName) {
            
            /*
            *   Skip the unreachable previous stations.
            */
            if ( $fromIndex < $initStIndex )
               { continue; }
            
            foreach ( $this->Lines[$toLnName] as $toIndex => $toStName) {

                /*
                *   Skip the stations behind the end station.  
                */
                if ( $toIndex > $endStIndex )
                   { break; }

                $dist = $this->geoDistM(
                    $this->Stops[$fromStName]['latitude'],
                    $this->Stops[$fromStName]['longitude'],
                    $this->Stops[$toStName]['latitude'],
                    $this->Stops[$toStName]['longitude']
                );

                /*
                *   Return the first available station pair.
                */
                if ( $dist < 100 ) {
                    return ['from' => $fromStName, 'to' => $toStName];
                }
            }            
        }
        return NULL;
    }

    private function seekPath($lineSequence) {

        $path = [
            'lineSequence' => $lineSequence,
            'links' => []
        ];

        $pureSeq = array_merge(
            [$lineSequence['start_line']],
            $lineSequence['inter_lines'],
            [$lineSequence['goal_line']]
        );

        /*
        * Build link sequencially.
        */
        foreach ($pureSeq as $index => $line) {

            /*
            * Set next line or break without it.
            */
            if  ( $index == count($pureSeq) - 1 ) {
                break;
            } else {
                $nextLine = $pureSeq[$index+1];
            }

            /*
            * Set from-stop.
            */
            if  ( $index == 0 ) {
                $fromStName = $this->startStop['stop_name'];
            } else {
                $fromStName = end($path['links'])['to'];
            }

            /*
            * Set the limit stop for to-line.
            */
            if  ( $index == count($pureSeq)-2 ) {
                $endStName = $this->goalStop['stop_name'];
            } else {
                $endStName = NULL;
            }

            $link = $this->nextLink(
                $fromStName,
                $line,
                $nextLine,
                $endStName
            );

            /*
            *   Break if lost of link continuity.
            */
            if  ( ! $link )
                { $path = NULL; break; }

            $path['links'][] = $link;
        }

        /*
        *   Add inter lines as new line sequence into work list,
        *   if the total length of current line sequence does not 
        *   exceed 3, and the current line sequence have no path.
        */
        if ( ! $path and count($pureSeq) <= 3 ){
            $this->failed_seq[] = $pureSeq;
        }

        return $path;
    }
}