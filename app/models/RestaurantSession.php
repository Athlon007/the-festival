<?php

Class RestaurantSession implements JsonSerializable{

protected int $id;
protected date $date;
protected int $AvailableSeats;
protected int $restaurantId;

protected time $startTime;
protected time $endTime;

public function jsonSerialize() : mixed{
    return [
        'Id' => $this->id,
        'date' => $this->date,
        'AvailableSeats' => $this->AvailableSeats,
        'restaurantId' => $this->restaurantId,
        'startTime' => $this->startTime,
        'endTime' => $this->endTime
    ];
}
}

?>