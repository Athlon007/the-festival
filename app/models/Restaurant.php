<?php

class Restaurant implements JsonSerializable{

protected int $restaurantId;
protected String $restaurantName;
protected int $addressId;
protected int $numOfSessions;
protected time $durationOfSessions;

public function jsonSerialize() : mixed
{
    return [
        'restaurantId' => $this->restaurantId,
        'restaurantName' => $this->restaurantName,
        'addressId' => $this->addressId,
        'numOfSessions' => $this->numOfSessions,
        'durationOfSessions' => $this->durationOfSessions,
    ];
}
	/**
	 * @return int
	 */
	public function getRestaurantId(): int {
		return $this->restaurantId;
	}
	
	/**
	 * @param int $restaurantId 
	 * @return self
	 */
	public function setRestaurantId(int $restaurantId): self {
		$this->restaurantId = $restaurantId;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getRestaurantName(): string {
		return $this->restaurantName;
	}
	
	/**
	 * @param string $restaurantName 
	 * @return self
	 */
	public function setRestaurantName(string $restaurantName): self {
		$this->restaurantName = $restaurantName;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getAddressId(): int {
		return $this->addressId;
	}
	
	/**
	 * @param int $addressId 
	 * @return self
	 */
	public function setAddressId(int $addressId): self {
		$this->addressId = $addressId;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getNumOfSessions(): int {
		return $this->numOfSessions;
	}
	
	/**
	 * @param int $numOfSessions 
	 * @return self
	 */
	public function setNumOfSessions(int $numOfSessions): self {
		$this->numOfSessions = $numOfSessions;
		return $this;
	}
	
	/**
	 * @return time
	 */
	public function getDurationOfSessions(): time {
		return $this->durationOfSessions;
	}
	
	/**
	 * @param time $durationOfSessions 
	 * @return self
	 */
	public function setDurationOfSessions(time $durationOfSessions): self {
		$this->durationOfSessions = $durationOfSessions;
		return $this;
	}
}

?>
