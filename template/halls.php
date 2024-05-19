<?php
include './models/Hall.php';
include './models/Event.php';
include './helpers/Database.php';
include './debugging.php';


function getSuggestedDatesForHall($hall, $startDate, $endDate, $checkAfter) {
    // sort by end date ascending to get earliest possible available
    // time for the hall after the desired timeframe
    // OR descending to get latest possible available time for the hall
    // before the desired timeframe
    $events = $checkAfter ? 
            Event::getEventsForHallSorted($hall->hall_id, 'asc', $startDate)
            :  Event::getEventsForHallSorted($hall->hall_id, 'desc', $endDate);
    $eventsCount = count($events);
    $suggestStart = '';
    $suggestEnd = '';
    for ($i = 0; $i < $eventsCount; $i++) {
        $event = (object) $events[$i];

        $eStartDate = $event->start_date;
        $eEndDate = $event->end_date;
//        echo "Checking event for hall $hall->hall_name which starts on $eStartDate and ends on $eEndDate.  ";

        // set check parameters based on whether to check after the event or before it
        if ($checkAfter) {
            $dateInterval = date_diff(new DateTime($startDate), new DateTime($endDate));
//            echo "Date interval is ". $dateInterval->format('%R%a days');
            $startDateCheck = new DateTime($eEndDate);
            $startDateCheck->modify('+1 day');
            $endDateCheck = clone $startDateCheck;
            $endDateCheck->add($dateInterval);
        } else {
            $dateInterval = date_diff(new DateTime($endDate), new DateTime($startDate));
//            echo "Date interval is ". $dateInterval->format('%R%a days');
            $endDateCheck = new DateTime($eStartDate);
            $endDateCheck->modify('-1 day');
            $startDateCheck = clone $endDateCheck;
            $startDateCheck->add($dateInterval);
        }

        // if this is the last event, no need to check
        if ($i == $eventsCount-1) {
//            echo "Last event to check, just return";
            $suggestStart = $startDateCheck->format('Y-m-d');
            $suggestEnd = $endDateCheck->format('Y-m-d');
//            echo "Now suggested dates are $suggestStart and $suggestEnd. <br> ";
            break;
        }
//        echo "Checking dates ".$startDateCheck->format('Y-m-d')." and ".$endDateCheck->format('Y-m-d')." to see if they are valid. ";

        $nextEvent = (object) $events[$i+1];
        $nextStart = $nextEvent->start_date;
        $nextEnd = $nextEvent->end_date;
//        echo "Next event starts $nextStart and ends $nextEnd.  ";
        
        if (!Hall::areDatesOverlapping($startDateCheck->format('Y-m-d'), 
                $endDateCheck->format('Y-m-d'), $nextStart, $nextEnd)) {
            // if not overlapping, this date range works
//            echo "Dates do not overlap. get timerange.  ";
            $suggestStart = $startDateCheck->format('Y-m-d');
            $suggestEnd = $endDateCheck->format('Y-m-d');
//            echo "Now suggested dates are $suggestStart and $suggestEnd. <br> ";
            break;
        }
        // dates are overlapping next event, wont work
//        echo "Dates are overlapping. Continuing.<br>  ";
    }
    return [
        "suggestedStartDate"=>$suggestStart,
        "suggestedEndDate"=>$suggestEnd
    ];
}

function getClosestDate($testDate, $against1, $against2) {
    // compare $against1 and $against2 to $testDate
    // to find which one is closer
    $testDateObj = new DateTime($testDate);
    $against1Obj = new DateTime($against1);
    $against2Obj = new DateTime($against2);
    $diff1 = date_diff($testDateObj, $against1Obj, true);
    $diff2 = date_diff($testDateObj, $against2Obj, true);
    return $diff1 < $diff2 ? $against1 : $against2;
}

function getSuggestedDates($startDate, $endDate) {
    $h = new Hall();
    $halls = $h->getAllHalls();
    $suggestedDates = [];
    // loop through each hall to get best available dates
    foreach ($halls as $hall) {
        $hallSuggestedDatesAfter = getSuggestedDatesForHall($hall, $startDate, $endDate, true);
        $hallSuggestedDatesBefore = getSuggestedDatesForHall($hall, $startDate, $endDate, false);
        
        $testAfter = $hallSuggestedDatesAfter['suggestedStartDate'];
        $testBefore = $hallSuggestedDatesBefore['suggestedStartDate'];
        
        $closestSuggestedDate = getClosestDate($startDate, $testAfter, $testBefore);
        $closestSuggestedDates = $closestSuggestedDate == $testAfter ?
                $hallSuggestedDatesAfter : $hallSuggestedDatesBefore;
        $suggestedDates[] = $closestSuggestedDates;
    }
    return $suggestedDates;
}

function getSuggestedDate($suggestedDates, $num) {
    // returns formatted string for the date from the array $suggestedDates
    if (count($suggestedDates) >= $num){
        $suggested = $suggestedDates[$num-1];
        $text = $suggested['suggestedStartDate'];
        $text .= " to ";
        $text .= $suggested['suggestedEndDate'];
        return $text;
    }
}

