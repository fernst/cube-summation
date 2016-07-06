<?php
/**
 * Created by IntelliJ IDEA.
 * User: fernando
 * Date: 7/5/16
 * Time: 8:09 PM
 */

namespace App\Classes;


/**
 * Class Refactor
 * @package App\Classes
 */
class Refactor
{
//Constants used for code legibility and simplicity
//Can be defined as CONST for php 5.6+
public static $PUSH_MESSAGE = 'Tu servicio ha sido confirmado!';
public static $OPEN_STATUS = 'Open';
public static $STATUS_1 = '1';
public static $STATUS_2 = '2';
public static $STATUS_6 = '6';
public static $NOT_AVAILABLE = '0';
public static $USER_TYPE_IOS = '1';
public static $SOUND_IOS = 'honk.wav';
public static $SOUND_ANDROID = 'default';

/**
 * Handle service confirmation
 *
 * @return mixed
 */
public function post_confirm()
{
    //Get service id and driver id  from input
    $service_id = Input::get('service_id');
    $driver_id = Input::get('driver_id');

    //Find the service and driver entities.
    $servicio = Service::find($service_id);
    $driver = Driver::find($driver_id); //The existence of the driver entity should be verified.

    //Check if both the service and driver entities exists. Otherwise, it may be an
    // application error or a malicious request.
    if ($servicio != NULL && $driver != null) {
        //return error code 2 if the status_id of the service is 6
        if ($servicio->status_id == self::$STATUS_6) {
            return $this->generateResponse(2);
        }

        //Return error code 0 if the driver is not assigned to the service and the service
        // status_id is 1.
        //Otherwise, return error code 1.
        if ($servicio->driver_id == null && $servicio->status_id == self::$STATUS_1) {
            //Update the entities and send a message to the customer if a device is registered
            $this->save_and_push($service_id, $driver_id);

            return $this->generateResponse(0);
        } else {
            return $this->generateResponse(1);
        }
    }

    //Return code 3 if the service or driver were not found
    return $this->generateResponse(3);
}

/**
 * Handle the entity update and message generation.
 *
 * @param $service_id
 * @param $driver_id
 */
public function save_and_push($service_id, $driver_id)
{
    //This method should throw an exception if the driver id is not found in the database or
    // the update failed.
    $driver = Driver::update($driver_id, array(
        'available' => self::$NOT_AVAILABLE
    ));

    //This method should throw an exception if the service id is not found in the database or
    // the update failed.
    $servicio = Service::update($service_id, array(
        'driver_id' => $driver_id,
        'status_id' => self::$STATUS_2,
        'car_id' => $driver->carId
    ));

    //Send a message to the user's mobile devices if the customer's device UUID is not empty.
    if ($servicio->user->uuid != '') {
        $this->push($servicio);
    }
}

/**
 * Send the push message to mobile devices
 *
 * @param $servicio
 */
public function push($servicio) {
    //Instantiate the push object
    $push = Push::make();

    //call the appropriate method based on the customer's device.
    if ($servicio->user->type == self::$USER_TYPE_IOS) {
        $push->ios($servicio->user->uuid, self::$PUSH_MESSAGE, self::$SOUND_IOS,
            self::$OPEN_STATUS, array('serviceId' => $servicio->id));
    } else {
        $push->android2($servicio->user->uuid, self::$PUSH_MESSAGE, self::$SOUND_ANDROID,
            self::$OPEN_STATUS, array('serviceId' => $servicio->id));
    }
}

/**
 * Generate response message with a response code
 *
 * @param $code
 * @return mixed
 */
public function generateResponse($code)
{
    return Response::json(array('error' => $code));
}
}