function filterByCapacity($availableHalls, $audience) {
    $newList = [];
    foreach ($availableHalls as $hall) {
        if ($audience <= $hall->capacity) {
            $newList[] = $hall;
        }
    }
    return $newList;
}

function filterHalls() {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $audience = $_POST['audience'];
    $returnList = [
        'suggestedDates'=>null,
        'maxAudience'=>null,
        'halls'=>null,
        'filterError'=>null,
        'searchError'=>null
    ];
    // check if start and end dates are valid
    if (!$startDate || !$endDate) {
        $filterError = "Both dates must be filled to search.";
        $returnList['filterError'] = $filterError;
        return $returnList;
    }
    if ($startDate > $endDate) {
        $filterError = "Start date cannot be before end date.";
        $returnList['filterError'] = $filterError;
        return $returnList;
    }
    if ($startDate <= date("Y-m-d")) {
        $filterError = "Start date cannot be today or earlier.";
        $returnList['filterError'] = $filterError;
        return $returnList;
    }
    
    // check if there are any halls available at this time
    $availableHalls = Hall::getAvailableHalls($startDate, $endDate);
    if (!$availableHalls) {
        // suggest different time slot if no halls are available
        $suggestedDates = getSuggestedDates($startDate, $endDate);
        $returnList['suggestedDates'] = $suggestedDates;
        return $returnList;
    }
    
    // handle audience count
    if ($audience) {
        $availableHallsCapacityFiltered = filterByCapacity($availableHalls, $audience);
        // if halls are available but not for this amount of audience,
        // find maximum audience and display message
        if (!$availableHallsCapacityFiltered) {
            $maxAudience = Hall::getMaxCapacity();
            if ($audience > $maxAudience) {
                $searchError = "No halls found for the specified audience number. The largest hall available has $maxAudience seats.";
                $returnList['searchError'] = $searchError;
                $returnList['maxAudience'] = $maxAudience;
                return $returnList;
            }
            // if halls found but not for this audience amount, show suggestions (dont return)
            $searchError = "The halls with the specified filters do not have enough capacity for your audience. Here are some suggestions:";
            $returnList['searchError'] = $searchError;
        }
    }
    
    $halls = $availableHalls;
    $returnList['halls'] = $halls;
//    $returnList['availableHalls'] = $availableHalls;
    return $returnList;
}

// filter halls based on selected time range and audience number
if (isset($_POST['filter'])) {
    $result = filterHalls();
    if ($result['halls']) {
        $halls = $result['halls'];
//        $availableHalls = $result['availableHalls'];
    } else if ($result['suggestedDates']) {
        $suggestedDates = $result['suggestedDates'];
    } else if ($result['maxAudience']) {
        $maxAudience = $result['maxAudience'];
    } else if ($result['filterError']) {
        $filterError = $result['filterError'];
    }
    if ($result['searchError']) {
        $searchError = $result['searchError'];
    }
}


// search and display halls based on search query
$hall = new Hall();

if ($_POST['submitted']) {
    $searchTerm = trim($_POST['search']);
//    echo 'submitted: ' . $searchTerm;
    $halls = $hall->getHallsBySearch($searchTerm);
} else if (!isset($_POST['filter'])) {
//    echo 'get all active halls';
    $halls = $hall->getAllHalls();
}

//echo " there are " . count($halls);

function displayHalls($dataSet) {


    foreach ($dataSet as $data) {
        $data = (object) $data;
        $hall = new Hall();
        $id = $data->hall_id;
        $hall->initWithHallid($id);
//        if ($_POST['submitted']) {
//            var_dump($data);
//            var_dump($id);
//            echo 'hall id: '.$data->hall_id;
//        }
        $image = new HallImage();
        $hallImages = $image->getAllImagesForHall($id);
        echo '
        <div class="col">
            <div class="card mb-5 ">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col">
                            <div id="carousel-' . $id . '" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">';
                        for ($j = 0; $j < count($hallImages); $j++) {
                            if ($j == 0) {
                                echo '<button type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                            } else {
                                echo '<button type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide-to="' . ($j) . '" aria-label="Slide ' . ($j) . '"></button>';
                            }
                        }
                           echo'</div>
                                <div class="carousel-inner rounded-top">';
                        for ($k = 0; $k < count($hallImages); $k++) {
                            if ($k == 0) {
                                echo '<div class="carousel-item active">
                                        <img src="' . $hallImages[$k]->hall_image_path . '" class="d-block w-100" alt="...">
                                    </div>';
                            } else {
                                echo '<div class="carousel-item">
                                        <img src="' . $hallImages[$k]->hall_image_path . '" class="d-block w-100" alt="...">
                                    </div>';
                            }
                        }

                            echo'</div> 
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        ';
        echo '<div class="p-3">';
            echo '<div class="row text-center">';
                echo '<h1 class="col">' . $hall->getHallName() . '</h1>'
                . '</div>';
            echo '<div class="row"><p class="col text-center text-truncate">' . $hall->getDescription() . '</p></div>';
            echo '<div class="row align-items-center">';
                echo '<div class="col"><h3 class="text-end">' . $hall->getRentalCharge() . ' BHD/Hr</h3></div>'
                    . '<div class="col-auto text-center"><a role="button" href="client_booking.php?hallId=' . $id . '" class="btn btn-primary btn-lg">Book Now</a></div>'
                    . '<div class="col"><h3 class="text-start">' . $hall->getCapacity() . ' Seats</h3></div>'
                . '</div>
                </div>
            </div>
        </div>';
    }




//                            </div>
//                            <div class="row mt-3">
//                                Description for the hall thats very long to show the length of the lthing is very long Description for the hall
//                                thats very long to show the length of the lthing is very long...
//                            </div>
//                            <div class="row mt-5">
//                                <div class="col text-center"><h3>100.00 BHD/Hr</h3></div>
//                                <div class="col text-center"><button class="btn btn-primary">Book Now</button></div>
//                                <div class="col text-center"><h3>80 Seats</h3></div>
//                            </div>
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 shadow-lg rounded my-5 p-4">
            <h4 class="text-left">Search for Available Halls</h4>
            <form action="index.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control border border-secondary" id="startDate" name="startDate">
                    </div>
                    <div class="col-md-4">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control border border-secondary" id="endDate" name="endDate">
                    </div>
                    <div class="col-md-4">
                        <label for="audienceCount" class="form-label">Number of Audiences</label>
                        <input type="number" class="form-control border border-secondary" id="audienceCount" name="audience">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary shadow-lg mt-4">Search Now</button>
                        <input type="hidden" name="filter" value="1">
                    </div>
                </div>
                <?php
                if ($filterError) {
            echo '<div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <p class="text-center text-danger">'.$filterError.'</p>
                    </div>
                </div>';
                }
                ?>
            </form>
        </div>
    </div>
    <form method="post" action="index.php">
        <div class="input-group">
            <input type="text" class="form-control mb-0" placeholder="Search For a Hall" id="search" name="search">
            <button type="submit" class="btn btn-outline-secondary rounded-end" id="searchBtn">
                <i class="bi bi-search"> Search</i>
            </button>
            <input type="hidden" name="submitted" value="1">
        </div>
    </form>
    <section class="my-4">
        <div class="container ">
            <?php
            // print error if audience doesnt fit any halls
            if ($searchError) {
                echo "<div class='row'>
                        <div class='col'>
                            <h5 class='text-danger'>$searchError</h5>
                        </div>
                    </div>";
            } else if ($_POST['filter'] && !$halls && !$filterError) {
                // print suggested time slots if no halls are available
                echo '<div id="suggestionBox" class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h4>No halls are available for the selected time slot. Here are some alternatives:</h4>
                                </div>
                            </div>
                            <div class="row">';
                        for ($i = 0; $i < count($suggestedDates) 
                                && $i < 3;$i++) {
                            echo "<div class='col-4'>";
                                echo '<h5 class="text-center">'.getSuggestedDate($suggestedDates,$i+1).'</h5>';
                            echo "</div>";
                        }
                    echo '</div>
                        </div>
                    </div>';
            }
            ?>
                    
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-sm-1 row-cols-xl-2 justify-content-center">
                <?php
                displayHalls($halls);
                ?>

                <!--                        <div class="card mb-5">
                                            <div id="hall-3" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#hall-3" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#hall-3" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#hall-3" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                                                                <div class="carousel-caption d-none d-md-block text-end">
                                                                                                    <button class="btn btn-primary">Book Now</button>
                                                                                                </div>

                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                    </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#hall-3" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#hall-3" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <div class="row text-center">
                                                <h1>Hall Name and Stuff</h1>
                                            </div>
                                            <div class="row mt-3">
                                                Description for the hall thats very long to show the length of the lthing is very long Description for the hall
                                                thats very long to show the length of the lthing is very long...
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col text-center"><h3>100.00 BHD/Hr</h3></div>
                                                <div class="col text-center"><button class="btn btn-primary">Book Now</button></div>
                                                <div class="col text-center"><h3>80 Seats</h3></div>
                                            </div>
                                        </div>

                                        <div class="card mb-5">
                                            <div id="hall-4" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#hall-4" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#hall-4" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#hall-4" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                                                                <div class="carousel-caption d-none d-md-block text-end">
                                                                                                    <button class="btn btn-primary">Book Now</button>
                                                                                                </div>

                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                    </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#hall-4" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#hall-4" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <div class="row text-center">
                                                <h1>Hall Name and Stuff</h1>
                                            </div>
                                            <div class="row mt-3">
                                                Description for the hall thats very long to show the length of the lthing is very long Description for the hall
                                                thats very long to show the length of the lthing is very long...
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col text-right"><h3>100.00 BHD/Hr</h3></div>
                                                <div class="col text-center"><button class="btn btn-primary">Book Now</button></div>
                                                <div class="col text-left"><h3>80 Seats</h3></div>
                                            </div>
                                        </div>-->


            </div>
        </div>
    </section>
</div>
